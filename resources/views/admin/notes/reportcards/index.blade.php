@extends('admin.layout')

@section('title', 'Bulletins scolaires')

@section('content')
<div class="container">
    <h1 class="mb-4">Bulletins scolaires</h1>
    <a href="{{ route('admin.report_cards.create') }}" class="btn btn-primary mb-3">➕ Nouveau bulletin</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Élève</th>
                <th>Moyenne générale</th>
                <th>Appréciation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportCards as $card)
                <tr>
                    <td>{{ $card->student->first_name }} {{ $card->student->last_name }}</td>
                    <td>{{ $card->general_average }}</td>
                    <td>{{ $card->appreciation }}</td>
                    <td>
                        <a href="{{ route('admin.report_cards.show', $card) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('admin.report_cards.edit', $card) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('admin.report_cards.destroy', $card) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        <a href="{{ route('students.documents.releve', $card->student) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Relevé de notes
                            <span class="badge bg-primary">Télécharger</span>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Aucun bulletin disponible</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $reportCards->links() }}
</div>
@endsection
