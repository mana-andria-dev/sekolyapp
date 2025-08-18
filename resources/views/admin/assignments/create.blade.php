@extends('admin.layout')

@section('title', 'Nouveau devoir')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Créer un nouveau devoir</h1>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.assignments.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Fichier (optionnel)</label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                </div>                

                <div class="col-md-6">
                    <label class="form-label">Date limite <span class="text-danger">*</span></label>
                    <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                           value="{{ old('due_date') }}" required>
                    @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                              placeholder="Consignes, barème, ressources…">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Classe <span class="text-danger">*</span></label>
                    <select name="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                        <option value="">Sélectionner…</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" @selected(old('class_id') == $c->id)>
                                {{ $c->tenant->name ?? '' }} -> {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text"><i class="bi bi-info-circle"></i> L’enseignant et la matière doivent être associés à cette classe.</div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Matière <span class="text-danger">*</span></label>
                    <select name="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                        <option value="">Sélectionner…</option>
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" @selected(old('subject_id') == $s->id)>{{ $s->tenant->name ?? '' }} -> {{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Enseignant <span class="text-danger">*</span></label>
                    <select name="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror" required>
                        <option value="">Sélectionner…</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}" @selected(old('teacher_id') == $t->id)>
                                {{ $t->tenant->name ?? '' }} -> {{ $t->last_name }} {{ $t->first_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-light">Annuler</a>
                <button class="btn btn-primary">
                    <i class="bi bi-check2-circle"></i> Créer le devoir
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
