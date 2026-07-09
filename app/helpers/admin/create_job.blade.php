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
                                <form action="{{ route('save-posts') }}" method="POST"
                                                enctype="multipart/form-data">@csrf
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Product Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="exampleInputEmail1" placeholder="Enter product Name">
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Category</label>
                                                        <select class="form-control select2" name="category_id" style="width: 100%;">

                                                          <option value="" selected="selected">Select Category</option>
                                                          @foreach ($categories as $cat)
                                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                          @endforeach
                                                        </select>
                                                      </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Price</label>
                                                        <input type="number" class="form-control" name="price"
                                                            id="exampleInputEmail1">
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <textarea id="summernote" name="description" ></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Image</label>
                                                    <div class="input-group">
                                                      <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="photo">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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
