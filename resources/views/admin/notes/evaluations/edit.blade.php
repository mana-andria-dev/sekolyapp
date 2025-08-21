@extends('admin.layout')

@section('title', 'Modifier une évaluation')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier une évaluation</h1>

    <form action="{{ route('admin.evaluations.update', $evaluation) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $evaluation->title }}" required>
        </div>

        <div class="mb-3">
            <label for="subject_id" class="form-label">Matière</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected($subject->id == $evaluation->subject_id)>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="class_id" class="form-label">Classe</label>
            <select name="class_id" id="class_id" class="form-select" required>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected($class->id == $evaluation->class_id)>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $evaluation->date }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.evaluations.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
