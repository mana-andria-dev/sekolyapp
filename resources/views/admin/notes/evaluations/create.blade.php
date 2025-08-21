@extends('admin.layout')

@section('title', 'Ajouter une évaluation')

@section('content')
<div class="container">
    <h1 class="mb-4">Ajouter une évaluation</h1>

    <form action="{{ route('admin.evaluations.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="tenant_id" class="form-label">Établissement</label>
            <select name="tenant_id" id="tenant_id" class="form-select" required>
                <option value="">-- Choisir un établissement --</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="subject_id" class="form-label">Matière</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                <option value="">-- Choisir une matière --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}"> {{ $subject->tenant->name }} > {{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="class_id" class="form-label">Classe</label>
            <select name="class_id" id="class_id" class="form-select" required>
                <option value="">-- Choisir une classe --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->tenant->name }} > {{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.evaluations.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection

