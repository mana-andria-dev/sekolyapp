@extends('admin.layout')

@section('content')
<h1 class="h3 mb-4">Modifier la matière</h1>

<form action="{{ route('subjects.update', $subject) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nom de la matière</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $subject->name }}" required>
    </div>

    <div class="mb-3">
        <label for="tenant_id" class="form-label">Etablissement</label>
        <select name="tenant_id" id="tenant_id" class="form-select" required>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" 
                    {{ $tenant->id == $subject->tenant_id ? 'selected' : '' }}>
                    {{ $tenant->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">
        <i class="bi bi-check-circle"></i> Mettre à jour
    </button>
    <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
