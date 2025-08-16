@csrf
@csrf
<div class="card shadow-sm">
    <div class="card-header border-bottom-0">
        <ul class="nav nav-tabs card-header-tabs" id="classTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="infos-tab" data-bs-toggle="tab"
                        data-bs-target="#infos" type="button" role="tab" aria-controls="infos"
                        aria-selected="true">
                    <i class="bi bi-pencil-square"></i> Infos classe
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="eleves-tab" data-bs-toggle="tab"
                        data-bs-target="#eleves" type="button" role="tab" aria-controls="eleves"
                        aria-selected="false">
                    <i class="bi bi-people"></i> Élèves assignés
                </button>
            </li>
        </ul>
    </div>

    <div class="card-body tab-content" id="classTabsContent">
        {{-- Onglet Infos classe --}}
        <div class="tab-pane fade show active" id="infos" role="tabpanel" aria-labelledby="infos-tab">
            <div class="mb-3">
                <label class="form-label fw-bold">Établissement</label>
                <select name="tenant_id" class="form-control" required>
                    <option value="">-- Sélectionner un établissement --</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}"
                            {{ (string)$tenant->id === (string) old('tenant_id', $class->tenant_id ?? '') ? 'selected' : '' }}>
                            {{ $tenant->name }}
                        </option>
                    @endforeach
                </select>
                @error('tenant_id') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nom de la classe</label>
                <input type="text" name="name"
                       value="{{ old('name', $class->name ?? '') }}"
                       class="form-control" placeholder="Ex: 5ème A" required>
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Niveau</label>
                <input type="text" name="level"
                       value="{{ old('level', $class->level ?? '') }}"
                       class="form-control" placeholder="Ex: 3ème" required>
                @error('level') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="Description de la classe">{{ old('description', $class->description ?? '') }}</textarea>
                @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Onglet Élèves assignés --}}
        <div class="tab-pane fade" id="eleves" role="tabpanel" aria-labelledby="eleves-tab">
            @if($class->students->isNotEmpty())
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom & Prénom</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($class->students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    <form action=" {{ route('admin.students.removeClass', [$student, $class]) }} " method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Retirer cet élève de la classe ?')">
                                            <i class="bi bi-x-circle"></i> Retirer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">
                    Aucun élève n’est assigné à cette classe pour le moment.
                </div>
            @endif
        </div>
    </div>

    <div class="card-footer text-end">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Enregistrer
        </button>
        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Annuler
        </a>
    </div>
</div>

