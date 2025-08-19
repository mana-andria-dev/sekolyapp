@extends('admin.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">👨‍🏫 Détails enseignant : {{ $teacher->first_name }} {{ $teacher->last_name }}</h2>

    <!-- Onglets -->
    <ul class="nav nav-tabs" id="teacherTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="info-tab" data-bs-toggle="tab" href="#info" role="tab">Informations</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="classes-tab" data-bs-toggle="tab" href="#classes" role="tab">Classes assignées</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="students-tab" data-bs-toggle="tab" href="#students" role="tab">Élèves</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="subjects-tab" data-bs-toggle="tab" href="#subjects" role="tab">Matières</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="assignments-tab" data-bs-toggle="tab" href="#assignments" role="tab">Devoirs</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="teacherTabsContent">
        <!-- Onglet Infos -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="card p-3">
                <p><strong>Email :</strong> {{ $teacher->email }}</p>
                <p><strong>Téléphone :</strong> {{ $teacher->phone }}</p>
                <p><strong>Matière principale :</strong> {{ $teacher->subject }}</p>
                <p><strong>Bio :</strong> {{ $teacher->bio }}</p>
            </div>
        </div>

        <!-- Onglet Classes -->
        <div class="tab-pane fade" id="classes" role="tabpanel">
            <div class="card p-3">
                <h5>Classes assignées</h5>
                <form action="{{ route('admin.teachers.updateClasses', $teacher->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="classes">Sélectionner les classes :</label>
                        <select name="classes[]" id="classes" class="form-select" multiple>
                            @foreach(App\Models\Classe::all() as $class)
                                <option value="{{ $class->id }}" 
                                    {{ $teacher->classes->contains($class->id) ? 'selected' : '' }}>
                                    ({{ $class->tenant->name }}) {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>

        <!-- Onglet Élèves -->
        <div class="tab-pane fade" id="students" role="tabpanel">
            <div class="card p-3">
                <h5>Élèves de ses classes</h5>
                @foreach($teacher->classes as $class)
                    <h6>{{ $class->name }}</h6>
                    <ul>
                        @foreach($class->students as $student)
                            <li>{{ $student->first_name }} {{ $student->last_name }}</li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>

        <!-- Onglet Matières -->
        <div class="tab-pane fade" id="subjects" role="tabpanel">
            <div class="card p-3">
                <p>Ici tu pourras gérer les matières enseignées par {{ $teacher->first_name }}</p>
                {{-- Formulaire à ajouter si tu as une table "subjects" --}}
            </div>
        </div>

        <!-- Onglet Devoirs -->
        <div class="tab-pane fade" id="assignments" role="tabpanel">
            <div class="card p-3">
                <h5>Devoirs donnés par {{ $teacher->first_name }}</h5>

                @forelse($teacher->assignments as $assignment)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            {{ $assignment->title }} - {{ $assignment->class->name }}
                            <span class="float-end">{{ $assignment->due_date->format('d/m/Y') }}</span>
                        </div>
                        <div class="card-body">
                            <p>{{ $assignment->description }}</p>

                            <h6>Soumissions :</h6>
                            @include('admin.assignments._submissions_table', ['submissions' => $assignment->submissions])

                        </div>
                    </div>
                @empty
                    <p>Aucun devoir donné par cet enseignant.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
