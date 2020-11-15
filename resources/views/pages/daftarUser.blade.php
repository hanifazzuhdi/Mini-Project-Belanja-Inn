@extends('layouts.admin')

@section('activeUser', 'active')
@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Created At</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        @foreach ($datas as $data)

                        <tr>
                            <td>{{$data['name']}}</td>
                            <td>{{$data['email']}}</td>
                            <td>{{$data['username']}}</td>
                            <td>{{$data['phone_number']}}</td>

                            @if ($data['role_id'] == 1)
                                <td>User</td>
                            @else
                                <td>User + Penjual</td>
                            @endif

                            <td>{{$data['created_at']}}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
  <!-- /.container-fluid -->
@endsection
