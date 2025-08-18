@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">📘 Liste des matières</h1>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-circle"></i> Ajouter une matière
    </a>
</div>

{{-- Filtre par établissement --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('subjects.index') }}" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="bi bi-building"></i>
                    </span>
                    <select name="tenant_id" class="form-select">
                        <option value="">-- Tous les établissements --</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" 
                                {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                {{ $tenant->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-filter-circle"></i> Filtrer
                </button>
                @if(request('tenant_id'))
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tableau --}}
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="text-white" style="background: linear-gradient(135deg, #4f46e5, #3b82f6);">
                    <tr>
                        <th scope="col" class="px-3 py-3">Établissement</th>
                        <th scope="col" class="px-3 py-3">Nom de la matière</th>
                        <th scope="col" class="px-3 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                        <tr>
                            <td class="px-3 py-3">
                                <span class="badge bg-light text-dark px-3 py-2">
                                    {{ $subject->tenant->name }}
                                </span>
                            </td>
                            <td class="fw-semibold px-3 py-3">{{ $subject->name }}</td>
                            <td class="text-center px-3 py-3">
                                <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-warning shadow-sm me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('subjects.destroy', $subject) }}" method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette matière ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3"></i>
                                <p class="mt-2 mb-0">Aucune matière trouvée.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-3 d-flex">
    {{ $subjects->links('pagination::bootstrap-5') }}
</div>
@endsection
