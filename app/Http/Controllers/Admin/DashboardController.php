<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques simples
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses  = Classe::count();
        $totalSubjects = Subject::count();

        // Évolution inscriptions (par mois)
        $studentsByMonth = Student::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        return view('admin.dashboard.index', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'totalSubjects',
            'studentsByMonth'
        ));
    }
}
