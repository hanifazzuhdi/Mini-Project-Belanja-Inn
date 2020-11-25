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

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">USER</h6>
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
                                <a href="{{'delete/' . $data['id'] }}">
                                    <i class="fas fa-trash text-black-300"></i>
                                </a>
                            </td>
                        </tr>

                        @php $i++ @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
  <!-- /.container-fluid -->
@endsection
