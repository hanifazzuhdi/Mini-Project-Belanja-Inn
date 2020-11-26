@extends('layouts.admin')

@section('activeUser','active')
@section('content')

<div class="container detail-user my-4">
    <div class="card card-detail-user p-4">

        <h4 class="modal-title text-center" id="store"> DETAIL USER </h4>

        <div class="container">
            <div class="row">
                <div class="kiri col-md-5">
                    <div class="card-body text-center">

                        <div class="image">
                            <img class="img " width="200px" height="200px" src="{{$data['avatar']}}" alt="Avatar">

                           @if ($data['role_id'] == 3)
                            <div class="upload" type="button" data-toggle="modal" data-target="#avatar">
                               <i class="fas fa-camera text-black-300"></i>
                            </div>
                            @endif

                        </div>

                        <fieldset disabled>
                            <div class="mt-5 form-group" >
                                <span>Email : </span>
                                <input class="form-control mt-2" type="text" name="email" value="{{$data['email']}}">
                            </div>

                            <div class="mt-1 form-group" >
                                <span>Username : </span>
                                <input class="form-control mt-2" type="text" name="username" value="{{$data['username']}}">
                            </div>
                        </fieldset>

                        @if ($data['role_id'] == 2)
                        <form class="mt-4">
                            <div class="btn btn-primary" style="cursor: pointer" title="Show Shop" data-toggle="modal" data-target="#shop">
                                <i class="fas fa-store text-black-300"></i>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>

                <div class=" kanan col-md">
                    <form class="mt-4 form">
                        <fieldset disabled>
                            <div class="form-group">
                                <label> User ID : </label>
                                <input type="text" class="form-control" name="name" value="{{$data['id']}}">
                            </div>

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
                                @elseif ($data['role_id'] == 3)
                                    <input type="text" class="form-control" name="role_id" value="Admin">
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
                            @if ($data['role_id'] == 3)
                                <div class="btn btn-warning" type="button" data-toggle="modal" data-target="#update" title="Update">
                                    <i class="fas fa-edit  text-black-300"></i>
                                </div>
                            @endif

                            <div class="btn btn-danger" type="button" data-toggle="modal" data-target="#delete" title="Delete">
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

                    {{-- Modal Shop Shop --}}
                    <div class="modal fade" id="shop" tabindex="-1" role="dialog" aria-labelledby="shop" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="shop">Detail Shop</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="p-3">
                                        <fieldset disabled>
                                            <div class="image text-center mb-4">
                                                <img class="img " width="200px" height="200px" src="{{$shop['avatar']}}" alt="Avatar">
                                            </div>

                                            <div class="form-group">
                                                <label>Shop Name : </label>
                                                <input class="form-control" type="text" name="name" value="{{$shop['shop_name']}}">
                                            </div>

                                            <div class="form-group">
                                                <label>Address : </label>
                                                <br>
                                                <textarea class="form-control" name="address" cols="49" rows="3">{{$shop['address']}}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Description : </label>
                                                <input class="form-control" type="text" name="phone_number" value="{{$shop['description']}}">
                                            </div>

                                            <div class="form-group">
                                                <label>Creted At : </label>
                                                <input class="form-control" type="text" name="phone_number" value="{{$shop['created_at']}}">
                                            </div>

                                        </fieldset>

                                        <button class="btn btn-primary float-right mt-4 mb-4" type="button" data-dismiss="modal">Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Modal --}}

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
