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
