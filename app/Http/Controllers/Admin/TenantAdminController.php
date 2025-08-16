<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantAdminController extends Controller
{
    public function index()
    {
        $tenants = Tenant::latest()->paginate(10);
        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('admin.tenants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:ecole,college,universite',
            'email' => 'required|email|unique:tenants,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $logo_path = $request->hasFile('logo') ? $request->file('logo')->store('logos', 'public') : null;
        $subdomain = Str::slug($request->name);

        Tenant::create([
            'name' => $request->name,
            'type' => $request->type,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'logo_path' => $logo_path,
            'subdomain' => $subdomain,
        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant créé avec succès.');
    }

    public function edit(Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:ecole,college,universite',
            'email' => 'required|email|unique:tenants,email,' . $tenant->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $tenant->logo_path = $request->file('logo')->store('logos', 'public');
        }

        $tenant->update($request->only(['name', 'type', 'email', 'phone', 'address', 'logo_path']));

        return redirect()->route('tenants.index')->with('success', 'Tenant mis à jour.');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Tenant supprimé.');
    }
}
