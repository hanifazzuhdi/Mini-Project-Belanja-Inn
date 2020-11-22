@extends('layouts.admin')

@section('activeDashboard', 'active')
@section('content')

{{-- @dump($data) --}}

<div class="container detail-history my-4">

        <ul class="list-group">
            <div class="list-group-item active d-flex justify-content-between">
                <h3 >Order List</h3>
                <div>
                    <small>Order ID : {{$data[0]->id}}</small>
                    <br>
                    <small>Status : {{$data[0]['order']->status == 0 ? 'Pending' : 'Success'}}</small>
                    <br>
                    <small>Order At : {{$data[0]['order']->created_at}}</small>
                </div>
            </div>

            <div class="list-group-item">

                <div class="d-flex flex-wrap justify-content-around">
                    @php $i = 1 @endphp
                    @foreach ($data as $dat)

                    <div class="card shadow card-product my-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Product {{$i}}</h6>
                        </div>
                        <div class="card-body">
                            <fieldset disabled>
                                <label>Product Name : </label>
                                <input class="form-control" type="text" value="{{$dat['product']->product_name}}">

                                <label class="mt-3">Price Product : </label>
                                <input class="form-control" type="text" value="{{$dat['product']->price}}">

                                <label class="mt-3">Order Quantity : </label>
                                <input class="form-control" type="text" value="{{$dat->quantity}}">

                                <label class="mt-3">Order At : </label>
                                <input class="form-control" type="text" value="{{$dat->created_at}}">

                            </fieldset>
                        </div>
                    </div>

                    @php $i++ @endphp
                    @endforeach
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Transaction Information</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list">
                            @foreach ($data as $dat)
                            <li class="list-item mt-3">
                                <span>{{$dat['product']->product_name}}</span>
                                <br>
                                <small>
                                    Price : {{$dat['product']->price}} X {{$dat->quantity}} = {{number_format($dat->total_price,'0', ',','.' )}}
                                </small>
                            </li>
                            @endforeach
                            <br>
                            <hr>
                            <p class="mb-3"> Total Price = IDR. {{number_format($data[0]['order']->total_price,'0', ',', '.')}} </p>
                        </ul>

                        <a class="btn btn-outline-primary float-right print" href="#" role="button" onclick="window.print()">Print</a>
                        <a class="btn btn-primary float-right mr-2" href="{{route('home')}}" role="button">Back</a>
                    </div>
                </div>
            </div>


        </ul>
</div>

@endsection
