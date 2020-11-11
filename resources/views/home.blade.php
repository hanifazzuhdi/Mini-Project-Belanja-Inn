@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

    <form action="{{route('store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @put
        <input type="text" name="product_name" placeholder="shope_name">
        <input type="text" name="price" placeholder="price">
        <input type="text" name="quantity" placeholder="quantity">
        <input type="text" name="description" placeholder="description">
        <input type="file" name="avatar" placeholder="avatar">
        {{-- {{-- <input type="text" name="quantity" placeholder="quantity"> --}}
        <br>
        {{-- <input type="text" name="category_id" placeholder="category_id"> --}}

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>



    </div>
</div>
@endsection
