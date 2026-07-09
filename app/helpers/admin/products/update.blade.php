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
                                <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $product->name }}" id="exampleInputEmail1"
                                                placeholder="Enter Product Name">

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Price</label>
                                            <input type="number" class="form-control" name="price"
                                                value="{{ $product->price }}" id="exampleInputEmail1"
                                                >

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Quantity</label>
                                            <input type="number" class="form-control" name="quantity"
                                                value="{{ $product->quantity }}" id="exampleInputEmail1"
                                                >

                                        </div>
                                    </div>

                                     <!-- /.card-body -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Category </label>
                                            <select class="form-control select2" name="category_id" id="type" style="width: 100%;">
                                                <option value="{{$product->category_id}}" selected="selected">{{category($product->category_id)->name ?? "N/A"}}</option>
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
                                                <option value="{{$product->sub_category_id}}" selected="selected">{{sub_category($product->sub_category_id)->name ?? "N/A"}}</option>
                                                @foreach($sub_categories as $cat)
                                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="card-body">
                                        <textarea id="summernote" name="description" value="{{$product->description}}" >{{$product->description}}</textarea>
                                    </div>
                                    
                                    <!-- /.card-body -->

                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload Image (optional, only for products)</label>
                                        <div class="input-group">
                                          <div class="custom-file">
                                            <img src="/images?path={{$product->photo}}" width="100" height="100"> <br><br>
                                            <input type="file" class="form-control" name="photo" id="photo" value="{{old('photo')}}">
                                            {{-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> --}}
                                            
                                          </div>
                                          
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        
                                        <button type="submit" class="btn btn-primary">update</button>
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
