<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    
    public function create($studentId)
    {
        $student = Student::findOrFail($studentId);
        return view('admin.presences.create', compact('student'));
    }

    public function store(Request $request, $studentId)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
            'remarques' => 'nullable|string|max:500',
        ]);

        // Récupérer l'élève
        $student = Student::findOrFail($studentId);

        // Vérifier qu'il n'y a pas déjà une présence pour cette date
        $exists = Presence::where('student_id', $studentId)
                           ->where('date', $request->date)
                           ->first();

        if ($exists) {
            return back()->withErrors(['date' => 'Une présence existe déjà pour cette date à cet élève.'])->withInput();
        }

        // Créer la présence en tenant compte du tenant_id
        Presence::create([
            'tenant_id' => $student->tenant_id,
            'student_id' => $studentId,
            'date' => $request->date,
            'status' => $request->status,
            'remarques' => $request->remarques,
        ]);

        return back()->with('success', 'Présence ajoutée avec succès.');
    }


    public function destroy(Presence $presence)
    {
        // $this->authorize('delete', $presence);
        $presence->delete();
        return back()->with('success', 'Présence supprimée.');
    }
}
