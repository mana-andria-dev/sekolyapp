@extends('admin.layout')

@section('content')
<div class="container py-4">
    <h2>{{ $assignment->title }}</h2>
    <p>Matière : {{ $assignment->subject->name }}</p>
    <p>Classe : {{ $assignment->class->name }}</p>
    <p>Date limite : {{ $assignment->due_date }}</p>
    <p>{{ $assignment->description }}</p>

    <hr>

    <h4>Votre soumission</h4>
    <form action="{{ route('student.assignments.submit', $assignment) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Réponse (texte)</label>
            <textarea name="answer" class="form-control" rows="5">{{ $submission->answer }}</textarea>
        </div>
        <div class="mb-3">
            <label>Fichier</label>
            <input type="file" name="file" class="form-control">
            @if($submission->file_path)
                <a href="{{ asset('storage/'.$submission->file_path) }}" target="_blank">📄 Voir fichier soumis</a>
            @endif
        </div>
        <button type="submit" class="btn btn-success">Soumettre</button>
    </form>

    @if($submission->grade)
        <hr>
        <p><strong>Note :</strong> {{ $submission->grade }}/20</p>
        <p><strong>Feedback :</strong> {{ $submission->feedback }}</p>
    @endif
</div>
@endsection
