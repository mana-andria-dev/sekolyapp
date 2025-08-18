<div class="card">
    <div class="card-header bg-light">
        <strong>➕ Ajouter un dossier</strong>
    </div>            
    <div class="card-body mb-3 p-3 border">
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
                            <a href="{{ asset('storage/'.$dossier->file_path) }}" target="_blank" class="btn btn-sm btn-info">📄 Voir</a>
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
