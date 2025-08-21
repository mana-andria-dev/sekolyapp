<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportCard;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Tenant;

class ReportCardController extends Controller
{
    /**
     * Liste des bulletins
     */
    public function index()
    {
        // On récupère les bulletins du tenant connecté
        $reportCards = ReportCard::with('student')
            ->latest()
            ->paginate(10);

        return view('admin.notes.reportcards.index', compact('reportCards'));
    }

    /**
     * Formulaire création d'un nouveau bulletin
     */
    public function create()
    {
        $students = Student::get();
        $tenants  = Tenant::orderBy('name')->get();

        return view('admin.notes.reportcards.create', compact('students', 'tenants'));
    }

    /**
     * Stocker un bulletin
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'general_average' => 'required|numeric|min:0|max:20',
            'appreciation'    => 'nullable|string',
            'term'            => 'required|string|max:50',
            'year'            => 'required|string|max:9',
            'tenant_id'       => 'required|exists:tenants,id',
        ]);

        ReportCard::create([
            'student_id'      => $request->student_id,
            'general_average' => $request->general_average,
            'appreciation'    => $request->appreciation,
            'term'            => $request->term,
            'year'            => $request->year,
            'tenant_id'       => $request->tenant_id,
        ]);

        return redirect()->route('admin.report_cards.index')
                         ->with('success', 'Bulletin créé avec succès.');
    }

    /**
     * Afficher un bulletin
     */
    public function show(ReportCard $reportCard)
    {
        return view('admin.notes.reportcards.show', compact('reportCard'));
    }

    /**
     * Formulaire édition d'un bulletin
     */
    public function edit(ReportCard $reportCard)
    {
        $students = Student::where('tenant_id', auth()->user()->tenant_id ?? 1)->get();
        return view('admin.notes.reportcards.edit', compact('reportCard', 'students'));
    }

    /**
     * Mise à jour d'un bulletin
     */
    public function update(Request $request, ReportCard $reportCard)
    {
        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'general_average' => 'required|numeric|min:0|max:20',
            'appreciation'    => 'nullable|string|max:255',
        ]);

        $reportCard->update([
            'student_id'      => $request->student_id,
            'general_average' => $request->general_average,
            'appreciation'    => $request->appreciation,
        ]);

        return redirect()->route('admin.report_cards.index')
                         ->with('success', 'Bulletin mis à jour.');
    }

    /**
     * Supprimer un bulletin
     */
    public function destroy(ReportCard $reportCard)
    {
        $this->authorizeTenant($reportCard);

        $reportCard->delete();

        return redirect()->route('admin.report_cards.index')
                         ->with('success', 'Bulletin supprimé.');
    }

    /**
     * Vérifie que le bulletin appartient au tenant de l'utilisateur
     */
    private function authorizeTenant(ReportCard $reportCard)
    {
        if (($reportCard->tenant_id ?? 0) !== (auth()->user()->tenant_id ?? 1)) {
            abort(403, 'Accès non autorisé.');
        }
    }
}
