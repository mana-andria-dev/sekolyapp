<?php

namespace App\Http\Controllers\Admin;

use App\Models\StudentGrade;
use App\Models\Student;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    public function index()
    {
        // Toutes les notes avec leurs relations
        $grades = StudentGrade::with(['student', 'evaluation.subject', 'evaluation.class'])
                              ->latest()
                              ->get();

        // Toutes les évaluations pour la saisie
        $evaluations = Evaluation::with(['subject', 'class'])
                                 ->latest()
                                 ->get();

        return view('admin.notes.grades.index', compact('grades', 'evaluations'));
    }

    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $evaluations = Evaluation::orderBy('title')->get();

        return view('admin.notes.grades.create', compact('students', 'evaluations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evaluation_id' => 'required|exists:evaluations,id',
            'student_id'    => 'required|exists:students,id',
            'score'         => 'required|numeric|min:0',
            'remark'        => 'nullable|string',
        ]);

        StudentGrade::updateOrCreate(
            [
                'evaluation_id' => $request->evaluation_id,
                'student_id'    => $request->student_id,
            ],
            [
                'score'  => $request->score,
                'remark' => $request->remark,
            ]
        );

        return redirect()->route('admin.grades.index')
                         ->with('success', 'Note enregistrée avec succès.');
    }

    public function edit(StudentGrade $grade)
    {
        $students = Student::orderBy('last_name')->get();
        $evaluations = Evaluation::orderBy('title')->get();

        return view('admin.notes.grades.edit', compact('grade', 'students', 'evaluations'));
    }

    public function update(Request $request, StudentGrade $grade)
    {
        $request->validate([
            'evaluation_id' => 'required|exists:evaluations,id',
            'student_id'    => 'required|exists:students,id',
            'score'         => 'required|numeric|min:0',
            'remark'        => 'nullable|string',
        ]);

        $grade->update($request->all());

        return redirect()->route('admin.grades.index')
                         ->with('success', 'Note mise à jour.');
    }

    public function destroy(StudentGrade $grade)
    {
        $grade->delete();
        return redirect()->route('admin.grades.index')
                         ->with('success', 'Note supprimée.');
    }

    public function createForEvaluation(Evaluation $evaluation)
    {
        // Récupérer tous les élèves de la classe
        $students = $evaluation->class->students()->orderBy('last_name')->get();

        // Récupérer les notes existantes pour cette évaluation
        $grades = StudentGrade::where('evaluation_id', $evaluation->id)->get()->keyBy('student_id');

        return view('admin.notes.grades.create_for_evaluation', compact('evaluation', 'students', 'grades'));
    }

    public function storeForEvaluation(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.score'      => 'required|numeric|min:0',
            'grades.*.remark'     => 'nullable|string',
        ]);

        foreach ($request->grades as $g) {
            StudentGrade::updateOrCreate(
                [
                    'evaluation_id' => $evaluation->id,
                    'student_id'    => $g['student_id'],
                ],
                [
                    'score'  => $g['score'],
                    'remark' => $g['remark'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.evaluations.index')
                         ->with('success', 'Notes enregistrées avec succès.');
    }

}
