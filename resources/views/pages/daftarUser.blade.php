@extends('layouts.admin')

@section('activeUser', 'active')
@section('content')

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

                            @if ($data['role_id'] == 1)
                                <td>User</td>
                            @else
                                <td>User + Penjual</td>
                            @endif

                            <td>{{$data['created_at']}}</td>
                            <td class="text-center">
                                <a href="{{'detailUser/' . $data['id'] }}">
                                    <i class="fas fa-eye text-black-300"></i>
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
