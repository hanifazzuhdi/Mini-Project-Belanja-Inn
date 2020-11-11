@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

    <form action="update_product/5" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="text" name="product_name" placeholder="product_name">
        <input type="text" name="price" placeholder="price">
        <input type="text" name="quantity" placeholder="quantity">
        <input type="text" name="description" placeholder="description">
        <input type="file" name="image" placeholder="avatar">
        {{-- {{-- <input type="text" name="quantity" placeholder="quantity"> --}}
        <br>
        {{-- <input type="text" name="category_id" placeholder="category_id"> --}}

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>



    </div>
</div>
@endsection
