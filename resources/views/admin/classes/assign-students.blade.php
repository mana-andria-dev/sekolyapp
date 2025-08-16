@extends('admin.layout')

@section('content')
<div class="p-6 max-w-lg mx-auto bg-white shadow rounded">
    <h1 class="text-xl font-bold mb-4">Assigner des élèves à {{ $class->name }}</h1>

    <form action="{{ route('admin.classes.store.students', $class) }}" method="POST">
        @csrf
        @foreach($students as $student)
            <label class="block mb-1">
                <input type="checkbox" name="students[]" value="{{ $student->id }}"
                    {{ $class->students->contains($student->id) ? 'checked' : '' }}>
                {{ $student->first_name }} {{ $student->last_name }}
            </label>
        @endforeach

        <button class="bg-green-500 text-white px-4 py-2 rounded mt-4">Enregistrer</button>
    </form>
</div>
@endsection
