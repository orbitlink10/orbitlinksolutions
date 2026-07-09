@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jobs</h1>
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
                                <form action="{{ route('update_category',$post->id) }}" method="POST" enctype="multipart/form-data">@csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product Name</label>
                                            <input type="text" class="form-control" name="title" value="{{$post->title}}"
                                                id="exampleInputEmail1" placeholder="Enter Product Name">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Jop Type</label>
                                            <select class="form-control select2" name="job_type" style="width: 100%;">
                                                @if($post->job_type == 1)
                                                <option value="1" selected="selected">Full Time</option>
                                                @elseif ($post->job_type == 2)
                                                <option value="2" selected="selected">Part Time</option>
                                                @elseif ($post->job_type == 3)
                                                <option value="3" selected="selected">Contract</option>
                                                @else
                                                <option value="4" selected="selected">Remote</option>
                                                @endif
                                              
                                              <option value="1">Full Time</option>
                                              <option value="2">Part Time</option>
                                              <option value="3">Contract</option>
                                              <option value="4">Remote</option>
                                            </select>
                                          </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Location</label>
                                            <?php $counties=\App\Models\County::all(); ?>
                                            <select class="form-control select2" name="location" style="width: 100%;">
                                                <option value="{{$post->location}}">{{getCounty($post->location)->name ?? "No County"}}</option>
                                                @foreach ($counties as $count)
                                                <option value="{{$count->id}}">{{$count->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Job Category</label>
                                            <select class="form-control select2" name="category_id" style="width: 100%;">
                                            <?php 
                                                $cat=\App\Models\Category::whereId($post->category_id)->first(); 
                                                $categories=\App\Models\Category::all(); 
                                            ?>
                                              <option value="{{$cat->id ?? "No Category"}}" selected="selected">{{$cat->name ?? "No Category"}}</option>
                                              @foreach ($categories as $cat)
                                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Company Name</label>
                                            <input type="text" class="form-control" name="company_name" value="{{$post->company_name}}"
                                                id="exampleInputEmail1" placeholder="Enter Company Name">
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <textarea id="summernote" name="description" value="{{$post->description}}" >{{$post->description}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload Image</label>
                                        <div class="input-group">
                                          <div class="custom-file">
                                            <img src="/images?path={{$post->photo}}" width="100" height="100"> <br><br>
                                            <input type="file" class="form-control" name="photo" id="photo" value="{{old('photo')}}">
                                            {{-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> --}}
                                            
                                          </div>
                                          
                                        </div>
                                    </div>

                                    <!-- /.card-body -->

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
