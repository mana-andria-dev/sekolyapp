<div class="card shadow-sm mb-4">
    <div class="card-body d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <div>
            <h4>{{ $student->first_name }} {{ $student->last_name }}</h4>
            <p class="mb-0">
                @if($student->status === 'active')
                    ✅ Actif
                @elseif($student->status === 'inactive')
                    ⏸️ Inactif
                @elseif($student->status === 'graduated')
                    🎓 Diplômé
                @else
                    ⚠️ Suspendu
                @endif
            </p>
        </div>
        <div class="text-end">
            <small>Date d'inscription</small>
            <div>{{ $student->enrollment_date }}</div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p>⚧ <strong>Genre :</strong> {{ $student->gender ?? '-' }}</p>
                <p>🎂 <strong>Date de naissance :</strong> {{ $student->birth_date ?? '-' }}</p>
                <p>🏫 <strong>Établissement :</strong> {{ $student->tenant->restaurant_name ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p>📍 <strong>Adresse :</strong> {{ $student->address ?? '-' }}</p>
                <p>📞 <strong>Téléphone :</strong> {{ $student->phone ?? '-' }}</p>
                <p>📧 <strong>Email :</strong> {{ $student->email ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
