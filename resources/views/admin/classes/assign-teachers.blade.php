@extends('admin.layout')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white shadow rounded">
    <h1 class="text-xl font-bold mb-4">Assigner des professeurs à {{ $class->name }}</h1>

    <form action="{{ route('admin.classes.store.teachers', $class) }}" method="POST">
        @csrf
        @foreach($teachers as $teacher)
            <label class="block mb-1">
                <input type="checkbox" name="teachers[]" value="{{ $teacher->id }}"
                    {{ $class->teachers->contains($teacher->id) ? 'checked' : '' }}>
                {{ $teacher->first_name }} {{ $teacher->last_name }}
            </label>
        @endforeach

        <button class="bg-purple-500 text-white px-4 py-2 rounded mt-4">Enregistrer</button>
    </form>
</div>
@endsection
