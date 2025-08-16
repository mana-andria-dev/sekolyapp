@extends('admin.layout')

@section('title', 'Liste des Etablissements')

@section('content')
<!-- <div class="d-flex justify-content-between align-items-center mb-3">
    <h2></h2>
    <a href="{{ route('tenants.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Ajouter un Tenant
    </a>
</div> -->

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Email</th>
                    <th>Tel</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                    <tr>
                        <td>
                            @if($tenant->logo_path)
                                <img src="{{ asset('storage/' . $tenant->logo_path) }}" width="50" height="50" class="rounded">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $tenant->name }}</td>
                        <td class="text-capitalize">{{ $tenant->type }}</td>
                        <td>{{ $tenant->email }}</td>
                        <td>{{ $tenant->phone ?? '—' }}</td>
                        <td>{{ $tenant->address ?? '—' }}</td>
                        <td>
                            <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce tenant ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Aucun tenant trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $tenants->links() }}
    </div>
</div>
@endsection
