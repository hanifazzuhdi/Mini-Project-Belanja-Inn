@extends('layouts.admin')

@section('activeUser', 'active')
@section('content')

<div class="container">
    @if (session('status') )
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success !</strong> {{session('status')}} .
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif
</div>

<div class="container detail-user my-4">
    <div class="card card-detail-user p-4">

        <h4 class="card-title text-center my-4">Detail User</h4>

        <div class="container">
            <div class="row">
                <div class="kiri col-md-5">
                    <div class="card-body text-center">
                        <div class="image">
                            <img class="img " width="200px" height="200px" src="{{$data['avatar']}}" alt="Avatar">
                            <span class="upload">
                                <div type="button" data-toggle="modal" data-target="#avatar">
                                    <i class="fas fa-camera text-black-300"></i>
                                </div>
                            </span>
                        </div>
                        <fieldset disabled>
                            <div class=" mt-5 form-group" >
                                <span>Email : </span>
                                <input class="form-control" type="text" name="email" value="{{$data['email']}}">
                            </div>

                            <div class=" mt-1 form-group" >
                                <span>Username : </span>
                                <input class="form-control" type="text" name="username" value="{{$data['username']}}">
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class=" kanan col-md">
                    <form class="mt-4 form">
                        <fieldset disabled>
                            <div class="form-group">
                                <label> Name : </label>
                                <input type="text" class="form-control" name="name" value="{{$data['name']}}">
                            </div>

                            <div class="form-group">
                                <label> Address : </label>
                                <br>
                                <textarea class="form-control" name="address" id="address" cols="53" rows="3">{{$data['address']}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Phone Number : </label>
                                <input class="form-control" type="text" name="phone_number" value="{{$data['phone_number']}}">
                            </div>

                            <div class="form-group">
                                <label> Role : </label>
                                @if ($data['role_id'] == 1)
                                    <input type="text" class="form-control" name="role_id" value="User">
                                @else
                                    <input type="text" class="form-control" name="role_id" value="User + Penjual">
                                @endif
                            </div>

                            <div class="form-group  ">
                                <label> Email Verified : </label>
                                <input type="text" class="form-control" name="email_verified_at" value="{{$data['email_verified_at']}}">
                            </div>

                            <div class="form-group  ">
                                <label> Created At : </label>
                                <input type="text" class="form-control" name="created_at" value="{{$data['created_at']}}">
                            </div>

                            <div class="form-group  ">
                                <label> Updated At : </label>
                                <input type="text" class="form-control" name="updated_at" value="{{$data['updated_at']}}">
                            </div>
                        </fieldset>
                    </form>

                    <div class="danger">
                        <p class="text-left" >Danger Zone</p>

                        <form class="text-right">
                            <div class="btn btn-warning" type="button" data-toggle="modal" data-target="#update">
                                <i class="fas fa-edit  text-black-300"></i>
                            </div>

                            <div class="btn btn-danger" type="button" data-toggle="modal" data-target="#delete">
                                <i class="fas fa-trash  text-black-300"></i>
                            </div>
                        </form>
                    </div>


                    {{-- update avatar --}}
                    <div class="modal fade" id="avatar" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="avatar">Update data user</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/updateAvatar/{{$data['id']}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label>Avatar : </label>
                                            <br>
                                            <input type="file" name="avatar">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Update--}}
                    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="update" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="update">Update data user</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/updateUser/{{$data['id']}}" method="post">
                                        @csrf
                                        @method('put')

                                        <div class="form-group">
                                            <label>Name : </label>
                                            <input class="form-control" type="text" name="name" value="{{$data['name']}}">
                                        </div>

                                        <div class="form-group">
                                            <label>Password : </label>
                                            <input class="form-control" type="password" name="password" placeholder="*********">
                                            <small id="password" class="form-text text-muted">You can't see this password</small>
                                        </div>

                                        <div class="form-group">
                                            <label>Address : </label>
                                            <br>
                                            <textarea class="form-control" name="address" cols="49" rows="3">{{$data['address']}}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Phone Number : </label>
                                            <input class="form-control" type="text" name="phone_number" value="{{$data['phone_number']}}">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Confirm Delete--}}
                    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete"aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="delete">Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    Are you sure <strong> delete </strong> this account ? this will <strong> destroy all data </strong> from this account
                                </div>
                                <div class="modal-footer">
                                    <form action="{{'/delete/' . $data['id']}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
