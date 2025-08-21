<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ReportCard;
use Barryvdh\DomPDF\Facade\Pdf; // <--- importer la facade

class StudentDocumentController extends Controller
{
    public function certificat(Student $student)
    {
        $pdf = Pdf::loadView('pdf.certificat', compact('student'));
        return $pdf->download("certificat_scolarite_{$student->id}.pdf");
    }

    public function attestation(Student $student)
    {
        $pdf = Pdf::loadView('pdf.attestation', compact('student'));
        return $pdf->download("attestation_{$student->id}.pdf");
    }

    public function releve(Student $student)
    {
        $reportCards = ReportCard::with('evaluation.subject')
                         ->where('student_id', $student->id)
                         ->get();

        $pdf = PDF::loadView('pdf.releve', compact('student', 'reportCards'));
        return $pdf->download("Releve_{$student->first_name}_{$student->last_name}.pdf");
    }

}
