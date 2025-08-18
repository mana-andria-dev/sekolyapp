<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Assignment, Classe, Student, Subject, Teacher};
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Assignment::with(['class', 'subject', 'teacher'])->latest();

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->integer('class_id'));
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->integer('subject_id'));
        }
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->integer('teacher_id'));
        }
        if ($request->filled('q')) {
            $q = trim($request->get('q'));
            $query->where('title', 'like', "%{$q}%");
        }

        $assignments = $query->paginate(10)->withQueryString();

        return view('admin.assignments.index', [
            'assignments' => $assignments,
            'classes'     => Classe::orderBy('name')->get(),
            'subjects'    => Subject::orderBy('name')->get(),
            'teachers'    => Teacher::orderBy('last_name')->orderBy('first_name')->get(),
        ]);
    }


    // Formulaire de création
    public function create()
    {
        return view('admin.assignments.create', [
            'classes'  => Classe::with(['subjects', 'teachers'])->orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'teachers' => Teacher::orderBy('last_name')->orderBy('first_name')->get(),
        ]);
    }

    // Enregistrement d’un devoir
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id'    => 'required|exists:classes,id',
            'subject_id'  => 'required|exists:subjects,id',
            'teacher_id'  => 'required|exists:teachers,id',
            'due_date'    => 'required|date|after_or_equal:today',
        ]);

        // Vérifs de cohérence: la matière et l’enseignant doivent être reliés à la classe
        $class   = Classe::with(['subjects', 'teachers', 'students'])->findOrFail($data['class_id']);
        $subjectOk = $class->subjects->pluck('id')->contains((int)$data['subject_id']);
        $teacherOk = $class->teachers->pluck('id')->contains((int)$data['teacher_id']);
        $data['file_path'] = '';

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('assignments', 'public');
        }        

        if (!$subjectOk) {
            throw ValidationException::withMessages([
                'subject_id' => 'La matière sélectionnée n’est pas associée à cette classe.',
            ]);
        }
        if (!$teacherOk) {
            throw ValidationException::withMessages([
                'teacher_id' => 'Cet enseignant n’est pas associé à cette classe.',
            ]);
        }

        // Création + rattachement des élèves (pivot status= pending)
        DB::transaction(function () use ($data, $class) {
            /** @var \App\Models\Assignment $assignment */
            $assignment = Assignment::create([
                'title'       => $data['title'],
                'description' => $data['description'] ?? null,
                'class_id'    => $data['class_id'],
                'subject_id'  => $data['subject_id'],
                'teacher_id'  => $data['teacher_id'],
                'due_date'    => $data['due_date'],
                'due_datefile_path'    => $data['file_path'],
            ]);

            // Attacher tous les élèves de la classe avec statut par défaut
            $pivotData = $class->students->pluck('id')->mapWithKeys(function ($studentId) {
                return [$studentId => ['status' => 'pending', 'grade' => null, 'submitted_at' => null]];
            })->all();

            if (!empty($pivotData)) {
                $assignment->students()->attach($pivotData);
            }
        });

        return redirect()
            ->route('admin.assignments.index', $data['class_id'])
            ->with('success', 'Devoir créé avec succès et élèves de la classe rattachés.');
    }

    // Détails d’un devoir
    public function show($id)
    {
        $assignment = Assignment::with(['class', 'subject', 'teacher', 'students' => function ($q) {
            $q->orderBy('last_name')->orderBy('first_name');
        }])->findOrFail($id);

        // Stats simples
        $counts = [
            'total'     => $assignment->students->count(),
            'pending'   => $assignment->students->where('pivot.status', 'pending')->count(),
            'submitted' => $assignment->students->where('pivot.status', 'submitted')->count(),
            'graded'    => $assignment->students->where('pivot.status', 'graded')->count(),
        ];

        return view('admin.assignments.show', compact('assignment', 'counts'));
    }

    // Mise à jour note + statut
    public function updateGrade(Request $request, $assignment_id, $student_id)
    {
        $data = $request->validate([
            'grade'  => 'nullable|numeric|min:0|max:20',
            'status' => 'required|in:pending,submitted,graded'
        ]);

        $assignment = Assignment::with('students')->findOrFail($assignment_id);

        // Assurer que l’élève appartient bien au devoir
        $student = $assignment->students()->where('student_id', $student_id)->firstOrFail();

        $assignment->students()->updateExistingPivot($student_id, [
            'grade'        => $data['grade'],
            'status'       => $data['status'],
            'submitted_at' => $data['status'] === 'submitted'
                                ? Carbon::now()
                                : ($data['status'] === 'pending' ? null : $student->pivot->submitted_at),
        ]);

        return back()->with('success', 'Note / statut mis à jour.');
    }
}
