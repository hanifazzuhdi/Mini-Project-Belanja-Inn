@extends('layouts.admin')

@section('activeProduct','active')
@section('content')

<div class="container detail-user my-4">
    <div class="card card-detail-user p-4">

        <h4 class="modal-title text-center" id="store"> DETAIL PRODUCT </h4>

        <div class="container">
            <div class="row">
                <div class="kiri col-md-5">
                    <div class="card-body text-center">

                        <div class="image">
                            <img class="img " width="200px" height="200px" src="{{$data['image']}}" alt="Avatar">
                        </div>

                        <fieldset disabled>
                            <div class=" mt-5 form-group" >
                                <label>Shop Name : </label>
                                <input class="form-control" type="text" name="username" value="{{$data['shop']->shop_name}}">
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
                    </div>
                </div>

                <div class=" kanan col-md">
                    <form class="mt-4 form">
                        <fieldset disabled>
                            <div class="form-group">
                                <label> Product ID : </label>
                                <input type="text" class="form-control" name="name" value="{{$data['id']}}">
                            </div>

                            <div class="form-group" >
                                <span>Product Name : </span>
                                <input class="form-control" type="text" name="email" value="{{$data['product_name']}}">
                            </div>

                            <div class="form-group" >
                                <span>Category : </span>
                                <input class="form-control" type="text" name="email" value="{{$data['category']['category_name']}}">
                            </div>

                            <div class="form-group" >
                                <span>Price : </span>
                                <input class="form-control" type="text" name="email" value="{{$data['price']}}">
                            </div>

                            <div class="form-group" >
                                <span>Quantity : </span>
                                <input class="form-control" type="text" name="email" value="{{$data['quantity']}}">
                            </div>

                            <div class="form-group" >
                                <span>Weight : </span>
                                <input class="form-control" type="text" name="email" value="{{$data['weight']}}">
                            </div>


                            <div class="form-group" >
                                <span>Sold : </span>
                                <input class="form-control" type="text" name="email" value="{{$data['sold']}}">
                            </div>


                            <div class="form-group">
                                <label> Description : </label>
                                <br>
                                <textarea class="form-control" name="address" id="address" cols="53" rows="3">{{$data['description']}}</textarea>
                            </div>

                        </fieldset>
                    </form>

                    <div class="danger-product">
                        <p class="text-left" >Danger Zone</p>

                            <div class="btn btn-danger delete" type="button" data-toggle="modal" data-target="#delete">
                                <i class="fas fa-trash  text-black-300"></i>
                            </div>
                        </form>
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
                                    Are you sure <strong> delete </strong> this product ? this will <strong> destroy all data </strong> from this account
                                </div>
                                <div class="modal-footer">
                                    <form action="{{'/deleteProduct/' . $data['id']}}" method="post">
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
