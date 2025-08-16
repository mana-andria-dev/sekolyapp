@extends('admin.layout')

@section('content')
<div class="container py-4">

    {{-- Titre + bouton --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestion des élèves</h1>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Ajouter un élève
        </a>
    </div>

    {{-- Filtre --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <select name="tenant_id" class="form-select">
                <option value="">-- Filtrer par établissement --</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                        {{ $tenant->name ?? $tenant->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-auto">
            <button class="btn btn-secondary">
                <i class="bi bi-funnel-fill"></i> Filtrer
            </button>
        </div>
    </form>

    {{-- Tableau --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Établissement</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->tenant->name ?? '-' }}</td>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td>{{ $student->email ?? '-' }}</td>
                            <td>{{ $student->phone ?? '-' }}</td>
                            <td>
                                @if($student->status === 'actif')
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($student->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet élève ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucun élève trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $students->links() }}
    </div>
</div>
@endsection
