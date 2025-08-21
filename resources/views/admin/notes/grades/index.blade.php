@extends('admin.layout')

@section('title', 'Notes des élèves')

@section('content')
<div class="container">
    <h1 class="mb-4">Notes des élèves</h1>

    {{-- Liste des évaluations --}}
    <h3 class="mb-3">Évaluations disponibles</h3>
    <table class="table table-bordered mb-5">
        <thead class="table-light">
            <tr>
                <th>Matière</th>
                <th>Classe</th>
                <th>Type</th>
                <th>Titre</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evaluations as $evaluation)
                <tr>
                    <td>{{ $evaluation->subject->name }}</td>
                    <td>{{ $evaluation->class->name }}</td>
                    <td>{{ ucfirst($evaluation->type) }}</td>
                    <td>{{ $evaluation->title }}</td>
                    <td>{{ $evaluation->date }}</td>
                    <td>
                        <a href="{{ route('admin.grades.createForEvaluation', $evaluation) }}" 
                           class="btn btn-success btn-sm">
                            🖊️ Saisir notes
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune évaluation disponible</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Liste des notes déjà saisies --}}
    <h3 class="mb-3">Notes saisies</h3>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Élève</th>
                <th>Évaluation</th>
                <th>Note</th>
                <th>Commentaires</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grades as $grade)
                <tr>
                    <td>{{ $grade->student->first_name }} {{ $grade->student->last_name }}</td>
                    <td>{{ $grade->evaluation->subject->name }} ({{ ucfirst($grade->evaluation->type) }})</td>
                    <td>{{ $grade->score }}</td>
                    <td>{{ $grade->remark }}</td>
                    <td>
                        <a href="{{ route('admin.grades.edit', $grade) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Aucune note enregistrée</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
