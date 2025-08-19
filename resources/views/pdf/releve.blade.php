<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de notes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 40px; }
        h1 { text-align: center; }
        .student-info { margin-top: 20px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .signature { margin-top: 40px; text-align: right; }
    </style>
</head>
<body>
    <h1>Relevé de notes</h1>

    <div class="student-info">
        <p><strong>Élève :</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
        <p><strong>Classe :</strong> {{ $student->class->name ?? '---' }}</p>
        <p><strong>Année scolaire :</strong> {{ now()->year }} - {{ now()->year + 1 }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Note</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notes ?? [] as $note)
                <tr>
                    <td>{{ $note->subject->name ?? '---' }}</td>
                    <td>{{ $note->value ?? '—' }}</td>
                    <td>{{ $note->comment ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Aucune note disponible</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature">
        <p>
            Fait à {{ $student->tenant->city ?? '...' }}, le {{ now()->format('d/m/Y') }}
        </p>
        <p>
            <br>_________________________<br>
            Signature et cachet
        </p>
    </div>
</body>
</html>
