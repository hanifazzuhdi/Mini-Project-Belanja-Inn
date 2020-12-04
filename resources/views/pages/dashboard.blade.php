    @extends('layouts.admin')

    @section('activeDashboard', 'active')
    @section('content')

    {{-- @dump($_event) --}}

    <div class="container-fluid">

        <div class="d-sm-flex  align-items-center justify-content-between mb-4">
            <a href="#" onclick="window.print()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i>
                 Generate Report
            </a>
        </div>

        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    user active</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$active[0]->active}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    shop active</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$shop[0]->shop}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-store fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    transaction success</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_transaction ? $total_transaction : 0 }} <small> Order Success </small></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-handshake fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                   total transaction</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">IDR {{$transaction ? number_format($transaction, '0', ',', '.' ): 0}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div class="container history mt-4">

         <form action="" method="post">
            <input class="form-control search" placeholder="Search" type="text">
            <button class="btn btn-primary" type="submit">
                Search
            </button>
        </form>

        <h6 class="list-group-item active">History Transaction</h6>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Total Transaction</th>
                    <th scope="col">Status Checkout</th>
                    <th scope="col">Date</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($histories as $history)
            <tr>
                <th scope="row">{{$history['id']}}</th>
                <td>{{$history['user']->username}}</td>
                <td>IDR {{number_format($history->total_price, '0', ',', '.')}}</td>
                <td>{{ $history->status == 0 ? 'Pending' : 'Success' }}</td>
                <td>{{$history->date}}</td>
                <td class="text-center">
                    <a href="{{'detailHistory/' . $history['id'] }}">
                        <i class="fas fa-eye text-black-300"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <span class="paginate">
        {{$histories->links()}}
    </span>

@endsection
