@extends('admin.layout')

@section('content')
<div class="p-6">

    {{-- En-tête de page --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">🎓 Détails de l'élève</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning">
                ✏️ Modifier
            </a>
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
            <button class="nav-link" id="classes-tab" data-bs-toggle="tab" data-bs-target="#classes" type="button" role="tab">
                Classes
            </button>
        </li>        
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">Présences</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">Dossiers</button>
        </li>
    </ul>

    <div class="tab-content mt-4">
        {{-- Onglet Infos --}}
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
                    <div>
                        <h4>{{ $student->first_name }} {{ $student->last_name }}</h4>
                        <p class="mb-0">
                            @if($student->status === 'active')
                                ✅ Actif
                            @elseif($student->status === 'inactive')
                                ⏸️ Inactif
                            @elseif($student->status === 'graduated')
                                🎓 Diplômé
                            @else
                                ⚠️ Suspendu
                            @endif
                        </p>
                    </div>
                    <div class="text-end">
                        <small>Date d'inscription</small>
                        <div>{{ $student->enrollment_date }}</div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>⚧ <strong>Genre :</strong> {{ $student->gender ?? '-' }}</p>
                            <p>🎂 <strong>Date de naissance :</strong> {{ $student->birth_date ?? '-' }}</p>
                            <p>🏫 <strong>Établissement :</strong> {{ $student->tenant->restaurant_name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>📍 <strong>Adresse :</strong> {{ $student->address ?? '-' }}</p>
                            <p>📞 <strong>Téléphone :</strong> {{ $student->phone ?? '-' }}</p>
                            <p>📧 <strong>Email :</strong> {{ $student->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Onglet Classes --}}
        <div class="tab-pane fade" id="classes" role="tabpanel">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>📚 Assigner des classes</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.students.assignClasses', $student) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Sélectionnez les classes</label>
                            <select name="classes[]" class="form-select" multiple>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" 
                                        {{ $student->classes->contains($class->id) ? 'selected' : '' }}>
                                        {{ $class->name }} ({{ $class->level }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Maintenir CTRL (Windows) ou CMD (Mac) pour sélectionner plusieurs classes</small>
                        </div>
                        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                    </form>
                </div>
            </div>

            {{-- Liste des classes assignées --}}
            <h5>✅ Classes actuelles</h5>
            <ul class="list-group">
                @forelse($student->classes as $class)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $class->name }} ({{ $class->level }})

                        <form action="{{ route('admin.students.removeClass', [$student, $class]) }}" 
                              method="POST" 
                              onsubmit="return confirm('Retirer cette classe de l’élève ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Aucune classe assignée</li>
                @endforelse
            </ul>
        </div>


        {{-- Onglet Présences --}}
        <div class="tab-pane fade" id="attendance" role="tabpanel">

            {{-- Formulaire ajout présence --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>➕ Ajouter une présence</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.presences.store', $student->id) }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Statut</label>
                                <select name="status" class="form-select" required>
                                    <option value="present">Présent</option>
                                    <option value="absent">Absent</option>
                                    <option value="late">Retard</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Remarques</label>
                                <input type="text" name="remarques" class="form-control" placeholder="Optionnel">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success w-100">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tableau des présences --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Remarques</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($student->presences as $presence)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($presence->date)->format('d/m/Y') }}</td>
                            <td>
                                @if($presence->status === 'present')
                                    <span class="badge bg-success">Présent</span>
                                @elseif($presence->status === 'absent')
                                    <span class="badge bg-danger">Absent</span>
                                @else
                                    <span class="badge bg-warning text-dark">Retard</span>
                                @endif
                            </td>
                            <td>{{ $presence->remarques ?? '-' }}</td>
                            <td>
                                <form action="{{ route('admin.presences.destroy', $presence) }}" method="POST" onsubmit="return confirm('Supprimer cette présence ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">🗑</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucune présence enregistrée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Onglet Dossiers --}}
        <div class="tab-pane fade" id="files" role="tabpanel">
            <div class="card">
                <div class="card-header bg-light">
                    <strong>➕ Ajouter un dossier</strong>
                </div>            
                {{-- Formulaire d’ajout de dossier directement dans la page --}}
                <div class="card mb-3 p-3 border">
                    <form action="{{ route('admin.dossiers.store', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <input type="text" name="titre" class="form-control flex-grow-1" placeholder="Titre du dossier" required>
                            <input type="file" name="fichier" class="form-control flex-grow-1">
                            <input type="text" name="description" class="form-control flex-grow-1" placeholder="Description (facultatif)">
                            <button type="submit" class="btn btn-success">➕ Ajouter</button>
                        </div>

                        @error('titre')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('fichier')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>

            {{-- Tableau des dossiers --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Fichier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($student->dossiers as $dossier)
                        <tr>
                            <td>{{ $dossier->title }}</td>
                            <td>{{ $dossier->description ?? '-' }}</td>
                            <td>
                                @if($dossier->file_path)
                                    <a href="{{ asset('storage/'.$dossier->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                        📄 Voir
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.dossiers.destroy', $dossier) }}" method="POST" onsubmit="return confirm('Supprimer ce dossier ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">🗑</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucun dossier disponible</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
