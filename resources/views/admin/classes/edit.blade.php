{{-- edit.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">✏️ Modifier la Classe</h1>
    <form action="{{ route('admin.classes.update', $class) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.classes.form')
    </form>
</div>
@endsection
