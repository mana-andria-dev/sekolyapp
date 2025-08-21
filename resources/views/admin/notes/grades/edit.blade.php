@extends('admin.layout')

@section('title', 'Modifier une note')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier une note</h1>

    <form action="{{ route('admin.grades.update', $grade) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="student_id" class="form-label">Élève</label>
            <select name="student_id" id="student_id" class="form-select" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" @selected($student->id == $grade->student_id)>
                        {{ $student->last_name }} {{ $student->first_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="evaluation_id" class="form-label">Évaluation</label>
            <select name="evaluation_id" id="evaluation_id" class="form-select" required>
                @foreach($evaluations as $evaluation)
                    <option value="{{ $evaluation->id }}" @selected($evaluation->id == $grade->evaluation_id)>
                        {{ $evaluation->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="score" class="form-label">Note</label>
            <input type="number" name="score" id="score" class="form-control" required min="0" value="{{ $grade->score }}">
        </div>

        <div class="mb-3">
            <label for="remark" class="form-label">Remarque</label>
            <textarea name="remark" id="remark" class="form-control">{{ $grade->remark }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.grades.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
