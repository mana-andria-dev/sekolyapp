@extends('admin.layout')

@section('content')
<h1 class="h3 mb-4">Ajouter une nouvelle matière</h1>

<form action="{{ route('subjects.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nom de la matière</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="tenant_id" class="form-label">Etablissement</label>
        <select name="tenant_id" id="tenant_id" class="form-select" required>
            <option value="">-- Sélectionner un établissement --</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">
        <i class="bi bi-check-circle"></i> Enregistrer
    </button>
    <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
