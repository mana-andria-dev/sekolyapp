@extends('admin.layout')

@section('content')
<div class="container py-4 p-6">
    <h1 class="text-2xl font-bold mb-4">Modifier un élève</h1>

    <form action="{{ route('admin.students.update', $student) }}" method="POST">
        @method('PUT')
        @include('admin.students._form', ['submitLabel' => 'Mettre à jour'])
    </form>
</div>
@endsection
