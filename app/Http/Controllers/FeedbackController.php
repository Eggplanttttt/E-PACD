<?php

namespace App\Http\Controllers;

use App\Mail\ThankYouMail;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the data
        $validated = $request->validate([
            'client_type' => 'required|string',
            'date' => 'required|date',
            'campus_transacted' => 'nullable|string',
            'sex_type' => 'nullable|string',
            'age' => 'nullable|integer',
            'contact_no' => 'nullable|string|min:11|max:11',
            'service_availed' => 'nullable|string',
            'CC1' => 'required|integer',
            'CC2' => 'required|integer',
            'CC3' => 'nullable|integer',
            'sqd_answers' => 'required|array',
            'comments' => 'nullable|string',
            'email_address' => 'required|email',
            'name' => 'nullable|string', // optional name field
        ]);

        // Save into database
        $feedback = Feedback::create([
            'client_type' => $validated['client_type'],
            'date' => $validated['date'],
            'campus_transacted' => $validated['campus_transacted'] ?? null,
            'sex_type' => $validated['sex_type'] ?? null,
            'age' => $validated['age'] ?? null,
            'contact_no' => $validated['contact_no'] ?? null,
            'service_availed' => $validated['service_availed'] ?? null,
            'CC1' => $validated['CC1'],
            'CC2' => $validated['CC2'],
            'CC3' => $validated['CC3'] ?? null,
            'sqd_answers' => json_encode($validated['sqd_answers']),
            'comments' => $validated['comments'] ?? null,
            'email_address' => $validated['email_address'],
            'name' => $validated['name'] ?? null,
        ]);

        // Determine name for email
        $nameForEmail = $feedback->name ?? $feedback->email_address;

        // Send Thank You email
        Mail::to($feedback->email_address)->send(new ThankYouMail($nameForEmail));

        return redirect()->back()->with('success', 'Feedback submitted successfully!.');
    }

    // Show all feedback
    public function index()
    {
        $feedbacks = Feedback::all()->map(function ($feedback) {
            $answers = json_decode($feedback->sqd_answers, true);
            if (is_array($answers) && count($answers) > 0) {
                $feedback->average = round(array_sum($answers) / count($answers));
            } else {
                $feedback->average = 'N/A';
            }
            return $feedback;
        });

        $feedbackGroups = $feedbacks
            ->groupBy('client_type')
            ->map(function ($group) {
                $nums = $group->map(function ($f) {
                    return is_numeric($f->average) ? (float) $f->average : null;
                })->filter();

                return $nums->count() > 0 ? round($nums->avg(), 2) : null;
            })
            ->filter()
            ->toArray();

        return view('admin.feedback.index', compact('feedbacks', 'feedbackGroups'));
    }

    public function exportExcel(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $feedbacks = Feedback::whereDate('date', '>=', $validated['start_date'])
            ->whereDate('date', '<=', $validated['end_date'])
            ->orderBy('date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $ratingMap = [
            5 => 'Strongly Agree',
            4 => 'Agree',
            3 => 'Neutral',
            2 => 'Disagree',
            1 => 'Strongly Disagree',
        ];

        $fileName = 'feedback-report-' .
            $validated['start_date'] .
            '-to-' .
            $validated['end_date'] .
            '.xls';

        $start = \Carbon\Carbon::parse($validated['start_date'])->format('m/d/Y');
        $end = \Carbon\Carbon::parse($validated['end_date'])->format('m/d/Y');

        return response()->streamDownload(function () use ($feedbacks, $ratingMap, $start, $end) {
            echo "\xEF\xBB\xBF";
            echo '<html><head><meta charset="UTF-8"></head><body>';
            echo '<table border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse;font-family:Arial,sans-serif;font-size:12px;">';

            echo '<tr><td colspan="20"><strong>Feedback Summary</strong></td></tr>';
            echo '<tr><td colspan="20"><strong>From ' . e($start) . ' - ' . e($end) . '</strong></td></tr>';
            echo '<tr><td colspan="20">&nbsp;</td></tr>';
            echo '<tr>';
            echo '<td colspan="9">&nbsp;</td>';
            echo '<td colspan="9" style="text-align:center;"><strong>Survey Answers:</strong></td>';
            echo '<td colspan="2">&nbsp;</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td><strong>ID</strong></td>';
            echo '<td><strong>Client Type</strong></td>';
            echo '<td><strong>Date:</strong></td>';
            echo '<td><strong>Campus Transacted:</strong></td>';
            echo '<td><strong>Contact Number:</strong></td>';
            echo '<td><strong>Service Availed:</strong></td>';
            echo '<td><strong>CC1:</strong></td>';
            echo '<td><strong>CC2:</strong></td>';
            echo '<td><strong>CC3:</strong></td>';
            echo '<td><strong>SQD1:</strong></td>';
            echo '<td><strong>SQD2:</strong></td>';
            echo '<td><strong>SQD3:</strong></td>';
            echo '<td><strong>SQD4:</strong></td>';
            echo '<td><strong>SQD5:</strong></td>';
            echo '<td><strong>SQD6:</strong></td>';
            echo '<td><strong>SQD7:</strong></td>';
            echo '<td><strong>SQD8:</strong></td>';
            echo '<td><strong>SQD9:</strong></td>';
            echo '<td><strong>Survey Average:</strong></td>';
            echo '<td><strong>Comments:</strong></td>';
            echo '</tr>';

            foreach ($feedbacks as $feedback) {
                $answers = json_decode($feedback->sqd_answers, true) ?? [];
                $sqd = [];
                $numericAnswers = [];

                for ($i = 0; $i < 9; $i++) {
                    $score = $answers[$i] ?? null;
                    if (is_numeric($score)) {
                        $label = $ratingMap[(int) $score] ?? 'N/A';
                        $sqd[] = $label . ' (' . $score . ')';
                        $numericAnswers[] = (int) $score;
                    } else {
                        $sqd[] = 'N/A';
                    }
                }

                $averageWord = 'N/A';
                if (count($numericAnswers) > 0) {
                    $avgScore = (int) round(array_sum($numericAnswers) / count($numericAnswers));
                    $averageWord = $ratingMap[$avgScore] ?? 'N/A';
                }

                $dateCell = $feedback->date ? \Carbon\Carbon::parse($feedback->date)->format('n/j/Y') : 'N/A';

                echo '<tr>';
                echo '<td>' . e((string) $feedback->id) . '</td>';
                echo '<td>' . e((string) ($feedback->client_type ?? 'N/A')) . '</td>';
                echo '<td>' . e($dateCell) . '</td>';
                echo '<td>' . e((string) ($feedback->campus_transacted ?? 'Diffun - Campus')) . '</td>';
                echo '<td>' . e((string) ($feedback->contact_no ?? 'N/A')) . '</td>';
                echo '<td>' . e((string) ($feedback->service_availed ?? 'N/A')) . '</td>';
                echo '<td>' . e((string) ($feedback->CC1 ?? 'N/A')) . '</td>';
                echo '<td>' . e((string) ($feedback->CC2 ?? 'N/A')) . '</td>';
                echo '<td>' . e((string) ($feedback->CC3 ?? 'N/A')) . '</td>';
                echo '<td>' . e($sqd[0]) . '</td>';
                echo '<td>' . e($sqd[1]) . '</td>';
                echo '<td>' . e($sqd[2]) . '</td>';
                echo '<td>' . e($sqd[3]) . '</td>';
                echo '<td>' . e($sqd[4]) . '</td>';
                echo '<td>' . e($sqd[5]) . '</td>';
                echo '<td>' . e($sqd[6]) . '</td>';
                echo '<td>' . e($sqd[7]) . '</td>';
                echo '<td>' . e($sqd[8]) . '</td>';
                echo '<td>' . e($averageWord) . '</td>';
                echo '<td>' . e((string) ($feedback->comments ?? 'N/A')) . '</td>';
                echo '</tr>';
            }

            echo '</table></body></html>';
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }



    // Show detailed feedback
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('admin.feedback.show', compact('feedback'));
    }

    // Delete feedback
    public function destroy($id)
    {
        $feedback = Feedback::find($id);

        if ($feedback) {
            $feedback->delete();
            return redirect()->route('admin.feedback')->with('success', 'Feedback deleted successfully.');
        }

        return redirect()->route('admin.feedback')->with('error', 'Feedback not found.');
    }
}
