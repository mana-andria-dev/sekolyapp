@extends('admin.layout')

@section('title', 'Créer un bulletin')

@section('content')
<div class="container">
    <h1 class="mb-4">Créer un bulletin</h1>

    <form action="{{ route('admin.report_cards.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="tenant_id" class="form-label">Établissement</label>
            <select name="tenant_id" id="tenant_id" class="form-select" required>
                <option value="">-- Choisir un établissement --</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                        {{ $tenant->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="student_id" class="form-label">Élève</label>
            <select name="student_id" id="student_id" class="form-select" required>
                <option value="">-- Choisir un élève --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->tenant->name }} > {{ $student->first_name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="term" class="form-label">Trimestre / Période</label>
            <input type="text" name="term" id="term" class="form-control" value="{{ old('term', $reportCard->term ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Année scolaire</label>
            <input type="text" name="year" id="year" class="form-control" value="{{ old('year', $reportCard->year ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="general_average" class="form-label">Moyenne générale</label>
            <input type="number" step="0.01" min="0" max="20" name="general_average" id="general_average" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="appreciation" class="form-label">Appréciation</label>
            <textarea name="appreciation" id="appreciation" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.report_cards.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
