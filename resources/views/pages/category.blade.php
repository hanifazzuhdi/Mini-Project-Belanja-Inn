@extends('layouts.admin')

@section('activeSettings', 'active')
@section('content')

<h1 class="text-center mt-3 mb-5">Category Shop</h1>

<div class="container">
  <div class="card shadow mb-4">

    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6>
    </a>

    <div class="collapse show" id="collapseCardExample">
      <div class="card-body">

    @foreach ($categories as $category)
        <div class=" card-category card mb-4 mr-3 py-3 border-left-danger">
            <div class="card-body">
                <h6>{{$category['category_name']}}</h6>
            </div>
        </div>
    @endforeach

</div>
</div>
</div>


</div>

<div class="container d-flex flex-wrap justify-content-around">

    </div>

@endsection
