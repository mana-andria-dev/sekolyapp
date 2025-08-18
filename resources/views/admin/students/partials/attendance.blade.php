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
