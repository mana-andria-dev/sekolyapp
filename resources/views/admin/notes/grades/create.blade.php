@extends('admin.layout')

@section('title', 'Ajouter une note')

@section('content')
<div class="container">
    <h1 class="mb-4">Ajouter une note</h1>

    <form action="{{ route('admin.grades.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="student_id" class="form-label">Élève</label>
            <select name="student_id" id="student_id" class="form-select" required>
                <option value="">-- Choisir un élève --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->last_name }} {{ $student->first_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="evaluation_id" class="form-label">Évaluation</label>
            <select name="evaluation_id" id="evaluation_id" class="form-select" required>
                <option value="">-- Choisir une évaluation --</option>
                @foreach($evaluations as $evaluation)
                    <option value="{{ $evaluation->id }}">{{ $evaluation->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="score" class="form-label">Note</label>
            <input type="number" name="score" id="score" class="form-control" required min="0">
        </div>

        <div class="mb-3">
            <label for="remark" class="form-label">Remarque</label>
            <textarea name="remark" id="remark" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.grades.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
