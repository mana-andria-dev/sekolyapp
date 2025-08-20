@extends('admin.layout')

@section('title', 'Modifier un Tenant')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('tenants.update', $tenant) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $tenant->name) }}" required>
            </div>

            <div class="mb-3">
                <label>Type</label>
                <select name="type" class="form-select" required>
                    <option value="">— Choisir —</option>
                    <option value="ecole" @selected($tenant->type === 'ecole')>École</option>
                    <option value="college" @selected($tenant->type === 'college')>Collège</option>
                    <option value="lycee" @selected($tenant->type === 'lycee')>Lycée</option>
                    <option value="universite" @selected($tenant->type === 'universite')>Université</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $tenant->email) }}" required>
            </div>

            <div class="mb-3">
                <label>Téléphone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $tenant->phone) }}">
            </div>

            <div class="mb-3">
                <label>Adresse</label>
                <textarea name="address" class="form-control">{{ old('address', $tenant->address) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Logo</label><br>
                @if($tenant->logo_path)
                    <img src="{{ asset('storage/' . $tenant->logo_path) }}" width="80" class="mb-2 rounded">
                @endif
                <input type="file" name="logo" class="form-control">
            </div>

            <button class="btn btn-success">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection
