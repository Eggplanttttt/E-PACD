<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Alumni;
use App\Models\Other;

class RegistrationController extends Controller
{
    // Send OTP to email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required','email', function($attr, $value, $fail){
                if(!str_ends_with($value, '@libris.qsu.edu.ph')){
                    $fail('You must use your official QSU Libris email.');
                }
            }]
        ]);

        $otp = rand(100000, 999999);
        $email = $request->email;

        // Store OTP in cache for 5 mins
        Cache::put("student_otp_$email", $otp, now()->addMinutes(5));

        // Send OTP email
        Mail::to($email)->send(new \App\Mail\OtpMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent. Check your email.'
        ]);

    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6'
        ]);

        $cachedOtp = Cache::get("student_otp_{$request->email}");

        if(!$cachedOtp || $cachedOtp != $request->otp){
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP.'
            ], 422);
        }

        Cache::forget("student_otp_{$request->email}");

        // Mark email as verified
        session(['verified_email' => $request->email]);

        return response()->json([
            'success' => true,
            'message' => 'OTP verified. You may proceed.'
        ]);
    }

    // Send OTP to faculty email
    public function sendFacultyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required','email', function($attr, $value, $fail){
                // Optional: restrict to official faculty emails if needed
                // if(!str_ends_with($value, '@libris.qsu.edu.ph')){
                //     $fail('You must use your official QSU Libris email.');
                // }
            }]
        ]);

        $otp = rand(100000, 999999);
        $email = $request->email;

        // Store OTP in cache for 5 mins
        Cache::put("faculty_otp_$email", $otp, now()->addMinutes(5));

        // Send OTP email
        Mail::to($email)->send(new \App\Mail\OtpMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent. Check your email.'
        ]);
    }

    // Verify OTP for faculty
    public function verifyFacultyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6'
        ]);

        $cachedOtp = Cache::get("faculty_otp_{$request->email}");

        if(!$cachedOtp || $cachedOtp != $request->otp){
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP.'
            ], 422);
        }

        Cache::forget("faculty_otp_{$request->email}");

        // Mark faculty email as verified
        session(['verified_faculty_email' => $request->email]);

        return response()->json([
            'success' => true,
            'message' => 'OTP verified. You may proceed.'
        ]);
    }

    // Send OTP to Alumni Gmail
    public function sendAlumniOtp(Request $request)
    {
        $request->validate([
            'email' => ['required','email', function($attr, $value, $fail){
                if(!str_ends_with($value, '@libris.qsu.edu.ph')){
                    $fail('You must use a Libris account.');
                }
            }]
        ]);

        $otp = rand(100000, 999999);
        $email = $request->email;

        Cache::put("alumni_otp_$email", $otp, now()->addMinutes(5));

        Mail::to($email)->send(new \App\Mail\OtpMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent. Check your Gmail.'
        ]);
    }

    // Verify Alumni OTP
    public function verifyAlumniOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6'
        ]);

        $cachedOtp = Cache::get("alumni_otp_{$request->email}");

        if(!$cachedOtp || $cachedOtp != $request->otp){
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP.'
            ], 422);
        }

        Cache::forget("alumni_otp_{$request->email}");

        // Mark alumni email as verified
        session(['verified_email' => $request->email]); // matches what store() checks


        return response()->json([
            'success' => true,
            'message' => 'OTP verified. You may proceed.'
        ]);
    }


    // Send OTP to Others (Visitors) Gmail
    public function sendOthersOtp(Request $request)
    {
        $request->validate([
            'email' => ['required','email', function($attr, $value, $fail){
                if(!str_ends_with($value, '@gmail.com')){
                    $fail('You must use a Gmail account.');
                }
            }]
        ]);

        $otp = rand(100000, 999999);
        $email = $request->email;

        // Store OTP in cache for 5 mins
        Cache::put("others_otp_$email", $otp, now()->addMinutes(5));

        // Send OTP email
        Mail::to($email)->send(new \App\Mail\OtpMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent. Check your Gmail.'
        ]);
    }


    // Verify Others (Visitors) OTP
    public function verifyOthersOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6'
        ]);

        $cachedOtp = Cache::get("others_otp_{$request->email}");

        if(!$cachedOtp || $cachedOtp != $request->otp){
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP.'
            ], 422);
        }

        Cache::forget("others_otp_{$request->email}");

        // Mark email as verified
        session(['verified_email' => $request->email]);

        return response()->json([
            'success' => true,
            'message' => 'OTP verified. You may proceed.'
        ]);
    }





    /**
     * Handle user registration
     */
    public function store(Request $request)
{
    // Determine client type
    $request->validate([
        'client_type' => 'required|in:student,faculty,alumni,others',
    ]);
    $type = $request->client_type;

    // Check if email was verified
    $sessionKey = $type === 'faculty' ? 'verified_faculty_email' : 'verified_email';
    if (session($sessionKey) !== $request->email) {
        return back()->withErrors(['email' => 'Please verify your email before registering.']);
    }

    // Handle "Other" course for alumni
    if ($type === 'alumni' && $request->filled('other_course_alumni')) {
        $request->merge(['course_alumni' => $request->input('other_course_alumni')]);
    }

    // Get model and table
    $model = $this->getModelForClientType($type);
    $table = $this->getTableForClientType($type);

    // Base validation rules
    $rules = [
        'first_name'     => 'required|string|max:255',
        'middle_initial' => 'nullable|string|max:2',
        'last_name'      => 'required|string|max:255',
        'suffix'         => 'nullable|string|max:10',
        'email' => [
            'required',
            'email',
            'max:255',
            function ($attribute, $value, $fail) {
                $exists = Student::where('email', $value)->exists() ||
                          Faculty::where('email', $value)->exists() ||
                          Alumni::where('email', $value)->exists() ||
                          Other::where('email', $value)->exists();
                if ($exists) {
                    $fail('This email is already registered.');
                }
            },
        ],
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
        ],
    ];

    // Merge client-type-specific rules
    $rules = array_merge($rules, $this->getValidationRulesForClientType($type));

    // Custom messages
    $messages = [
        'password.regex' => 'Password must have at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.',
    ];

    // Validate
    $validated = $request->validate($rules, $messages);

    // Prepare base data
    $data = [
        'client_type' => $type,
        'email'       => $validated['email'],
        'password'    => Hash::make($validated['password']),
    ];

    // Merge additional fields including first/middle/last/suffix
    $extra = $this->getAdditionalFieldsForClientType($validated, $type);
    $extra = array_merge($extra, [
        'first_name'     => $validated['first_name'],
        'middle_initial' => $validated['middle_initial'] ?? null,
        'last_name'      => $validated['last_name'],
        'suffix'         => $validated['suffix'] ?? null,
    ]);

    // Create user
    $user = $model::create(array_merge($data, $extra));

    // Save session
    session([
        'client_type' => $type,
        'client_id'   => $user->id,
    ]);

    // Optionally, remove verified email from session
    session()->forget($sessionKey);

    return redirect()->route('inquiries.page')
                    ->with('success', 'You have successfully registered!');
}


