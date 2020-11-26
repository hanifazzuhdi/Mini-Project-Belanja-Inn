@extends('layouts.admin')

@section('activeSettings', 'active')
@section('content')

 <div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="font-weight-bold text-primary">LIST ADMIN</h6>

            <div class="btn btn-primary float-right" type="button" data-toggle="modal" data-target="#store">
                <i class="fas fa-plus text-black"></i>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach ($datas as $data)

                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$data['name']}}</td>
                            <td>{{$data['username']}}</td>
                            <td>{{$data['email']}}</td>
                            <td>{{$data['phone_number']}}</td>

                            @if ($data['role_id'] == 3)
                                <td>Admin</td>
                            @endif

                            <td>{{$data['created_at']}}</td>

                            <td class="text-center">
                                <a href="{{'/detailUser/' . $data['id'] }}">
                                    <i class="fas fa-eye text-black-300"></i>
                                </a>
                            </td>
                        </tr>

                        @php $i++ @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- tambah akun admin --}}
            <div class="modal fade bd-example-modal-lg" id="store" tabindex="-1" role="dialog" aria-labelledby="store" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header store_account">
                            <h5 class="modal-title text-center" id="store"> CREATE ACCOUNT </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="{{route('store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Your Email">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" placeholder="Username">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Admin">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number" placeholder="08XXXX">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Address">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="avatar">Avatar</label>
                                    <input type="file" class="form-control-file" id="avatar" name="avatar">
                                </div>

                                <button type="submit" class="btn btn-primary">Sign up</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- /.container-fluid -->
@endsection
