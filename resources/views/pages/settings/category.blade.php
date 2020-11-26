@extends('layouts.admin')

@section('activeSettings', 'active')
@section('content')

<div class="container">
    <h1 class="text-center">Category</h1>

    @foreach ($categories as $category)
    <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Category Name</th>
            <th scope="col">tag Image</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            <td>@twitter</td>
          </tr>
        </tbody>
      </table>
    @endforeach
</div>

@endsection
