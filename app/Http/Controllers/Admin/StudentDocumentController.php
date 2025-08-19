<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
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
        $notes = $student->notes ?? collect(); 

        $pdf = \PDF::loadView('pdf.releve', compact('student','notes'));
        return $pdf->download("releve_notes_{$student->id}.pdf");
    }

}
