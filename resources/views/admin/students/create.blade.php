@extends('admin.layout')

@section('content')
<div class="container py-4 p-6">
    <h1 class="text-2xl font-bold mb-4">Ajouter un élève</h1>

    <form action="{{ route('admin.students.store') }}" method="POST">
        @include('admin.students._form', ['submitLabel' => 'Ajouter'])
    </form>
</div>
@endsection
