<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\InquiriesController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminInquiryController;
use App\Http\Controllers\StudentChatController;
use App\Http\Controllers\FacultyChatController; 
use App\Http\Controllers\AlumniChatController;
use App\Http\Controllers\OthersChatController;
use App\Http\Controllers\StudentSettingsController;
use App\Http\Controllers\FacultySettingsController;
use App\Http\Controllers\AlumniSettingsController;
use App\Http\Controllers\OthersSettingsController;
use App\Http\Controllers\StudentPasswordController;
use App\Http\Controllers\FacultyPasswordController;
use App\Http\Controllers\AlumniPasswordController;
use App\Http\Controllers\OthersPasswordController;
use App\Http\Controllers\Auth\OthersProfileController;
use App\Http\Controllers\OthersComplaintController;
use App\Http\Controllers\OthersNotificationController;
use App\Http\Controllers\StudentNotificationController;
use App\Http\Controllers\StudentComplaintController;
use App\Http\Controllers\FacultyNotificationController;
use App\Http\Controllers\FacultyComplaintController;
use App\Http\Controllers\AlumniNotificationController;
use App\Http\Controllers\AlumniComplaintController;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', function () {
//     return 'HOME OK';
// })->name('home');

// Route::get('/health-test', function () {
//     return 'HEALTH OK';
// });
// use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     if (Auth::guard('admin')->check()) {
//         return redirect()->route('admin.dashboard');
//     }

//     return response()
//         ->view('landing-page')
//         ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
//         ->header('Pragma', 'no-cache')
//         ->header('Expires', '0');
// })->name('home');

Route::get('/', fn() => view('landing-page'))->name('home');

Route::get('/citizen-charter', fn() => view('citizen_charter'))->name('citizen.charter');
Route::get('/complaints', fn() => view('complaint_page'))->name('complaint.page');

Route::get('/feedback', fn() => view('feedback'))->name('feedback.form');
Route::post('/feedback-submit', [FeedbackController::class, 'submit'])->name('feedback.submit');

Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaint.store');

Route::get('/inquiries', [InquiriesController::class, 'show'])->name('inquiries.page');

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| Client Login
|--------------------------------------------------------------------------
*/

Route::prefix('login')->group(function () {
    Route::get('/{clientType}', [RegistrationController::class, 'showLoginForm'])->name('client.login');
    Route::post('/{clientType}', [RegistrationController::class, 'login'])->name('client.login.post');
});


Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register/select', fn() => view('registers.select'))->name('register.select');

Route::get('/register/{clientType}', [RegistrationController::class, 'showRegisterForm'])
    ->where('clientType', 'student|faculty|alumni|others')
    ->name('register.form');

/*
|--------------------------------------------------------------------------
| Client Dashboards
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:student'])
    ->get('/client/dashboard/student', [ClientController::class, 'studentDashboard'])
    ->name('client.dashboard.student');

Route::middleware(['auth:faculty'])
    ->get('/client/dashboard/faculty', [ClientController::class, 'facultyDashboard'])
    ->name('client.dashboard.faculty');

Route::middleware(['auth:alumni'])
    ->get('/client/dashboard/alumni', [ClientController::class, 'alumniDashboard'])
    ->name('client.dashboard.alumni');

Route::middleware(['auth:others'])
    ->get('/client/dashboard/others', [ClientController::class, 'othersDashboard'])
    ->name('client.dashboard.others');

/*
|--------------------------------------------------------------------------
| Messaging
|--------------------------------------------------------------------------
*/

// Student
Route::post('/client/send-message', [StudentChatController::class, 'sendMessage'])->name('client.sendMessage');
Route::get('/client/get-messages', [StudentChatController::class, 'getMessages'])->name('client.getMessages');

// Faculty
Route::middleware(['auth:faculty'])->group(function () {
    Route::get('/faculty/messages', [FacultyChatController::class, 'getMessages'])->name('faculty.getMessages');
    Route::post('/faculty/messages', [FacultyChatController::class, 'sendMessage'])->name('faculty.sendMessage');
});

// Alumni
Route::middleware(['auth:alumni'])->group(function () {
    Route::get('/alumni/messages', [AlumniChatController::class, 'getMessages'])->name('alumni.getMessages');
    Route::post('/alumni/messages', [AlumniChatController::class, 'sendMessage'])->name('alumni.sendMessage');
});

