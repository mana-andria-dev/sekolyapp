@extends('admin.layout')

@section('title', 'Détails du bulletin')

@section('content')
<div class="container">
    <h1 class="mb-4">Bulletin de {{ $reportCard->student->first_name }} {{ $reportCard->student->last_name }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Élève :</strong> {{ $reportCard->student->first_name }} {{ $reportCard->student->last_name }}</p>
            <p><strong>Moyenne générale :</strong> {{ $reportCard->general_average }}</p>
            <p><strong>Appréciation :</strong> {{ $reportCard->appreciation ?? '—' }}</p>
        </div>
    </div>

    <a href="{{ route('admin.report_cards.index') }}" class="btn btn-secondary">Retour à la liste</a>
    <a href="{{ route('admin.report_cards.edit', $reportCard) }}" class="btn btn-warning">Modifier</a>
</div>
@endsection
