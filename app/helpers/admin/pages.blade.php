@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pages</h1>
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
                                <h3 class="card-title">Page List</h3>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-default" style="margin-left: 70%">
                                    Add Page
                                </button>
                            </div>

                            {{-- //Add Modal --}}
                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Page</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('save-page') }}" method="POST"
                                                enctype="multipart/form-data">@csrf


                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Meta Title</label>
                                                        <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') }}"
                                                            id="exampleInputEmail1" placeholder="Enter Meta Title">
                                                           
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Meta Description</label>
                                                        <input type="text" class="form-control" name="meta_description" value="{{ old('meta_description') }}"
                                                            id="exampleInputEmail1" placeholder="Enter Meta Description">
                                                           
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Keyword Title</label>
                                                        <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                                            id="exampleInputEmail1" placeholder="Enter Page Title">
                                                           
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Image alter text</label>
                                                        <input type="text" class="form-control" name="alter_text" value="{{ old('alter_text') }}"
                                                            id="exampleInputEmail1" placeholder="Enter image alter text">
                                                           
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Heading 2 </label>
                                                        <input type="text" class="form-control" name="head_2" value="{{ old('head_2') }}"
                                                            id="exampleInputEmail1" placeholder="Enter heading 2">
                                                           
                                                    </div>
                                                </div>

                                               
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Type </label>
                                                        <select class="form-control select2" name="type" id="type" style="width: 100%;">
                                                            <option value="" selected="selected">Select</option>
                                                            <option value="Post">Post</option>
                                                            <option value="Page">Page</option>
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
                                                <div class="form-group" id="photoUpload" >
                                                    <label for="exampleInputFile">Upload Image (optional, only for Posts)</label>
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
                                    @include('flash_msg')
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Title</th>
                                            <th>Alter text</th>
                                            <th>Type</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if ($pages->count() > 0)
                                        <tbody>
                                            @foreach ($pages as $key => $page)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $page->title }}</td>
                                                    <td>{{ $page->alter_text }}</td>
                                                    <td>{{ $page->type }}</td>
                                                    {{-- <td>{{ strip_tags($page->description) }}</td> --}}
                                                    
                                                    <td>
                                                        <a href="{{post_path($page->id)}}" target="_blank" class="btn btn-primary">Preview</a>
                                                        <a href="{{route('edit_page',$page->id)}}" class="btn btn-primary">update</a>
                                                        <a href="#" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#delete-page{{ $page->id }}">Delete</a>
                                                    </td>
                                                </tr>


                                                {{-- //Edit Modal --}}
              <div class="modal fade" id="delete-page{{$page->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Delete</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('delete-page',$page->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <div class="card-body">
                              <p>Are you sure you want to delete this page</p>
                            </div>
                            <!-- /.card-body -->
            
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Delete</button>
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
                                {{ $pages->links('pagination::bootstrap-4') }}
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
