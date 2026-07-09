@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product</h1>
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
                            <div class="modal-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
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
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Quantity</label>
                                                        <input type="number" class="form-control" name="quantity"
                                                            value="{{ old('quantity') }}" id="exampleInputEmail1"
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
                                                        <select class="form-control select2" name="sub_category_id" id="type" style="width: 100%;">
                                                            <option value="" selected="selected">Select sub Category</option>
                                                            @foreach($sub_categories as $cat)
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
                        <!-- /.card -->

                    </div>

                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
