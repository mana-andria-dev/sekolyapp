@extends('admin.layout')

@section('title', 'Évaluations')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des évaluations</h1>

    <a href="{{ route('admin.evaluations.create') }}" class="btn btn-primary mb-3">+ Ajouter une évaluation</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Matière</th>
                <th>Classe</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evaluations as $evaluation)
                <tr>
                    <td>{{ $evaluation->title }}</td>
                    <td>
                        <a href="{{ route('admin.grades.createForEvaluation', $evaluation) }}" class="btn btn-success btn-sm">
                            🖊️ Saisir notes
                        </a>
                    </td>
                    <td>{{ $evaluation->subject->name ?? '-' }}</td>
                    <td>{{ $evaluation->class->name ?? '-' }}</td>
                    <td>{{ $evaluation->date }}</td>
                    <td>
                        <a href="{{ route('admin.evaluations.edit', $evaluation) }}" class="btn btn-sm btn-warning">✏️</a>
                        <a href="{{ route('admin.grades.createForEvaluation', $evaluation) }}" class="btn btn-sm btn-success">🖊️ Saisir notes</a>
                        <form action="{{ route('admin.evaluations.destroy', $evaluation) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Aucune évaluation</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $evaluations->links() }}
</div>
@endsection
