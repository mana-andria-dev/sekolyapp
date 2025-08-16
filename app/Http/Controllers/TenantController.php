<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Str; // ← Ajouter ceci

class TenantController extends Controller
{
    public function create() {
        return view('tenants.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:ecole,college,universite',
            'email' => 'required|email|unique:tenants,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $logo_path = null;
        if($request->hasFile('logo')) {
            $logo_path = $request->file('logo')->store('logos', 'public');
        }

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

        return redirect()->route('principal.accueil')
                         ->with('success', 'Merci ! Votre demande a bien été reçue. Nous vous contacterons bientôt.');
    }
}
