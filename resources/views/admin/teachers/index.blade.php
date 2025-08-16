@extends('admin.layout')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">👨‍🏫 Gestion des enseignants</h1>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouvel enseignant
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <div class="mb-3">
                <form method="GET" action="{{ route('admin.teachers.index') }}" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <select name="tenant_id" class="form-select">
                            <option value="">-- Filtrer par établissement --</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" 
                                    {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                    {{ $tenant->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-funnel"></i> Filtrer
                        </button>
                    </div>
                    @if(request()->filled('tenant_id'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Annuler
                        </a>
                    </div>
                    @endif
                </form>
            </div>

            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Matière</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td>
                                @if($teacher->photo_path)
                                    <img src="{{ asset('storage/' . $teacher->photo_path) }}" alt="Photo" class="rounded-circle" width="40" height="40">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone ?? '-' }}</td>
                            <td>{{ $teacher->subject ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet enseignant ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucun enseignant enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $teachers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
