<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Tenant;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('tenant')->latest();

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        $teachers = $query->paginate(20);
        $tenants = Tenant::all();

        return view('admin.teachers.index', compact('teachers', 'tenants'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        return view('admin.teachers.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers,email',
            'phone'      => 'nullable|string|max:255',
            'subject'    => 'nullable|string|max:255',
            'bio'        => 'nullable|string',
            'photo'      => 'nullable|image|max:2048',
        ]);

        $validated['tenant_id'] = $request->tenant_id;

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('teachers', 'public');
        }

        Teacher::create([
            'tenant_id'  => $request->tenant_id,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'subject'    => $request->subject,
            'bio'        => $request->bio,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant ajouté avec succès.');
    }

    public function edit(Teacher $teacher)
    {
        $tenants = Tenant::all();
        return view('admin.teachers.edit', compact('teacher', 'tenants'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'tenant_id'  => 'nullable|exists:tenants,id',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone'      => 'nullable|string|max:255',
            'subject'    => 'nullable|string|max:255',
            'bio'        => 'nullable|string',
            'photo'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant supprimé avec succès.');
    }
}
