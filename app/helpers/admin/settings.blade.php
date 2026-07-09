@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Setting</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Setting</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">General Setting</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->

                                <div class="card-body">
                                    <form action="{{ route('save_settings')}}" method="POST"> @csrf
 <div class="form-group">
                                            <label for="exampleInputEmail1">Site Name</label>
                                            <input type="text" class="form-control" name="site_name" value="{{ $options->where('option_key', 'site_name')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                                placeholder="Website name">
                                                
                                        </div>
                                        
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Home Page Content</label>
                                        {{-- <input type="text" class="form-control" name="home_page_description" id="exampleInputEmail1"
                                            placeholder="Enter the Home Page Content"> --}}
                                            <div class="card-body">
                                                <textarea id="summernote" name="home_page_description">
                                                    {{ $options->where('option_key', 'home_page_description')->first()->option_value ?? " "}}
                                                </textarea>
                                            </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label for="exampleInputEmail1">Trending jobs Content</label>
                                        <input type="text" class="form-control" name="trending_jobs" value="{{ $options->where('option_key', 'trending_jobs')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                            placeholder="Enter the Home Page Content">
                                            
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label for="exampleInputEmail1">Kenya No.1 Jobs Site</label>
                                        <input type="text" class="form-control" name="kenya_jobs" value="{{ $options->where('option_key', 'kenya_jobs')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                            placeholder="Enter the Home Page Content">
                                            
                                    </div>
                                    
                                
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Save Setting</button>
                                    </div>
                                </form>
                                </div>
                                <!-- /.card-body -->


                            </div>
                            <!-- /.card -->


                            <!-- Input addon -->
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Contact Information</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('save_settings')}}" method="POST"> @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Conatct Description Content</label>
                                            <input type="text" class="form-control" name="contact_description" value="{{ $options->where('option_key', 'contact_description')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                                placeholder="Enter Content">
                                                
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Contact title</label>
                                            <input type="text" class="form-control" name="contact_phone" value="{{ $options->where('option_key', 'conatct_title')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                                placeholder="Enter the Home Page Content">
                                                
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Contact Phone</label>
                                            <input type="text" class="form-control" name="contact_phone" value="{{ $options->where('option_key', 'contact_phone')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                                placeholder="Enter the Home Page Content">
                                                
                                        </div>


                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" name="contact_email" value="{{ $options->where('option_key', 'contact_email')->first()->option_value ?? " "}}" placeholder="Email">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Twiter</label>
                                            <input type="text" class="form-control" name="twiter" value="{{ $options->where('option_key', 'twiter')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                                placeholder="Enter the Home Page Content">
                                                
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Facebook</label>
                                            <input type="text" class="form-control" name="facebook" value="{{ $options->where('option_key', 'facebook')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                                placeholder="Enter the Home Page Content">
                                                
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Linkedin</label>
                                            <input type="text" class="form-control" name="linkedin" value="{{ $options->where('option_key', 'linkedin')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                                placeholder="Enter the Home Page Content">
                                                
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Instagram</label>
                                            <input type="text" class="form-control" name="instagram" value="{{ $options->where('option_key', 'instagram')->first()->option_value ?? " "}}" id="exampleInputEmail1"
                                                placeholder="Enter the Home Page Content">
                                                
                                        </div>

                                       
                                    
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Save Setting</button>
                                        </div>
                                    </form>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <!-- Horizontal Form -->
                            <div class="card card-info" style="display: none;">
                                <div class="card-header">
                                    <h3 class="card-title">Horizontal Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputEmail3"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="inputPassword3"
                                                placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                                <label class="form-check-label" for="exampleCheck2">Remember me</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
