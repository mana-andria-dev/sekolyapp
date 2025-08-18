<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Submission, Assignment, Student};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    // Élève : liste des devoirs de sa classe
    public function studentIndex(Request $request)
    {
        $student = auth()->user();
        $assignments = Assignment::whereHas('class', fn($q) => $q->whereHas('students', fn($q2) => $q2->where('id', $student->id)))
              ->with('submissions')
              ->latest()
              ->get();
        return view('student.assignments.index', compact('assignments'));
    }

    // Élève : voir un devoir et soumettre
    public function studentShow(Assignment $assignment)
    {
        $student = auth()->user();
        $submission = Submission::firstOrNew([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id
        ]);

        return view('student.assignments.show', compact('assignment','submission'));
    }

    // Élève : soumettre un devoir
    public function submit(Request $request, Assignment $assignment)
    {
        $request->validate([
            'answer' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $student = auth()->user();
        $submission = Submission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => $student->id],
            ['answer' => $request->answer]
        );

        if ($request->hasFile('file')) {
            if ($submission->file_path) Storage::delete($submission->file_path);
            $submission->file_path = $request->file('file')->store('submissions');
            $submission->save();
        }

        return back()->with('success','Devoir soumis avec succès !');
    }

    // Enseignant : liste des soumissions
    public function teacherSubmissions(Assignment $assignment)
    {
        $submissions = $assignment->submissions()->with('student')->get();
        return view('teacher.submissions.index', compact('assignment','submissions'));
    }

    // Enseignant : noter / feedback
    public function grade(Request $request, Assignment $assignment, Submission $submission)
    {
        $request->validate([
            'grade' => 'nullable|numeric|min:0|max:20',
            'feedback' => 'nullable|string|max:1000'
        ]);

        $submission->update($request->only('grade','feedback'));

        return back()->with('success','Note et feedback mis à jour !');
    }
}

