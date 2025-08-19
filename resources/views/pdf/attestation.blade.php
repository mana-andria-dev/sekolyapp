<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 40px; }
        h1 { text-align: center; }
        .content { margin-top: 40px; font-size: 14px; line-height: 1.6; }
        .signature { margin-top: 60px; text-align: right; }
    </style>
</head>
<body>
    <h1>Attestation</h1>

    <div class="content">
        <p>Nous attestons que :</p>
        <p>
            <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>, né(e) le 
            <strong>{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') : '---' }}</strong>,
        </p>
        <p>
            est actuellement inscrit(e) en tant qu’élève à l’établissement 
            <strong>{{ $student->tenant->name ?? '---' }}</strong>.
        </p>
        <p>
            Cette attestation est délivrée pour servir et valoir ce que de droit.
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
