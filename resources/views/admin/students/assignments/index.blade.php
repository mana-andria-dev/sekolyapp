@extends('admin.layout')

@section('content')
<div class="container py-4">
    <h2>Devoir : {{ $assignment->title }}</h2>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Élève</th>
                <th>Réponse</th>
                <th>Fichier</th>
                <th>Note</th>
                <th>Feedback</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $submission)
            <tr>
                <td>{{ $submission->student->first_name }} {{ $submission->student->last_name }}</td>
                <td>{{ Str::limit($submission->answer,50) }}</td>
                <td>
                    @if($submission->file_path)
                        <a href="{{ asset('storage/'.$submission->file_path) }}" target="_blank">📄 Voir</a>
                    @endif
                </td>
                <form action="{{ route('teacher.assignments.submissions.grade', [$assignment,$submission]) }}" method="POST">
                    @csrf
                    <td>
                        <input type="number" name="grade" value="{{ $submission->grade }}" class="form-control" min="0" max="20" step="0.01">
                    </td>
                    <td>
                        <textarea name="feedback" class="form-control">{{ $submission->feedback }}</textarea>
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm">💾 Mettre à jour</button>
                    </td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
