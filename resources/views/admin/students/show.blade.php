@extends('admin.layout')

@section('content')
<div class="p-6">

    {{-- En-tête de page --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">🎓 Détails de l'élève</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning">✏️ Modifier</a>
            <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Supprimer cet élève ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger">🗑 Supprimer</button>
            </form>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">⬅ Retour</a>
        </div>
    </div>

    {{-- Onglets --}}
    <ul class="nav nav-tabs" id="studentTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">Infos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="classes-tab" data-bs-toggle="tab" data-bs-target="#classes" type="button" role="tab">Classes</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">Présences</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">Dossiers</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignments" type="button" role="tab">Devoirs</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="docs-tab" data-bs-toggle="tab" data-bs-target="#docs" type="button" role="tab">
                📄 Documents
            </button>
        </li>        
    </ul>

    <div class="tab-content mt-4">

        {{-- Onglet Infos --}}
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            @include('admin.students.partials.info', ['student' => $student])
        </div>

        {{-- Onglet Classes --}}
        <div class="tab-pane fade" id="classes" role="tabpanel">
            @include('admin.students.partials.classes', ['student' => $student, 'classes' => $classes])
        </div>

        {{-- Onglet Présences --}}
        <div class="tab-pane fade" id="attendance" role="tabpanel">
            @include('admin.students.partials.attendance', ['student' => $student])
        </div>

        {{-- Onglet Dossiers --}}
        <div class="tab-pane fade" id="files" role="tabpanel">
            @include('admin.students.partials.files', ['student' => $student])
        </div>

        {{-- Onglet Devoirs & Soumissions --}}
        <div class="tab-pane fade" id="assignments" role="tabpanel">
            <h5>📘 Devoirs</h5>

            @foreach($student->classes as $class)
                <h6 class="mt-3">{{ $class->name }} ({{ $class->level }})</h6>
                <ul class="list-group mb-3">
                    @forelse($class->assignments as $assignment)
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-column flex-md-row">
                            <div>
                                <strong>{{ $assignment->title }}</strong> - {{ $assignment->subject->name }}<br>
                                Date limite : {{ \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y') }}
                            </div>
                            <div class="mt-2 mt-md-0">
                                @php
                                    $submission = $assignment->submissions->firstWhere('student_id', $student->id);
                                @endphp

                                @if($submission)
                                    <span class="badge bg-success">✅ Soumis</span>
                                    <a href="{{ asset('storage/'.$submission->file_path) }}" target="_blank" class="btn btn-sm btn-info ms-2">📄 Voir</a>
                                @else
                                    <form action="{{ route('admin.students.assignments.submit', [$student->id, $assignment->id]) }}" 
                                          method="POST" enctype="multipart/form-data" class="d-inline-block">
                                        @csrf
                                        <input type="file" name="file" class="form-control form-control-sm d-inline-block w-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">➤ Soumettre pour lui</button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Aucun devoir disponible</li>
                    @endforelse
                </ul>
            @endforeach
        </div>

        <div class="tab-pane fade" id="docs" role="tabpanel" aria-labelledby="docs-tab">
            <div class="list-group">
                <a href="{{ route('students.documents.certificat', $student) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Certificat de scolarité
                    <span class="badge bg-primary">Télécharger</span>
                </a>

                <a href="{{ route('students.documents.attestation', $student) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Attestation
                    <span class="badge bg-primary">Télécharger</span>
                </a>

                <a href="{{ route('students.documents.releve', $student) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Relevé de notes
                    <span class="badge bg-primary">Télécharger</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
