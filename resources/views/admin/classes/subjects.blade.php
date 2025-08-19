@extends('admin.layout')

@section('content')
<div class="container py-4">
    <h2>📚 Associer des matières à la classe : {{ $class->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('classes.updateSubjects', $class) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="subjects" class="form-label">Sélectionnez les matières :</label>
            <select name="subjects[]" id="subjects" class="form-select" multiple>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}"
                        {{ $class->subjects->contains($subject->id) ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Maintenir CTRL (Windows) ou CMD (Mac) pour sélectionner plusieurs matières</small>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection
