@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

    <form action="/store" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="shop_name" placeholder="shop_name">
        <input type="file" name="avatar" placeholder="avatar">
        <br>
        <input type="text" name="address" placeholder="address">
        <input type="text" name="description" placeholder="description">

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    </div>
</div>
@endsection
