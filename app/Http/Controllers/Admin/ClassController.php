<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\Subject;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $tenants = \App\Models\Tenant::all();

        $query = \App\Models\Classe::with('tenant');

        if ($request->tenant_id) {
            $query->where('tenant_id', $request->tenant_id);
        }

        $classes = $query->get();

        return view('admin.classes.index', compact('classes', 'tenants'));
    }

    public function create()
    {
        $tenants = \App\Models\Tenant::all();
        $class = new \App\Models\Classe();
        $subjects = Subject::all();        
        return view('admin.classes.create', compact('tenants', 'class', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'tenant_id' => 'required|exists:tenants,id',
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        $class = Classe::create($request->only('name', 'level', 'tenant_id', 'description'));

        if($request->has('subjects')) {
            $class->subjects()->sync($request->subjects);
        }

        return redirect()->route('admin.classes.index')->with('success', 'Classe créée avec succès !');
    }

    public function update(Request $request, Classe $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'tenant_id' => 'required|exists:tenants,id',
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        $class->update($request->only('name', 'level', 'tenant_id', 'description'));

        if($request->has('subjects')) {
            $class->subjects()->sync($request->subjects);
        }

        return redirect()->route('admin.classes.index')->with('success', 'Classe mise à jour avec succès !');
    }


    public function edit($id)
    {
        $class = Classe::findOrFail($id)->load('students');
        $tenants = Tenant::all();
        $subjects = Subject::all();
        return view('admin.classes.edit', compact('class', 'tenants', 'subjects'));
    }

    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'tenant_id' => 'required|exists:tenants,id',
    //         'name' => 'required|string|max:255',
    //         'level' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //     ]);

    //     $class = Classe::findOrFail($id);
    //     $class->update($validated);

    //     return redirect()->route('admin.classes.index')
    //         ->with('success', 'Classe mise à jour avec succès.');
    // }

    public function destroy($id)
    {
        $class = Classe::findOrFail($id);
        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe supprimée avec succès.');
    }

    // Affiche le formulaire d'assignation des matières
    public function editSubjects(Classe $class)
    {
        $subjects = Subject::all();
        return view('admin.classes.subjects', compact('class', 'subjects'));
    }

    // Sauvegarde l'association
    public function updateSubjects(Request $request, Classe $class)
    {
        $request->validate([
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        $class->subjects()->sync($request->subjects);

        return redirect()->route('classes.editSubjects', $class)->with('success', 'Matières associées à la classe avec succès !');
    }    
}
