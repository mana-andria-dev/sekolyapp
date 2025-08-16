@extends('admin.layout')

@section('title', 'Ajouter un Tenant')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('tenants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label>Type</label>
                <select name="type" class="form-select" required>
                    <option value="">— Choisir —</option>
                    <option value="ecole">École</option>
                    <option value="college">Collège</option>
                    <option value="universite">Université</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label>Téléphone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label>Adresse</label>
                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control">
            </div>

            <button class="btn btn-success">Enregistrer</button>
        </form>
    </div>
</div>
@endsection
