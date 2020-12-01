@extends('layouts.admin')

@section('activeSettings', 'active')
@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="font-weight-bold text-primary">CATEGORIES</h6>

            <div class="btn btn-primary btn-sm float-right" type="button" data-toggle="modal" data-target="#store">
                <i class="fas fa-plus text-black"></i>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category Name</th>
                            <th>Created At</th>
                            <th style="width: 70px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{$category['id']}}</td>
                            <td>{{$category['category_name']}}</td>
                            <td>{{$category['created_at']}}</td>

                            <td class="d-flex justify-content-center">
                                <div class="btn btn-warning btn-sm float-left mr-2" data-toggle="modal" data-target="#update">
                                    <i class="fas fa-edit text-black-300"></i>
                                </div>

                                <form action="{{'/deleteCategory/' . $category['id']}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm btn-delete" type="submit" onclick="return confirm('Yakin hapus data ?')">
                                        <i class="fas fa-trash text-black-300"></i>
                                    </button>
                                </form>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{--modal update--}}
            <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="update" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header  store_account">
                            <h5 class="modal-title" id="update">Update Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="#" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label>Category Name : </label>
                                    <input class="form-control" type="text" name="category_name" value="">
                                </div>

                                <div class="form-group">
                                    <label>Image : </label>
                                    <br>
                                    <input type="file" name="image" value="">
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

            {{-- tambah category baru --}}
            <div class="modal fade" id="store" tabindex="-1" role="dialog" aria-labelledby="store" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header store_account">
                            <h5 class="modal-title text-center"> CREATE NEW CATEGORY </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('storeCategory')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="form-group">
                                        <label>Category Name :</label>
                                        <input type="text" class="form-control" name="category_name" placeholder="Category Name">
                                    </div>

                                    <div class="form-group">
                                        <label>Image :</label>
                                        <br>
                                        <input type="file" name="image">
                                    </div>

                                    <div class="float-right mt-4">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            {{-- modal delete --}}
            {{-- <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Delete Category</h4>
                        </div>
                        <div class="modal-body text-left">
                            Are you sure <strong> delete </strong> Category ?
                        </div>
                        <div class="modal-footer">
                            <form action="{{'/deleteCategory/'}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- end model --}}
        </div>
    </div>

</div>

@endsection
