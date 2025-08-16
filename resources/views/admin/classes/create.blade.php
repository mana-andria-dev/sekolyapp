{{-- create.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">➕ Nouvelle Classe</h1>
    <form action="{{ route('admin.classes.store') }}" method="POST">
        @include('admin.classes.form')
    </form>
</div>
@endsection
