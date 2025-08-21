<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de notes - {{ $student->first_name }} {{ $student->last_name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
        header { text-align: center; margin-bottom: 30px; }
        .logo { max-height: 80px; margin-bottom: 10px; }
        h1 { font-size: 24px; margin: 0; }
        h2 { font-size: 20px; margin: 5px 0 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        footer { margin-top: 30px; text-align: center; font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <header>
        @if($student->tenant?->logo_path)
            <img src="{{ public_path('storage/'.$student->tenant->logo_path) }}" class="logo" alt="Logo de l'école">
        @endif
        <h1>{{ $student->tenant->name }}</h1>
        <p>{{ $student->tenant->address ?? '' }}</p>
        <p>Téléphone : {{ $student->tenant->phone ?? '' }} | Email : {{ $student->tenant->email }}</p>
    </header>

    <h2>Relevé de notes - {{ $student->first_name }} {{ $student->last_name }}</h2>
    <p>Classe : {{ $student->classes->pluck('name')->join(', ') }}</p>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Note</th>
                <th>Appréciation</th>
                <th>Trimestre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportCards as $card)
                <tr>
                    <td>{{ $card->evaluation?->subject?->name ?? '—' }}</td>
                    <td>{{ $card->general_average }}</td>
                    <td>{{ $card->appreciation }}</td>
                    <td>{{ $card->term }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        Généré le {{ now()->format('d/m/Y H:i') }} - SekolyPro
    </footer>
</body>
</html>
