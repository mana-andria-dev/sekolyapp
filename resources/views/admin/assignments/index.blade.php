@extends('admin.layout')

@section('title', 'Devoirs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">📝 Devoirs</h1>
       <!--  -->
    </div>
    <a href="{{ route('admin.assignments.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-circle"></i> Créer un devoir
    </a>
</div>

{{-- Filtres --}}
<form method="GET" class="card shadow-sm border-0 mb-3">
    <div class="card-body row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Matière</label>
            <select name="subject_id" class="form-select">
                <option value="">Toutes</option>
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}" @selected(request('subject_id') == $s->id)>{{ $s->tenant->name }} > {{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Enseignant</label>
            <select name="teacher_id" class="form-select">
                <option value="">Tous</option>
                @foreach($teachers as $t)
                    <option value="{{ $t->id }}" @selected(request('teacher_id') == $t->id)>
                        {{ $t->tenant->name }} > {{ $t->last_name }} {{ $t->first_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Recherche</label>
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Titre du devoir…" value="{{ request('q') }}">
                <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                @if(request()->hasAny(['subject_id','teacher_id','q']))
                    <a href="{{ route('admin.assignments.index') }}" class="btn btn-outline-danger">
                        <i class="bi bi-x-circle"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</form>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="text-white" style="background: linear-gradient(135deg, #4f46e5, #3b82f6);">
                    <tr>
                        <th class="px-3 py-3">Titre</th>
                        <th class="px-3 py-3">Matière</th>
                        <th class="px-3 py-3">Enseignant</th>
                        <th class="px-3 py-3">Date limite</th>
                        <th class="px-3 py-3">Fichier</th>
                        <th class="px-3 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($assignments as $a)
                    <tr>
                        <td class="px-3 py-3">
                            <div class="fw-semibold">{{ $a->title }}</div>
                            @if($a->description)
                                <div class="text-muted small text-truncate" style="max-width: 420px;">
                                    {{ $a->description }}
                                </div>
                            @endif
                        </td>
                        <td class="px-3 py-3">
                            <span class="badge bg-primary-subtle text-primary border border-primary rounded-pill px-3">
                                {{ $a->subject->name }}
                            </span>
                        </td>
                        <td class="px-3 py-3">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ $a->teacher->last_name }} {{ $a->teacher->first_name }}
                        </td>
                        <td class="px-3 py-3">
                            @php
                                $overdue = \Carbon\Carbon::parse($a->due_date)->isPast();
                                $badge = $overdue ? 'danger' : 'secondary';
                            @endphp
                            <span class="badge bg-{{ $badge }}">
                                {{ \Carbon\Carbon::parse($a->due_date)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            @if($a->file_path)
                                <a href="{{ asset('storage/'.$assignment->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="bi bi-file-earmark-arrow-down"></i> Télécharger
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-3 py-3 text-center">
                            <a href="{{ route('admin.assignments.show', $a->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Ouvrir
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3"></i>
                            <p class="mt-2 mb-0">Aucun devoir.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $assignments->links('pagination::bootstrap-5') }}
</div>
@endsection