// Others
Route::middleware(['auth:others'])->group(function () {
    Route::get('/others/messages', [OthersChatController::class, 'getMessages'])->name('others.getMessages');
    Route::post('/others/messages', [OthersChatController::class, 'sendMessage'])->name('others.sendMessage');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'processLogin'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])
        ->name('logout')
        ->middleware('auth:admin');
});


/*
|--------------------------------------------------------------------------
| Super Admin Dashboard (SUPER_ADMIN ONLY)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin', 'role:super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

    Route::get('/client-chats-count', [AdminController::class, 'getClientChatsCount'])->name('client-chats-count');
    Route::get('/complaints-count', [AdminController::class, 'getComplaintsCount'])->name('complaints.count');

    /*
    |--------------------------------------------------------------------------
    | Admin Inquiries
    |--------------------------------------------------------------------------
    */
    Route::prefix('inquiries')->name('inquiries.')->group(function () {

        Route::get('/', [AdminInquiryController::class, 'index'])->name('index');

        Route::get('/messages/{clientType}/{clientId}', [AdminInquiryController::class, 'getMessages'])
            ->where(['clientType' => '[A-Za-z]+', 'clientId' => '[0-9]+'])
            ->name('getMessages');

        Route::post('/send', [AdminInquiryController::class, 'send'])->name('send');

        Route::get('/unread-counts', [AdminInquiryController::class, 'unreadCounts'])->name('unread-counts');

        Route::post('/mark-as-read/{clientType}/{clientId}', [AdminInquiryController::class, 'markAsRead'])
            ->where(['clientType' => '[A-Za-z]+', 'clientId' => '[0-9]+'])
            ->name('markAsRead');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Profile CRUD
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::post('/add', [AdminController::class, 'addProfile'])->name('add');
        Route::put('/edit/{id}', [AdminController::class, 'update'])->name('edit');
        Route::delete('/{id}', [AdminController::class, 'deleteProfile'])->name('delete');
    });

    Route::get('/profiles', [AdminController::class, 'fetchProfiles'])->name('profiles');
    Route::get('/profile/{id}', [AdminController::class, 'getProfile'])->name('profile.get');

    /*
    |--------------------------------------------------------------------------
    | Admin Feedback
    |--------------------------------------------------------------------------
    */
    Route::prefix('feedback')->name('feedback.')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('index');          // admin.feedback.index
        Route::get('/export/excel', [FeedbackController::class, 'exportExcel'])->name('export.excel');
        Route::get('/{id}', [FeedbackController::class, 'show'])->name('show');        // admin.feedback.show
        Route::delete('/{id}', [FeedbackController::class, 'destroy'])->name('destroy'); // admin.feedback.destroy
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Complaints
    |--------------------------------------------------------------------------
    */
    Route::prefix('complaints')->name('complaints.')->group(function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('index');             // admin.complaints.index
        Route::get('/{id}/accept', [ComplaintController::class, 'accept'])->name('accept'); // admin.complaints.accept
        Route::post('/{id}/reject', [ComplaintController::class, 'reject'])->name('reject'); // admin.complaints.reject
        Route::post('/{id}/reply', [ComplaintController::class, 'reply'])->name('reply');   // admin.complaints.reply

        Route::get('/solved', [ComplaintController::class, 'solvedList'])->name('solved');       // admin.complaints.solved
        Route::get('/rejected', [ComplaintController::class, 'rejectedList'])->name('rejected'); // admin.complaints.rejected
        Route::get('/reviewing', [ComplaintController::class, 'reviewingComplaints'])->name('reviewing'); // admin.complaints.reviewing
    });

    Route::get('/process', [AdminController::class, 'process'])->name('process');
});

/*
|--------------------------------------------------------------------------
| Google Auth
|--------------------------------------------------------------------------
*/

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/admin/show/{id}', [AdminController::class, 'show'])->name('admin.show');

Route::get('/test-email', function () {
    Mail::to('ezekielcadiz01@gmail.com')->send(new App\Mail\ThankYouMail('Test User'));
    return 'Email sent';
});

