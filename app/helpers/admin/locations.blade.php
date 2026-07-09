@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Locations</h1>
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
                                <h3 class="card-title">Location List</h3>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-default" style="margin-left: 70%">
                                    Add Location
                                </button>
                            </div>

                            {{-- //Add Modal --}}
                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Location</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('save-location') }}" method="POST"
                                                enctype="multipart/form-data">@csrf
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Job Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="exampleInputEmail1" placeholder="Enter Location name">
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
                                            <th>Location</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if ($pages->count() > 0)
                                        <tbody>
                                            @foreach ($pages as $key => $page)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $page->name }}</td>
                                                    
                                                    <td>
                                                        
                                                        <a href="#" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#edit-location{{ $page->id }}">update</a>
                                                    </td>
                                                </tr>

                                                 {{-- //Edit Modal --}}
              <div class="modal fade" id="edit-location{{$page->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Location</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('update_location',$page->id)}}" method="POST" enctype="multipart/form-data">@csrf
                            <div class="card-body">
                              <div class="form-group">
                                <label for="exampleInputEmail1">Location Name</label>
                                <input type="text" class="form-control" name="name" value="{{$page->name}}" id="exampleInputEmail1" placeholder="Enter Category Name">
                              </div>
                            </div>
                            <!-- /.card-body -->
            
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">update</button>
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
                                        <span>No Location Found</span>
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
