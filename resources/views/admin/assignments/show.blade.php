@extends('admin.layout')

@section('title', 'Devoir')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">{{ $assignment->title }}</h1>
        <div class="text-muted">
            <i class="bi bi-building"></i> {{ $assignment->class->tenant->name ?? '-' }} •
            <i class="bi bi-mortarboard"></i> {{ $assignment->class->name }} •
            <i class="bi bi-book"></i> {{ $assignment->subject->name }} •
            <i class="bi bi-person"></i> {{ $assignment->teacher->last_name }} {{ $assignment->teacher->first_name }}
        </div>
    </div>
    <a href="{{ route('admin.assignments.index', $assignment->class_id) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour à la liste
    </a>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3">
        @php $past = \Carbon\Carbon::parse($assignment->due_date)->isPast(); @endphp
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted small">Date limite</div>
                <div class="fs-5">
                    <span class="badge bg-{{ $past ? 'danger' : 'secondary' }}">
                        {{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @foreach([
        ['label' => 'Total élèves', 'value' => $counts['total'], 'icon' => 'people', 'bg' => 'primary'],
        ['label' => 'En attente',   'value' => $counts['pending'], 'icon' => 'hourglass-split', 'bg' => 'warning'],
        ['label' => 'Soumis',       'value' => $counts['submitted'], 'icon' => 'upload', 'bg' => 'info'],
        ['label' => 'Corrigé',      'value' => $counts['graded'], 'icon' => 'check2-circle', 'bg' => 'success'],
    ] as $c)
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="badge bg-{{ $c['bg'] }} p-3 rounded-circle">
                    <i class="bi bi-{{ $c['icon'] }}"></i>
                </div>
                <div>
                    <div class="text-muted small">{{ $c['label'] }}</div>
                    <div class="fs-4 fw-semibold">{{ $c['value'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($assignment->description)
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <h5 class="mb-2"><i class="bi bi-card-text"></i> Consignes</h5>
        <p class="mb-0">{{ $assignment->description }}</p>
    </div>
</div>
@endif

@include('admin.assignments._submissions_table', ['submissions' => $assignment->submissions])

@endsection
