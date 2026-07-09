@extends('layouts.appbar')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sub Category</h1>
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
                <h3 class="card-title">Sub Categories</h3>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="margin-left: 70%">
                    Add Sub Category
                  </button>
              </div>

              {{-- //Add Modal --}}
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add Sub Category</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('sub_categories.store')}}" method="POST" enctype="multipart/form-data">@csrf
                            <div class="card-body">
                              <div class="form-group">
                                <label for="exampleInputEmail1">Sub Category Name</label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="Enter Category Name" required>
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
            
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                      <th>Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  @if($sub_categories->count() >0)
                  <tbody>
                    @foreach ($sub_categories as $key=>$cat)
                    <tr>
                      <td>{{$key + 1}}</td>
                      <td>{{$cat->name}}</td>
                      <td>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#edit-category{{$cat->id}}">update</a>
                        
                      </td>
                    </tr>


                    {{-- //Edit Modal --}}
              <div class="modal fade" id="delete-category{{$cat->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Delete Category</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    

                    <div class="modal-body">
                      Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <form method="POST" action="{{route('delete_category',$cat->id)}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                      </form>
                    </div>
                    
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
                    {{-- //Edit Modal --}}
              <div class="modal fade" id="edit-category{{$cat->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Sub Category</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('sub_categories.update',$cat->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                              <div class="form-group">
                                <label for="exampleInputEmail1">Sub Category Name</label>
                                <input type="text" class="form-control" name="name" value="{{$cat->name}}" id="exampleInputEmail1" placeholder="Enter Category Name">
                              </div>
                            </div>
                            <!-- /.card-body -->

                            <!-- /.card-body -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Category </label>
                                    <select class="form-control select2" name="category_id" id="type" style="width: 100%;">
                                        <option value="{{$cat->category_id}}" selected="selected">{{category($cat->category_id)->name ?? "N/A"}}</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
            
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
                  <span>No Sub Category Found</span>
                  @endif
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{ $sub_categories->links('pagination::bootstrap-4') }}
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