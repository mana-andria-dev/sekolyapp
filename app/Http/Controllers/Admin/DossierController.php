<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DossierController extends Controller
{
    /**
     * Stocke un nouveau dossier pour un étudiant.
     */
    public function store(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);

        // Validation des champs
        $request->validate([
            'titre' => 'required|string|max:255',
            'fichier' => 'nullable|file|max:10240', // max 10MB
            'description' => 'nullable|string|max:500',
        ]);

        // Vérifier les doublons : même étudiant, même titre
        $exists = Dossier::where('student_id', $studentId)
                         ->where('title', $request->titre)
                         ->first();

        if ($exists) {
            return back()->with('error', 'Un dossier avec ce titre existe déjà pour cet étudiant.');
        }

        $fichierPath = null;
        if ($request->hasFile('fichier')) {
            $fichierPath = $request->file('fichier')->store('dossiers', 'public');
        }

        // Création du dossier multitenant
        Dossier::create([
            'tenant_id' => $student->tenant_id,
            'student_id' => $studentId,
            'title' => $request->titre,
            'description' => $request->description,
            'file_path' => $fichierPath,
        ]);

        return back()->with('success', 'Dossier ajouté avec succès.');
    }

    /**
     * Supprime un dossier.
     */
    public function destroy(Dossier $dossier)
    {
        // Supprimer le fichier physique s'il existe
        if ($dossier->fichier_path && Storage::disk('public')->exists($dossier->fichier_path)) {
            Storage::disk('public')->delete($dossier->fichier_path);
        }

        $dossier->delete();

        return back()->with('success', 'Dossier supprimé avec succès.');
    }
}
