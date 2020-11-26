@extends('layouts.admin')

@section('activeSettings', 'active')
@section('content')

<div class="container store_account p-4 mt-5">
    <h2 class="font-weight-bold text-center mb-5"> CREATE ACCOUNT </h2>

    <div class="container">
        <form action="{{route('store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Your Email">
                </div>

                <div class="form-group col-md-6">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="password">
                </div>

                <div class="form-group col-md-6">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" placeholder="08XXXX">
                </div>

            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="address" placeholder="Address">
            </div>

            <div class="form-group">
                <label for="avatar">Avatar</label>
                <input type="file" class="form-control-file" id="avatar" name="avatar">
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                    Check me out
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Sign up</button>
        </form>
    </div>
</div>

@endsection
