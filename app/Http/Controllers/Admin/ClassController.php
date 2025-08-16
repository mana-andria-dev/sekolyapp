<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Tenant;
use Illuminate\Http\Request;

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
        return view('admin.classes.create', compact('tenants', 'class'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Classe::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe créée avec succès.');
    }

    public function edit($id)
    {
        $class = Classe::findOrFail($id)->load('students');
        $tenants = Tenant::all();
        return view('admin.classes.edit', compact('class', 'tenants'));
    }

    // public function edit(SchoolClass $class)
    // {
    //     $tenants = Tenant::all();
    //     $class->load('students'); // charge les élèves liés à cette classe

    //     return view('admin.classes.edit', compact('class', 'tenants'));
    // }
    

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $class = Classe::findOrFail($id);
        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $class = Classe::findOrFail($id);
        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe supprimée avec succès.');
    }
}