public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $password = $this->input('password');

        $hints = [];
        if (preg_match('/[A-Z]/', $password)) $hints[] = 'uppercase letter';
        if (preg_match('/[a-z]/', $password)) $hints[] = 'lowercase letter';
        if (preg_match('/\d/', $password)) $hints[] = 'number';
        if (preg_match('/[\W_]/', $password)) $hints[] = 'special character';

        if ($hints) {
            session()->flash('password_hints', 'Nice! Your password includes: ' . implode(', ', $hints));
        }
    });
}




    /**
     * Show registration form for a specific client type
     */
    public function showRegisterForm($clientType)
    {
        $allowed = ['student', 'faculty', 'alumni', 'others'];
        if (!in_array($clientType, $allowed)) abort(404);

        return view("registers.$clientType");
    }

    /**
     * Handle login for a specific client type
     */

    public function showLoginForm($clientType)
    {
        return view("inquiries");
    }

    public function login(Request $request, $clientType)
    {
        $validTypes = ['student', 'faculty', 'alumni', 'others'];
        if (!in_array($clientType, $validTypes)) {
            return back()->withErrors(['error' => 'Invalid client type.']);
        }

        $credentials = $request->only('username_or_email', 'password');

        $fieldType = match ($clientType) {
            'faculty' => filter_var($credentials['username_or_email'], FILTER_VALIDATE_EMAIL)
                            ? 'email' 
                            : 'facultyId',
            default   => filter_var($credentials['username_or_email'], FILTER_VALIDATE_EMAIL)
                        ? 'email'
                        : 'idnumber',
        };


        $guards = [
            'student' => 'student',
            'faculty' => 'faculty',
            'alumni'  => 'alumni',
            'others'  => 'others',
        ];

        if (Auth::guard($guards[$clientType])->attempt([
            $fieldType  => $credentials['username_or_email'],
            'password'  => $credentials['password'],
        ])) {
            $user = Auth::guard($guards[$clientType])->user();
            session([
                'client_type' => $clientType,
                'client_id'   => $user->id,
            ]);
            return redirect()->route("client.dashboard.$clientType");
        }

        return back()->withErrors(['username_or_email' => 'Wrong username or email'])->withInput();
    }

    protected function getModelForClientType($type)
    {
        return match ($type) {
            'student' => Student::class,
            'faculty' => Faculty::class,
            'alumni'  => Alumni::class,
            'others'  => Other::class,
            default   => throw new \Exception('Invalid client type'),
        };
    }

    protected function getTableForClientType($type)
    {
        return match ($type) {
            'student' => 'students',
            'faculty' => 'faculty',
            'alumni'  => 'alumni',
            'others'  => 'others',
            default   => throw new \Exception('Invalid client type'),
        };
    }

    protected function getValidationRulesForClientType($type)
    {
        return match ($type) {

            'student' => [
                'idnumber' => [
                    'required',
                    // 12-1234 or 12-12345 (dash optional)
                    'regex:/^\d{2}-?\d{4,5}$/',
                    function($attribute, $value, $fail) {
                        $value = trim($value);

                        if (
                            Student::where('idnumber', $value)->exists() ||
                            Faculty::where('facultyId', $value)->exists()
                        ) {
                            $fail('This ID number is already in use by a student or faculty.');
                        }
                    }
                ],
                'course_year' => 'required|string|max:255',
            ],

            'faculty' => [
                'facultyId' => [
                    'required',
                    // D-1234 or D-12345 (case-insensitive)
                    'regex:/^D-\d{4,5}$/i',
                    function($attribute, $value, $fail) {
                        $value = strtoupper(trim($value)); // normalize D-...

                        if (
                            Faculty::whereRaw('UPPER(facultyId) = ?', [$value])->exists() ||
                            Student::where('idnumber', $value)->exists()
                        ) {
                            $fail('This Faculty ID is already in use by a student or faculty.');
                        }
                    }
                ],
                'department_unit' => 'required|string|max:255',
            ],

            'alumni' => [
                'gradyear' => 'required|numeric',
                'course_alumni' => 'required|string|max:255',
            ],

            'others' => [
                'address' => 'required|string|max:255',
            ],

            default => [],
        };
    }

    protected function getAdditionalFieldsForClientType($validated, $type)
    {
        return match ($type) {
            'student' => [
                'idnumber'       => $validated['idnumber'],
                'course_year'    => $validated['course_year'],
                'first_name'     => $validated['first_name'] ?? '',
                'middle_initial' => $validated['middle_initial'] ?? null,
                'last_name'      => $validated['last_name'] ?? '',
                'suffix'         => $validated['suffix'] ?? null,
            ],
            'faculty' => [
                'facultyId'  => $validated['facultyId'],
                'department' => $validated['department_unit'], // use the value from the select/input
            ],
            'alumni' => [
                'gradyear' => $validated['gradyear'],
                'course'   => $validated['course_alumni'],
            ],
            'others' => [
                'address' => $validated['address'],
            ],
            default => [],
        };
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $exists = Student::where('email', $request->email)->exists() ||
                Faculty::where('email', $request->email)->exists() ||
                Alumni::where('email', $request->email)->exists() ||
                Other::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }



    public function checkId($idnumber)
    {
        // Check both Student ID and Faculty ID
        $exists = Student::where('idnumber', $idnumber)->exists() ||
                Faculty::where('facultyId', $idnumber)->exists();

        return response()->json(['exists' => $exists]);
    }



}
