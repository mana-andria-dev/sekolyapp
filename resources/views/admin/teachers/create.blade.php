@extends('admin.layout')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-3">➕ Ajouter un enseignant</h1>

    <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm p-4">
        @csrf
        <div class="row">
            <div class="mb-3">
                <label for="tenant_id" class="form-label">Établissement</label>
                <select name="tenant_id" id="tenant_id" class="form-select" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                    @endforeach
                </select>
            </div>            
            <div class="col-md-6 mb-3">
                <label>Prénom</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nom</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Téléphone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Matière</label>
                <input type="text" name="subject" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>
            <div class="col-12 mb-3">
                <label>Biographie</label>
                <textarea name="bio" rows="4" class="form-control"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-success" style="width: 100%;">💾 Enregistrer</button>
            </div>
            <div class="col-md-6">
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary" style="width: 100%;">Annuler</a>
            </div>
        </div>
    </form>
</div>
@endsection
