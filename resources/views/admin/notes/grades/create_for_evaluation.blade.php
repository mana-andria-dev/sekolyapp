@extends('admin.layout')

@section('title', 'Saisie des notes - '.$evaluation->title)

@section('content')
<div class="container">
    <h1 class="mb-4">Saisie des notes pour : {{ $evaluation->title }}</h1>
    <form action="{{ route('admin.grades.storeForEvaluation', $evaluation) }}" method="POST">
        @csrf

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Élève</th>
                    <th>Note</th>
                    <th>Remarque</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>
                            <input type="number" step="0.01" name="grades[{{ $student->id }}][score]" 
                                   value="{{ $grades[$student->id]->score ?? '' }}" class="form-control" required>
                            <input type="hidden" name="grades[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                        </td>
                        <td>
                            <input type="text" name="grades[{{ $student->id }}][remark]" 
                                   value="{{ $grades[$student->id]->remark ?? '' }}" class="form-control">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Enregistrer les notes</button>
        <a href="{{ route('admin.evaluations.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
