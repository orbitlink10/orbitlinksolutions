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
                                   
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Title</label>
                                            <input type="text" class="form-control" name="meta_title" value="{{$post->meta_title}}"
                                                id="exampleInputEmail1" placeholder="Enter Meta Title">
                                               
                                        </div>
                                
                                  
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Description</label>
                                            <input type="text" class="form-control" name="meta_description" value="{{$post->meta_description}}"
                                                id="exampleInputEmail1" placeholder="Enter Meta Description">
                                               
                                        </div>
                                 
                                    
                                
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Page Title</label>
                                            <input type="text" class="form-control" name="title" value="{{$post->title}}"
                                                id="exampleInputEmail1" placeholder="Enter Page Title">
                                        </div>
                                   
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Image alter text</label>
                                            <input type="text" class="form-control" name="alter_text" value="{{$post->alter_text}}"
                                                id="exampleInputEmail1" placeholder="Enter image alter text">
                                               
                                        </div>
                                  
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Heading 2 </label>
                                            <input type="text" class="form-control" name="head_2" value="{{$post->head_2}}"
                                                id="exampleInputEmail1" placeholder="Enter heading 2">
                                               
                                        </div>
                                 
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
                                


                               

                                <!-- Row for Page Description -->
                                 <div class="form-group">
                                    <label>Page Description:</label>
                                 
                                        <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
                                        <textarea id="textarea" name="description">{{$post->description}}</textarea>

                                        <script type="text/javascript">
                                            tinymce.init({
                                                selector: "textarea#textarea",
                                                plugins: "image advcode link lists media table code wordcount fullscreen",
                                                toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media | code fullscreen",
                                                menubar: "file edit view insert format tools table help",
                                                height: 600,
                                                image_title: true,
                                                automatic_uploads: true,
                                                promotion: false,
                                                branding: false,
                                                file_picker_types: 'image',
                                                file_picker_callback: function (cb, value, meta) {
                                                    let input = document.createElement('input');
                                                    input.setAttribute('type', 'file');
                                                    input.setAttribute('accept', 'image/*');
                                                    input.onchange = function () {
                                                        let file = this.files[0];
                                                        let reader = new FileReader();
                                                        reader.onload = function () {
                                                            let id = 'blobid' + (new Date()).getTime();
                                                            let blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                                            let base64 = reader.result.split(',')[1];
                                                            let blobInfo = blobCache.create(id, file, base64);
                                                            blobCache.add(blobInfo);
                                                            cb(blobInfo.blobUri(), { title: file.name });
                                                        };
                                                        reader.readAsDataURL(file);
                                                    };
                                                    input.click();
                                                },
                                                setup: function (editor) {
                                                    editor.on('ExecCommand', function (e) {
                                                        if (e.command === 'mceUpdateImage') {
                                                            const img = editor.selection.getNode();
                                                            img.setAttribute('data-src', img.src);
                                                        }
                                                    });
                                                },
                                            });
                                        </script>

                                        <style>
                                            textarea#textarea {
                                                border-radius: 8px;
                                                border: 1px solid #ccc;
                                                padding: 10px;
                                                font-size: 14px;
                                                width: 100%;
                                                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
                                            }
                                        </style>
                                 
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



                                <div class="card">
        <div class="card-header">
            <h1>Upload Media for page: {{ $post->title }}</h1>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pages.media') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="page_id" value="{{ $post->id }}">

                <div class="form-group mb-3">
                    <label for="files">Choose Files</label>
                    <input type="file" name="files[]" id="files" class="form-control" multiple required>
                    <small class="form-text text-muted">You can select multiple files to upload.</small>
                </div>

                <div class="form-group mb-3">
                    <label for="captions">Captions (optional)</label>
                    <textarea name="captions" id="captions" rows="3" class="form-control" placeholder="Provide captions separated by commas (e.g., Caption1, Caption2)"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Upload</button>
                
            </form>
        </div>
    </div>

    @include('admin.pages.media')

                    </div>

                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
