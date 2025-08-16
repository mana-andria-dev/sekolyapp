@extends('admin.layout')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">📚 Gestion des Classes</h1>
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouvelle Classe
        </a>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.classes.index') }}">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                    <select name="tenant_id" class="form-select">
                        <option value="">-- Tous les établissements --</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                {{ $tenant->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-funnel-fill"></i> Filtrer
                    </button>
                    @if(request('tenant_id'))
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-secondary" title="Réinitialiser le filtre">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="p-2 border">Etablissement</th>
                        <th>Nom</th>
                        <th>Niveau</th>
                        <th>Date Création</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td class="fw-bold">{{ $class->tenant->name }}</td>
                            <td class="fw-bold">{{ $class->name }}</td>
                            <td>{{ $class->level }}</td>
                            <td>{{ $class->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette classe ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Aucune classe enregistrée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
