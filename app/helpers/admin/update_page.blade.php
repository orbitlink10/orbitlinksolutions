@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Page</h1>
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
                                <form action="{{ route('update-page',$post->id) }}" method="POST" enctype="multipart/form-data">@csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Title</label>
                                            <input type="text" class="form-control" name="meta_title" value="{{$post->meta_title}}"
                                                id="exampleInputEmail1" placeholder="Enter Meta Title">
                                               
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Description</label>
                                            <input type="text" class="form-control" name="meta_description" value="{{$post->meta_description}}"
                                                id="exampleInputEmail1" placeholder="Enter Meta Description">
                                               
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Page Title</label>
                                            <input type="text" class="form-control" name="title" value="{{$post->title}}"
                                                id="exampleInputEmail1" placeholder="Enter Page Title">
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Image alter text</label>
                                            <input type="text" class="form-control" name="alter_text" value="{{$post->alter_text}}"
                                                id="exampleInputEmail1" placeholder="Enter image alter text">
                                               
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Heading 2 </label>
                                            <input type="text" class="form-control" name="head_2" value="{{$post->head_2}}"
                                                id="exampleInputEmail1" placeholder="Enter heading 2">
                                               
                                        </div>
                                    </div>



                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Type </label>
                                            <select class="form-control select2" name="type" style="width: 100%;">
                                                <option value="{{$post->type}}" selected="selected">{{$post->type ?? "Not Selected"}}</option>
                                                <option value="Post">Post</option>
                                                <option value="Page">Page</option>
                                                <option value="gallery">Gallery</option>
                                                <option value="home">home Blog</option>
                                            </select>
                                          </div>
                                    </div>


                                    <div class="card-body">
                                        <textarea id="summernote" name="description" value="{{$post->description}}" >{{$post->description}}</textarea>
                                    </div>
                                    
                                    <!-- /.card-body -->

                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload Image (optional, only for Posts)</label>
                                        <div class="input-group">
                                          <div class="custom-file">
                                            <img src="/images?path={{$post->photo}}" width="100" height="100"> <br><br>
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
