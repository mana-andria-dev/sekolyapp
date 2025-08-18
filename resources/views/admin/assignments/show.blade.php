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

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Élève</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Dernière soumission</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignment->students as $student)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $student->last_name }} {{ $student->first_name }}</div>
                            <div class="text-muted small">#{{ $student->id }}</div>
                        </td>
                        <td>
                            @php
                                $s = $student->pivot->status;
                                $map = ['pending'=>'warning','submitted'=>'info','graded'=>'success'];
                            @endphp
                            <span class="badge bg-{{ $map[$s] ?? 'secondary' }}">{{ [
                                'pending'=>'En attente','submitted'=>'Soumis','graded'=>'Corrigé'
                            ][$s] ?? $s }}</span>
                        </td>
                        <td class="fw-semibold">
                            {{ $student->pivot->grade !== null ? number_format($student->pivot->grade, 2) : '—' }}
                        </td>
                        <td class="text-muted">
                            {{ $student->pivot->submitted_at ? \Carbon\Carbon::parse($student->pivot->submitted_at)->format('d/m/Y H:i') : '—' }}
                        </td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.assignments.grade', [$assignment->id, $student->id]) }}" class="d-inline-flex gap-2 align-items-center">
                                @csrf
                                <input type="number" name="grade" min="0" max="20" step="0.01"
                                       value="{{ $student->pivot->grade }}"
                                       class="form-control form-control-sm" style="width: 90px;">
                                <select name="status" class="form-select form-select-sm" style="width: 140px;">
                                    <option value="pending"   @selected($s==='pending')>En attente</option>
                                    <option value="submitted" @selected($s==='submitted')>Soumis</option>
                                    <option value="graded"    @selected($s==='graded')>Corrigé</option>
                                </select>
                                <button class="btn btn-sm btn-success">
                                    <i class="bi bi-save"></i> Enregistrer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    @if($assignment->students->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-emoji-neutral"></i> Aucun élève rattaché.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
