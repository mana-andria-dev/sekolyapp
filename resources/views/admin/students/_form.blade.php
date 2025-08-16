@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Prénom</label>
        <input type="text" name="first_name" value="{{ old('first_name', $student->first_name ?? '') }}"
               class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nom</label>
        <input type="text" name="last_name" value="{{ old('last_name', $student->last_name ?? '') }}"
               class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Genre</label>
        <select name="gender" class="form-select">
            <option value="">-- Sélectionner --</option>
            <option value="M" {{ old('gender', $student->gender ?? '') == 'M' ? 'selected' : '' }}>Masculin</option>
            <option value="F" {{ old('gender', $student->gender ?? '') == 'F' ? 'selected' : '' }}>Féminin</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Date de naissance</label>
        <input type="date" name="birth_date" value="{{ old('birth_date', $student->birth_date ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Téléphone</label>
        <input type="text" name="phone" value="{{ old('phone', $student->phone ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $student->email ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-12">
        <label class="form-label">Adresse</label>
        <textarea name="address" class="form-control" rows="2">{{ old('address', $student->address ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Date d'inscription</label>
        <input type="date" name="enrollment_date" value="{{ old('enrollment_date', $student->enrollment_date ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Statut</label>
        <select name="status" class="form-select">
            <option value="active" {{ old('status', $student->status ?? '') == 'active' ? 'selected' : '' }}>Actif</option>
            <option value="inactive" {{ old('status', $student->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactif</option>
            <option value="graduated" {{ old('status', $student->status ?? '') == 'graduated' ? 'selected' : '' }}>Diplômé</option>
            <option value="suspended" {{ old('status', $student->status ?? '') == 'suspended' ? 'selected' : '' }}>Suspendu</option>
        </select>
    </div>

    <div class="col-md-12">
        <label class="form-label">Établissement</label>
        <select name="tenant_id" class="form-select">
            <option value="">-- Non assigné --</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" {{ old('tenant_id', $student->tenant_id ?? '') == $tenant->id ? 'selected' : '' }}>
                    {{ $tenant->restaurant_name ?? $tenant->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> {{ $submitLabel ?? 'Enregistrer' }}
    </button>
</div>