/*
|--------------------------------------------------------------------------
|    SETTINGS ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:student'])->prefix('student')->group(function () {
    Route::get('/settings', [StudentSettingsController::class, 'index'])->name('student.settings');
    Route::put('/settings/update-password', [StudentSettingsController::class, 'updatePassword'])
         ->name('student.settings.updatePassword');
});

Route::middleware(['auth:faculty'])->prefix('faculty')->group(function () {
    Route::get('/settings', [FacultySettingsController::class, 'index'])->name('faculty.settings');
    Route::put('/settings/update-password', [FacultySettingsController::class, 'updatePassword'])
         ->name('faculty.settings.updatePassword');
});

Route::middleware(['auth:alumni'])->prefix('alumni')->group(function () {
    Route::get('/settings', [AlumniSettingsController::class, 'index'])->name('alumni.settings');
    Route::put('/settings/update-password', [AlumniSettingsController::class, 'updatePassword'])
         ->name('alumni.settings.updatePassword');
});

Route::middleware(['auth:others'])->prefix('others')->group(function () {
    Route::get('/settings', [OthersSettingsController::class, 'index'])->name('others.settings');
    Route::put('/settings/update-password', [OthersSettingsController::class, 'updatePassword'])
         ->name('others.settings.updatePassword');
});



// otp

Route::post('/student/send-otp', [RegistrationController::class, 'sendOtp'])->name('student.sendOtp');
Route::post('/student/verify-otp', [RegistrationController::class, 'verifyOtp'])->name('student.verifyOtp');
Route::post('/register/store', [RegistrationController::class, 'store'])->name('register.store');
Route::post('/student/check-email', [RegistrationController::class, 'checkEmail'])->name('student.checkEmail');

// Faculty OTP Routes
Route::post('/faculty/send-otp', [RegistrationController::class, 'sendFacultyOtp'])->name('faculty.sendOtp');
Route::post('/faculty/verify-otp', [RegistrationController::class, 'verifyFacultyOtp'])->name('faculty.verifyOtp');
Route::post('/faculty/check-email', [RegistrationController::class, 'checkEmail'])->name('faculty.checkEmail');

// Alumni routes
Route::post('/alumni/check-email', [RegistrationController::class, 'checkEmail'])->name('alumni.checkEmail');
Route::post('/alumni/send-otp', [RegistrationController::class, 'sendAlumniOtp'])->name('alumni.sendOtp');
Route::post('/alumni/verify-otp', [RegistrationController::class, 'verifyAlumniOtp'])->name('alumni.verifyOtp');

// Others routes
Route::post('/others/send-otp', [RegistrationController::class, 'sendOthersOtp'])->name('others.sendOtp');
Route::post('/others/verify-otp', [RegistrationController::class, 'verifyOthersOtp'])->name('others.verifyOtp');
Route::post('/others/check-email', [RegistrationController::class, 'checkEmail'])->name('others.checkEmail');


Route::post('/send-otp', [ComplaintController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [ComplaintController::class, 'verifyOtp'])->name('verify.otp');

Route::get('/check-id/{idnumber}', [RegistrationController::class, 'checkId']);


Route::post('/admin/inquiries/mark-solved', [AdminController::class, 'markSolved'])
    ->name('admin.inquiries.mark-solved');

Route::get('/admin/solved-clients-count', [AdminController::class, 'getSolvedClientsCount']);


Route::get('/admin/complaints-count', [AdminController::class, 'getComplaintsCount']);

Route::post('/admin/complaints/{id}/solve', [ComplaintController::class, 'markAsSolved'])->name('admin.complaint.solve');


Route::post('/admin/heartbeat', function() {
    $admin = auth('admin')->user();
    if ($admin instanceof \App\Models\AdminAccount) {
        $admin->last_active_at = now();
        $admin->is_online = 1;
        $admin->save();
    }
    return response()->json(['success' => true]);
})->middleware('auth:admin');


Route::get('/clients', [AdminInquiryController::class, 'fetchClients'])
    ->middleware('auth:admin');


//student reset
Route::prefix('student')->group(function () {

    Route::get('/forgot-password', function () {
        return view('auth.student-forgot-password');
    })->name('student.password.forgot');

    Route::post('/forgot-password/verify', [StudentPasswordController::class, 'verifyEmail'])
        ->name('student.password.verify');

        

    Route::post('/forgot-password/reset', [StudentPasswordController::class, 'resetPassword'])
        ->name('student.password.reset');

});

Route::get('/student/password/otp', [StudentPasswordController::class, 'showOtpForm'])->name('student.password.otp.form');
Route::post('/student/password/otp', [StudentPasswordController::class, 'verifyOtp'])->name('student.password.otp.verify');
Route::get('/student/password/reset', [StudentPasswordController::class, 'showResetForm'])->name('student.password.reset.form');
Route::post('/student/password/reset', [StudentPasswordController::class, 'resetPassword'])->name('student.password.reset');
Route::get('/student/password/forgot', [StudentPasswordController::class, 'showForgotPasswordForm'])
     ->name('student.password.forgot');



//faculty reset
Route::prefix('faculty')->group(function () {

    Route::get('/forgot-password', function () {
        return view('auth.faculty-forgot-password');
    })->name('faculty.password.forgot');

    Route::post('/forgot-password/verify', [FacultyPasswordController::class, 'verifyEmail'])
        ->name('faculty.password.verify');

        

    Route::post('/forgot-password/reset', [FacultyPasswordController::class, 'resetPassword'])
        ->name('faculty.password.reset');

});

Route::get('/faculty/password/otp', [FacultyPasswordController::class, 'showOtpForm'])->name('faculty.password.otp.form');
Route::post('/faculty/password/otp', [FacultyPasswordController::class, 'verifyOtp'])->name('faculty.password.otp.verify');
Route::get('/faculty/password/reset', [FacultyPasswordController::class, 'showResetForm'])->name('faculty.password.reset.form');
Route::post('/faculty/password/reset', [FacultyPasswordController::class, 'resetPassword'])->name('faculty.password.reset');
Route::get('/faculty/password/forgot', [FacultyPasswordController::class, 'showForgotPasswordForm'])
     ->name('faculty.password.forgot');


//alumni reset
Route::prefix('alumni')->group(function () {

    Route::get('/forgot-password', function () {
        return view('auth.alumni-forgot-password');
    })->name('alumni.password.forgot');

    Route::post('/forgot-password/verify', [AlumniPasswordController::class, 'verifyEmail'])
        ->name('alumni.password.verify');

        

    Route::post('/forgot-password/reset', [AlumniPasswordController::class, 'resetPassword'])
        ->name('alumni.password.reset');

});

Route::get('/alumni/password/otp', [AlumniPasswordController::class, 'showOtpForm'])->name('alumni.password.otp.form');
Route::post('/alumni/password/otp', [AlumniPasswordController::class, 'verifyOtp'])->name('alumni.password.otp.verify');
Route::get('/alumni/password/reset', [AlumniPasswordController::class, 'showResetForm'])->name('alumni.password.reset.form');
Route::post('/alumni/password/reset', [AlumniPasswordController::class, 'resetPassword'])->name('alumni.password.reset');
Route::get('/alumni/password/forgot', [AlumniPasswordController::class, 'showForgotPasswordForm'])
     ->name('alumni.password.forgot');


//others reset
Route::prefix('others')->group(function () {

    Route::get('/forgot-password', function () {
        return view('auth.others-forgot-password');
    })->name('others.password.forgot');

    Route::post('/forgot-password/verify', [OthersPasswordController::class, 'verifyEmail'])
        ->name('others.password.verify');

        

    Route::post('/forgot-password/reset', [OthersPasswordController::class, 'resetPassword'])
        ->name('others.password.reset');

});

Route::get('/others/password/otp', [OthersPasswordController::class, 'showOtpForm'])->name('others.password.otp.form');
Route::post('/others/password/otp', [OthersPasswordController::class, 'verifyOtp'])->name('others.password.otp.verify');
Route::get('/others/password/reset', [OthersPasswordController::class, 'showResetForm'])->name('others.password.reset.form');
Route::post('/others/password/reset', [OthersPasswordController::class, 'resetPassword'])->name('others.password.reset');
Route::get('/others/password/forgot', [OthersPasswordController::class, 'showForgotPasswordForm'])
     ->name('others.password.forgot');



/*
|--------------------------------------------------------------------------
| IO Dashboard (IO ONLY)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin', 'role:io'])
    ->prefix('io')
    ->name('io.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'ioDashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        //  IO Inquiries (page + ajax endpoints)
        Route::prefix('inquiries')->name('inquiries.')->group(function () {

            // page
            Route::get('/', [AdminInquiryController::class, 'ioIndex'])->name('index');

            // ajax endpoints used by JS
            Route::get('/messages/{clientType}/{clientId}', [AdminInquiryController::class, 'getMessages'])
                ->where(['clientType' => '[A-Za-z]+', 'clientId' => '[0-9]+'])
                ->name('getMessages');

            Route::post('/send', [AdminInquiryController::class, 'send'])->name('send');

            Route::get('/unread-counts', [AdminInquiryController::class, 'unreadCounts'])->name('unreadCounts');

            Route::post('/mark-as-read/{clientType}/{clientId}', [AdminInquiryController::class, 'markAsRead'])
                ->where(['clientType' => '[A-Za-z]+', 'clientId' => '[0-9]+'])
                ->name('markAsRead');

            Route::post('/mark-solved', [AdminInquiryController::class, 'markSolved'])->name('markSolved');
        });

        Route::get('/profile', [AdminController::class, 'ioProfiles'])->name('profile');
        Route::post('/profile/add', [AdminController::class, 'addIoProfile'])->name('profile.add');
        Route::put('/profile/edit/{id}', [AdminController::class, 'updateIoProfile'])->name('profile.edit');
        Route::delete('/profile/delete/{id}', [AdminController::class, 'deleteIoProfile'])->name('profile.delete');
    });


Route::middleware(['auth:admin', 'role:audit'])
    ->prefix('audit')
    ->name('audit.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'auditDashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        //
        Route::get('/profile', [AdminController::class, 'auditProfiles'])->name('profile');
        Route::post('/profile/add', [AdminController::class, 'addAuditProfile'])->name('profile.add');
        Route::put('/profile/{id}/edit', [AdminController::class, 'updateAuditProfile'])->name('profile.edit');
        Route::delete('/profile/{id}/delete', [AdminController::class, 'deleteAuditProfile'])->name('profile.delete');

        // Complaints pages
        Route::get('/complaints', [AdminController::class, 'auditComplaints'])->name('complaints.index');
        Route::get('/complaints/rejected', [AdminController::class, 'auditRejectedComplaints'])->name('complaints.rejected');
        Route::get('/complaints/solved', [AdminController::class, 'auditSolvedComplaints'])->name('complaints.solved');

        //
        Route::post('/complaints/{id}/solve', [AdminController::class, 'auditMarkComplaintSolved'])->name('complaints.solve');
        Route::post('/complaints/{id}/reject', [AdminController::class, 'auditRejectComplaint'])->name('complaints.reject');

        // Feedback
        Route::get('/feedback', [AdminController::class, 'auditFeedback'])->name('feedback.index');
        Route::get('/feedback/export/excel', [FeedbackController::class, 'exportExcel'])->name('feedback.export.excel');
    });



    Route::get('/auth/facebook', [FacebookAuthController::class, 'redirect'])
    ->name('facebook.redirect');

    Route::get('/auth/facebook/callback', [FacebookAuthController::class, 'callback'])
        ->name('facebook.callback');

    Route::post('/others/complete-profile', [\App\Http\Controllers\Auth\OthersProfileController::class, 'store'])
    ->name('others.completeProfile')
    ->middleware('auth');

    Route::post('/others/complete-profile', [OthersProfileController::class, 'store'])
    ->name('others.completeProfile');

    


    Route::middleware(['auth:others'])->group(function () {

    Route::post('/others/complaints', [OthersComplaintController::class, 'store'])
        ->name('others.complaints.store');

    Route::get('/others/notifications', [OthersNotificationController::class, 'index'])
        ->name('others.notifications');

    Route::post('/others/notifications/mark-read', [OthersNotificationController::class, 'markRead'])
        ->name('others.notifications.markRead');
    
    Route::delete('/others/notifications/delete-read', [OthersNotificationController::class, 'deleteRead'])
    ->name('others.notifications.deleteRead');

    });


    Route::middleware(['auth:student'])->group(function () {

    Route::post('/student/complaints', [StudentComplaintController::class, 'store'])
        ->name('student.complaints.store');

    Route::get('/student/notifications', [StudentNotificationController::class, 'index'])
        ->name('student.notifications');

    Route::post('/student/notifications/mark-read', [StudentNotificationController::class, 'markRead'])
        ->name('student.notifications.markRead');
    
    Route::delete('/student/notifications/delete-read', [StudentNotificationController::class, 'deleteRead'])
    ->name('student.notifications.deleteRead');

    });

    Route::middleware(['auth:faculty'])->group(function () {

    Route::post('/faculty/complaints', [FacultyComplaintController::class, 'store'])
        ->name('faculty.complaints.store');

    Route::get('/faculty/notifications', [FacultyNotificationController::class, 'index'])
        ->name('faculty.notifications');

    Route::post('/faculty/notifications/mark-read', [FacultyNotificationController::class, 'markRead'])
        ->name('faculty.notifications.markRead');
    
    Route::delete('/faculty/notifications/delete-read', [FacultyNotificationController::class, 'deleteRead'])
    ->name('faculty.notifications.deleteRead');

    });

    Route::middleware(['auth:alumni'])->group(function () {

    Route::post('/alumni/complaints', [AlumniComplaintController::class, 'store'])
        ->name('alumni.complaints.store');

    Route::get('/alumni/notifications', [AlumniNotificationController::class, 'index'])
        ->name('alumni.notifications');

    Route::post('/alumni/notifications/mark-read', [AlumniNotificationController::class, 'markRead'])
        ->name('alumni.notifications.markRead');
    
    Route::delete('/alumni/notifications/delete-read', [AlumniNotificationController::class, 'deleteRead'])
    ->name('alumni.notifications.deleteRead');

    });

    Route::middleware(['auth:student', 'ban:Student'])->group(function () {

        Route::get('/client/dashboard/student', [ClientController::class, 'studentDashboard'])
            ->name('client.dashboard.student');

        Route::post('/student/complaints', [StudentComplaintController::class, 'store'])
            ->name('student.complaints.store');

        Route::post('/client/send-message', [StudentChatController::class, 'sendMessage'])
            ->name('client.sendMessage');

        Route::get('/client/get-messages', [StudentChatController::class, 'getMessages'])
            ->name('client.getMessages');

        Route::get('/student/notifications', [StudentNotificationController::class, 'index'])
            ->name('student.notifications');

        Route::post('/student/notifications/mark-read', [StudentNotificationController::class, 'markRead'])
            ->name('student.notifications.markRead');

        Route::delete('/student/notifications/delete-read', [StudentNotificationController::class, 'deleteRead'])
            ->name('student.notifications.deleteRead');
    });


    Route::middleware(['auth:faculty', 'ban:Faculty'])->group(function () {
        Route::get('/client/dashboard/faculty', [ClientController::class, 'facultyDashboard'])->name('client.dashboard.faculty');
        Route::post('/faculty/complaints', [FacultyComplaintController::class, 'store'])->name('faculty.complaints.store');
        Route::get('/faculty/notifications', [FacultyNotificationController::class, 'index'])->name('faculty.notifications');
        Route::post('/faculty/notifications/mark-read', [FacultyNotificationController::class, 'markRead'])->name('faculty.notifications.markRead');
        Route::delete('/faculty/notifications/delete-read', [FacultyNotificationController::class, 'deleteRead'])->name('faculty.notifications.deleteRead');
    });

    Route::middleware(['auth:alumni', 'ban:Alumni'])->group(function () {
        Route::get('/client/dashboard/alumni', [ClientController::class, 'alumniDashboard'])->name('client.dashboard.alumni');
        Route::post('/alumni/complaints', [AlumniComplaintController::class, 'store'])->name('alumni.complaints.store');
        Route::get('/alumni/notifications', [AlumniNotificationController::class, 'index'])->name('alumni.notifications');
        Route::post('/alumni/notifications/mark-read', [AlumniNotificationController::class, 'markRead'])->name('alumni.notifications.markRead');
        Route::delete('/alumni/notifications/delete-read', [AlumniNotificationController::class, 'deleteRead'])->name('alumni.notifications.deleteRead');
    });

    Route::middleware(['auth:others', 'ban:Others'])->group(function () {
        Route::get('/client/dashboard/others', [ClientController::class, 'othersDashboard'])->name('client.dashboard.others');
        Route::post('/others/complaints', [OthersComplaintController::class, 'store'])->name('others.complaints.store');
        Route::get('/others/notifications', [OthersNotificationController::class, 'index'])->name('others.notifications');
        Route::post('/others/notifications/mark-read', [OthersNotificationController::class, 'markRead'])->name('others.notifications.markRead');
        Route::delete('/others/notifications/delete-read', [OthersNotificationController::class, 'deleteRead'])->name('others.notifications.deleteRead');
    });


    Route::get('/admin/complaints/solved/export', [ComplaintController::class, 'exportSolvedExcel'])
    ->name('admin.complaints.solved.export');



