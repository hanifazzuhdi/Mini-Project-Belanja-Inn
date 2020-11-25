@extends('layouts.admin')

@section('activeSettings', 'active')
@section('content')

    <h1 class="text-center">Category</h1>

    @foreach ($categories as $category)
        <p> <?= $category->category_name ?> </p>
    @endforeach

@endsection
