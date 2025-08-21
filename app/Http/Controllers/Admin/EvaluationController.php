<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Subject;
use App\Models\Classe;
use App\Models\Tenant;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::with(['subject', 'class'])->latest()->paginate(10);
        return view('admin.notes.evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        $classes = Classe::orderBy('name')->get();
        $tenants  = Tenant::orderBy('name')->get();

        return view('admin.notes.evaluations.create', compact('subjects', 'classes', 'tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'tenant_id'  => 'required|exists:tenants,id', // <--- ajouter
            'date'       => 'required|date',
        ]);

        Evaluation::create([
            'title'      => $request->title,
            'subject_id' => $request->subject_id,
            'class_id'   => $request->class_id,
            'tenant_id'  => $request->tenant_id,
            'date'       => $request->date,
            'created_by' => auth()->id(),  // <--- Ajouter l'ID de l'utilisateur connecté
        ]);


        return redirect()->route('admin.evaluations.index')
                         ->with('success', 'Évaluation créée avec succès.');
    }

    public function edit(Evaluation $evaluation)
    {
        $subjects = Subject::orderBy('name')->get();
        $classes = Classe::orderBy('name')->get();

        return view('admin.notes.evaluations.edit', compact('evaluation', 'subjects', 'classes'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'date'       => 'required|date',
        ]);

        $evaluation->update($request->all());

        return redirect()->route('admin.evaluations.index')
                         ->with('success', 'Évaluation mise à jour.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();

        return redirect()->route('admin.evaluations.index')
                         ->with('success', 'Évaluation supprimée.');
    }
}
