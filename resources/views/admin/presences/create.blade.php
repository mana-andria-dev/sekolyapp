@extends('admin.layout')

@section('title', 'Ajouter une présence')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Ajouter une présence</h1>

    <form action="{{ route('admin.presences.store', $student->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="date" class="block text-sm font-medium">Date</label>
            <input type="date" id="date" name="date" value="{{ old('date') }}"
                   class="w-full border rounded p-2 @error('date') border-red-500 @enderror">
            @error('date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium">Statut</label>
            <select id="status" name="status" class="w-full border rounded p-2 @error('status') border-red-500 @enderror">
                <option value="">-- Choisir --</option>
                <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Présent</option>
                <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium">Notes</label>
            <textarea id="notes" name="notes" rows="3" class="w-full border rounded p-2 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.students.show', $student->id) }}" class="px-4 py-2 bg-gray-300 rounded mr-2">Annuler</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
