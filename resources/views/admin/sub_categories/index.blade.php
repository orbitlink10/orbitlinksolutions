@extends('layouts.appbar')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
          <div>
            <h1 class="page-title mb-1">Sub Categories</h1>
            <p class="text-muted mb-0">Group products under more specific categories.</p>
          </div>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
              <i class="fas fa-plus"></i> Add Sub Category
          </button>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sub Categories</h3>
              </div>
              <!-- /.card-header -->

              <!-- Add Modal -->
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
                            <div class="form-group">
                                <label for="subCategoryName">Sub Category Name</label>
                                <input type="text" class="form-control" name="name" id="subCategoryName" placeholder="Enter Sub Category Name" required>
                            </div>
                            <div class="form-group">
                                <label for="categorySelect">Category</label>
                                <select class="form-control select2" name="category_id" id="categorySelect" style="width: 100%;" required>
                                    <option value="" selected>Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Sub Category</button>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.modal -->

              <!-- Main Table -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th style="width: 180px">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($sub_categories as $key=>$cat)
                      <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->category->name }}</td>
                        <td>
                          <div class="d-inline-flex">
                            <a href="#" class="btn btn-sm btn-outline-primary mr-2" data-toggle="modal" data-target="#edit-category{{$cat->id}}">Edit</a>
                            <a href="#" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#delete-category{{$cat->id}}">Delete</a>
                          </div>
                        </td>
                      </tr>

                    <!-- Edit Modal -->
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
                              <form action="{{route('sub_categories.update', $cat->id)}}" method="POST" enctype="multipart/form-data">
                                  @csrf
                                  @method('PUT')
                                  <div class="form-group">
                                    <label for="editSubCategoryName{{$cat->id}}">Sub Category Name</label>
                                    <input type="text" class="form-control" name="name" id="editSubCategoryName{{$cat->id}}" value="{{$cat->name}}" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="editCategorySelect{{$cat->id}}">Category</label>
                                      <select class="form-control select2" name="category_id" id="editCategorySelect{{$cat->id}}" style="width: 100%;" required>
                                          <option value="{{$cat->category_id}}" selected>{{category($cat->category_id)->name ?? "N/A"}}</option>
                                          @foreach($categories as $cat)
                                              <option value="{{$cat->id}}">{{$cat->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Update</button>
                                  </div>
                              </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Delete Modal -->
                    <div class="modal fade" id="delete-category{{$cat->id}}">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Delete Sub Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to delete this item?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <form method="POST" action="{{route('delete_category', $cat->id)}}">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                      @empty
                      <tr>
                        <td colspan="4" class="text-center text-muted py-4">No sub categories found.</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Pagination -->
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
