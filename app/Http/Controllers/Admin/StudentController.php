<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Tenant;
use App\Models\Classe;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('tenant')->latest();

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        $students = $query->paginate(20);
        $tenants = Tenant::all();

        return view('admin.students.index', compact('students', 'tenants'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        return view('admin.students.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'tenant_id'  => 'nullable|exists:tenants,id',
        ]);

        Student::create($request->all());

        return redirect()->route('admin.students.index')
            ->with('success', 'Élève ajouté avec succès.');
    }

    public function show(Student $student)
    {
        $presences = $student->presences()->get();
        $dossiers = $student->dossiers()->get();
        $classes = Classe::where('tenant_id', $student->tenant_id)->get();

        return view('admin.students.show', compact('student', 'presences', 'dossiers', 'classes'));
    }

    public function edit(Student $student)
    {
        $tenants = Tenant::all();
        return view('admin.students.edit', compact('student', 'tenants'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'tenant_id'  => 'nullable|exists:tenants,id',
        ]);

        $student->update($request->all());

        return redirect()->route('admin.students.index')
            ->with('success', 'Élève modifié avec succès.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Élève supprimé avec succès.');
    }

    public function assignClasses(Request $request, Student $student)
    {
        $request->validate([
            'classes' => 'array',
            'classes.*' => 'exists:classes,id',
        ]);

        // Sync permet d’ajouter/retirer automatiquement
        $student->classes()->sync($request->classes ?? []);

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Classes mises à jour avec succès ✅');
    }

    public function removeClass(Student $student, Classe $class)
    {
        $student->classes()->detach($class->id);

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Classe retirée avec succès ❌');
    }

}
