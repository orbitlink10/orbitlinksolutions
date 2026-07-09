@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Product List</h3>
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-default" style="margin-left: 70%">
                                    Add Product
                                </button> --}}
                                <a href="{{route('products.create')}}" class="btn btn-primary"
                                     style="margin-left: 70%">
                                    Add Product
                                </a>
                            </div>

                            {{-- //Add Modal --}}
                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Product</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('products.store') }}" method="POST"
                                                enctype="multipart/form-data">@csrf


                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Product name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ old('name') }}" id="exampleInputEmail1"
                                                            placeholder="Enter Product Name">

                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Price</label>
                                                        <input type="number" class="form-control" name="price"
                                                            value="{{ old('price') }}" id="exampleInputEmail1"
                                                            >

                                                    </div>
                                                </div>

                                                 <!-- /.card-body -->
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Category </label>
                                                        <select class="form-control select2" name="category_id" id="type" style="width: 100%;">
                                                            <option value="" selected="selected">Select Category</option>
                                                            @foreach($categories as $cat)
                                                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                 <!-- /.card-body -->
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Sub Category </label>
                                                        <select class="form-control select2" name="category_id" id="type" style="width: 100%;">
                                                            <option value="" selected="selected">Select sub Category</option>
                                                            @foreach($categories as $cat)
                                                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                               

                                                <div class="card-body">
                                                    <textarea id="summernote" name="description"></textarea>
                                                </div>

                                                {{-- <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Summernote Editor</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div id="summernote">
                                                                    <p>Hello Summernote</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 --}}
                                                <div class="form-group" id="photoUpload">
                                                    <label for="exampleInputFile">Upload Image (optional, only for
                                                        Posts)</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="exampleInputFile" name="photo">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>



                                                <!-- /.card-body -->

                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    @include('flash_msg')
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Price</th>
                                            <th>Category</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if ($products->count() > 0)
                                        <tbody>
                                            @foreach ($products as $key => $page)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $page->name }}</td>
                                                    <td>{{ $page->slug }}</td>
                                                    <td>{{ $page->price }}</td>
                                                    <td>{{ category($page->category_id)->name }}</td>

                                                    <td>
                                                        {{-- <a href="{{ post_path($page->id) }}" target="_blank"
                                                            class="btn btn-primary">Preview</a> --}}
                                                        <a href="{{ route('products.edit', $page->id) }}"
                                                            class="btn btn-primary">update</a>
                                                        <a href="#" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#delete-page{{ $page->id }}">Delete</a>
                                                    </td>
                                                </tr>


                                                {{-- //Edit Modal --}}
                                                <div class="modal fade" id="delete-page{{ $page->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Delete</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('products.destroy', $page->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="card-body">
                                                                        <p>Are you sure you want to delete this Product</p>
                                                                    </div>
                                                                    <!-- /.card-body -->

                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
                                            @endforeach

                                        </tbody>
                                    @else
                                        <span>No Product Found</span>
                                    @endif
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                {{ $products->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        <!-- /.card -->

                    </div>

                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
