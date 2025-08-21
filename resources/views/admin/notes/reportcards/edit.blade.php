@extends('admin.layout')

@section('title', 'Modifier un bulletin')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier un bulletin</h1>

    <form action="{{ route('admin.report_cards.update', $reportCard) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="student_id" class="form-label">Élève</label>
            <select name="student_id" id="student_id" class="form-select" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" @if($reportCard->student_id == $student->id) selected @endif>
                        {{ $student->first_name }} {{ $student->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="term" class="form-label">Trimestre / Période</label>
            <input type="text" name="term" id="term" class="form-control" value="{{ $reportCard->term }}" required>
        </div>

        <div class="mb-3">
            <label for="term" class="form-label">Année scolaire</label>
            <input type="text" name="term" id="term" class="form-control" value="{{ $reportCard->year }}" required>
        </div>

        <div class="mb-3">
            <label for="general_average" class="form-label">Moyenne générale</label>
            <input type="number" step="0.01" min="0" max="20" name="general_average" id="general_average" class="form-control" value="{{ $reportCard->general_average }}" required>
        </div>

        <div class="mb-3">
            <label for="appreciation" class="form-label">Appréciation</label>
            <textarea name="appreciation" id="appreciation" class="form-control" rows="3">{{ $reportCard->appreciation }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('admin.report_cards.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
