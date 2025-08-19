@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">

    {{-- Titre --}}
    <h1 class="mb-4 fw-bold"><i class="bi bi-speedometer2 me-2 text-primary"></i> Tableau de bord</h1>

    {{-- Statistiques principales --}}
    <div class="row g-3 mb-4">
        {{-- Élèves --}}
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 bg-primary text-white rounded-3">
                <div class="card-body">
                    <i class="bi bi-people-fill fs-1"></i>
                    <h5 class="mt-2">Élèves</h5>
                    <h2 class="fw-bold">{{ $totalStudents }}</h2>
                </div>
            </div>
        </div>

        {{-- Enseignants --}}
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 bg-success text-white rounded-3">
                <div class="card-body">
                    <i class="bi bi-person-badge-fill fs-1"></i>
                    <h5 class="mt-2">Enseignants</h5>
                    <h2 class="fw-bold">{{ $totalTeachers }}</h2>
                </div>
            </div>
        </div>

        {{-- Classes --}}
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 bg-warning text-dark rounded-3">
                <div class="card-body">
                    <i class="bi bi-building fs-1"></i>
                    <h5 class="mt-2">Classes</h5>
                    <h2 class="fw-bold">{{ $totalClasses }}</h2>
                </div>
            </div>
        </div>

        {{-- Matières --}}
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 bg-info text-dark rounded-3">
                <div class="card-body">
                    <i class="bi bi-book fs-1"></i>
                    <h5 class="mt-2">Matières</h5>
                    <h2 class="fw-bold">{{ $totalSubjects }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphique des élèves par mois --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-light fw-bold">
            <i class="bi bi-graph-up me-2 text-primary"></i> Inscriptions d'élèves par mois
        </div>
        <div class="card-body">
            <canvas id="studentsChart" height="100"></canvas>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('studentsChart').getContext('2d');
    const studentsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json(array_keys($studentsByMonth->toArray())),
            datasets: [{
                label: 'Élèves inscrits',
                data: @json(array_values($studentsByMonth->toArray())),
                borderColor: '#0d6efd',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                pointBackgroundColor: '#0d6efd',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
