<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat de scolarité</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 40px; }
        h1 { text-align: center; }
        .content { margin-top: 40px; font-size: 14px; line-height: 1.6; }
        .signature { margin-top: 60px; text-align: right; }
    </style>
</head>
<body>
    <h1>Certificat de scolarité</h1>

    <div class="content">
        <p>Nous certifions que :</p>
        <p>
            <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>, né(e) le 
            <strong>
                {{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') : '---' }}
            </strong>,
        </p>
        <p>
            est inscrit(e) en tant qu’élève à l’établissement 
            <strong>{{ $student->tenant->name ?? '---' }}</strong>
            pour l’année scolaire 
            <strong>{{ now()->year }} - {{ now()->year + 1 }}</strong>.
        </p>
    </div>

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
