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
                            <div class="card-header">
                                <h3 class="card-title">Jobs List</h3>
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-default" style="margin-left: 70%">
                                    Add Job
                                </button> --}}
                                <a href="{{ route ('create_job')}}" class="btn btn-primary" style="margin-left: 70%">Add Job</a>
                            </div>

                            {{-- //Add Modal --}}
                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Job</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('save-posts') }}" method="POST"
                                                enctype="multipart/form-data">@csrf
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Job Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="exampleInputEmail1" placeholder="Enter Job Name">
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Jop Type</label>
                                                        <select class="form-control select2" name="job_type" style="width: 100%;">
                                                          <option value="1" selected="selected">Full Time</option>
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

                                                          <option value="" selected="selected">Select Category</option>
                                                          @foreach ($categories as $cat)
                                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                          @endforeach
                                                        </select>
                                                      </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Company Name</label>
                                                        <input type="text" class="form-control" name="company_name"
                                                            id="exampleInputEmail1" placeholder="Enter Company Name">
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
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Title</th>
                                            {{-- <th>Description</th> --}}
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if ($posts->count() > 0)
                                        <tbody>
                                            @foreach ($posts as $key => $post)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $post->title }}</td>
                                                    {{-- <td>{{ strip_tags($post->description) }}</td> --}}
                                                    <td><img width="35" height="50" src="/images?path={{$post->photo}}" alt="Post Image"
                                                        onerror="this.src='{{ asset('assets/images/market5.png') }}'"
                                                    ></td>
                                                    <td>
                                                        <a href="{{route('edit_post',$post->id)}}" class="btn btn-primary">update</a>
                                                        {{-- <a href="#" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#edit-product{{ $post->id }}">update</a> --}}
                                                    </td>
                                                </tr>


                                                {{-- //Edit Modal --}}
                                                <div class="modal fade" id="edit-product{{ $post->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Product</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('save_category') }}" method="POST"
                                                                enctype="multipart/form-data">@csrf
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Product Name</label>
                                                                        <input type="text" class="form-control" name="name"
                                                                            id="exampleInputEmail1" placeholder="Enter Product Name">
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <textarea id="summernote" name="description" ></textarea>
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
                                            @endforeach

                                        </tbody>
                                    @else
                                        <span>No Job Found</span>
                                    @endif
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                {{ $posts->links('pagination::bootstrap-4') }}
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
