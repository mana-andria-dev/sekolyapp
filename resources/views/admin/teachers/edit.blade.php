@extends('admin.layout')

@section('content')
<div class="container py-4">

    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">✏️ Modifier un enseignant</h1>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Etablissement --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Établissement</label>
                    <select name="tenant_id" class="form-control" required>
                        <option value="">-- Sélectionner un établissement --</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}"
                                {{ (string)$tenant->id === (string) old('tenant_id', $teacher->tenant_id ?? '') ? 'selected' : '' }}>
                                {{ $tenant->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tenant_id') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Nom et prénom --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Prénom</label>
                        <input type="text" name="first_name" class="form-control"
                               value="{{ old('first_name', $teacher->first_name ?? '') }}" required>
                        @error('first_name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nom</label>
                        <input type="text" name="last_name" class="form-control"
                               value="{{ old('last_name', $teacher->last_name ?? '') }}" required>
                        @error('last_name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Email & téléphone --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $teacher->email ?? '') }}" required>
                        @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Téléphone</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone', $teacher->phone ?? '') }}">
                        @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Matière --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Matière enseignée</label>
                    <input type="text" name="subject" class="form-control"
                           value="{{ old('subject', $teacher->subject ?? '') }}">
                    @error('subject') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Bio --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Biographie</label>
                    <textarea name="bio" class="form-control" rows="3">{{ old('bio', $teacher->bio ?? '') }}</textarea>
                    @error('bio') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Photo --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Photo</label>
                    <input type="file" name="photo_path" class="form-control">
                    @if($teacher->photo_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$teacher->photo_path) }}" 
                                 alt="Photo de {{ $teacher->first_name }}" 
                                 class="img-thumbnail" width="120">
                        </div>
                    @endif
                    @error('photo_path') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Mettre à jour
                </button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Annuler
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
