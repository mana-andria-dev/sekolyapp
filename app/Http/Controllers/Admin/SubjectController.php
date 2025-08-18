<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Tenant;

class SubjectController extends Controller
{
    public function index(Request $request) {
        $tenants = Tenant::all();
        $subjectsQuery = Subject::with('tenant');

        if ($request->filled('tenant_id')) {
            $subjectsQuery->where('tenant_id', $request->tenant_id);
        }

        $subjects = $subjectsQuery->paginate(15);
        return view('admin.subjects.index', compact('subjects', 'tenants'));
    }

    public function create() {
        $tenants = Tenant::all();
        return view('admin.subjects.create', compact('tenants'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'tenant_id' => 'required|exists:tenants,id',
        ]);

        Subject::create($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Matière ajoutée avec succès.');
    }

    public function edit(Subject $subject) {
        $tenants = Tenant::all();
        return view('admin.subjects.edit', compact('subject', 'tenants'));
    }

    public function update(Request $request, Subject $subject) {
        $request->validate([
            'name' => 'required|string|max:255',
            'tenant_id' => 'required|exists:tenants,id',
        ]);

        $subject->update($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Matière mise à jour avec succès.');
    }

    public function destroy(Subject $subject) {
        $subject->delete();
        return redirect()->route('subjects.index')
                         ->with('success', 'Matière supprimée avec succès.');
    }
}
