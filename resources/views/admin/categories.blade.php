@extends('layouts.appbar')

@section('content')
<div class="content-wrapper categories-page">
    <section class="content-header">
      <div class="container-fluid">
        <div class="categories-header d-flex flex-wrap align-items-center justify-content-between mb-3">
          <div>
            <h1 class="page-title mb-1">Categories</h1>
            <p class="text-muted mb-0">Manage product categories and featured images.</p>
          </div>
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
            <i class="fas fa-plus"></i> Add Category
          </button>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card border-0 shadow-sm category-card">
              <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                  <h3 class="card-title mb-0">Category List</h3>
                  <div class="text-muted small">Total: {{ $categories->total() }}</div>
                </div>
              </div>

              {{-- //Add Modal --}}
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add Category</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('save_category')}}" method="POST" enctype="multipart/form-data">@csrf
                            <div class="card-body">
                              <div class="form-group">
                                <label for="categoryName">Category Name</label>
                                <input type="text" class="form-control" name="name" id="categoryName" placeholder="Enter category name">
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Category</button>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0 category-table">
                    <thead>
                      <tr>
                        <th style="width: 80px">#</th>
                        <th style="width: 120px">Image</th>
                        <th>Name</th>
                        <th style="width: 180px">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($categories as $key=>$cat)
                      <tr>
                        <td>{{ $categories->firstItem() + $key }}</td>
                        <td>
                          @if($cat->photo)
                            <img src="{{ $cat->photo }}" alt="{{ $cat->name }}" class="category-thumb">
                          @else
                            <div class="category-thumb placeholder">No photo</div>
                          @endif
                        </td>
                        <td>
                          <div class="font-weight-bold">{{ $cat->name }}</div>
                        </td>
                        <td>
                          <div class="category-actions">
                            <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#edit-category{{$cat->id}}">Edit</a>
                            <a href="#" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#delete-category{{$cat->id}}">Delete</a>
                          </div>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="4" class="text-center text-muted py-4">No categories found.</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer clearfix">
                {{ $categories->links('pagination::bootstrap-4') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  @foreach ($categories as $cat)
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
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
          <form method="POST" action="{{route('delete_category',$cat->id)}}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="edit-category{{$cat->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('update_categorys',$cat->id)}}" method="POST" enctype="multipart/form-data">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="categoryName{{$cat->id}}">Category Name</label>
                    <input type="text" class="form-control" name="name" value="{{$cat->name}}" id="categoryName{{$cat->id}}" placeholder="Enter category name">
                  </div>
                </div>
                <div class="form-group">
                    <label for="productImage{{$cat->id}}">Featured Image</label>
                    <div class="mb-2">
                        @if($cat->photo)
                            <img src="/images?path={{ $cat->photo }}" alt="Current Category Image" width="100" height="100">
                        @else
                            <div class="category-thumb placeholder" style="width: 100px; height: 100px;">No photo</div>
                        @endif
                    </div>
                    <input type="file" class="form-control" id="productImage{{$cat->id}}" name="photo">
                    @error('photo')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <style>
    .categories-page {
      background: #f4f6fb;
      padding-bottom: 24px;
    }

    .categories-header {
      gap: 16px;
    }

    .categories-page .page-title {
      font-size: 1.9rem;
      font-weight: 600;
      color: #0f172a;
    }

    .categories-page .category-card {
      border-radius: 18px;
      box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
    }

    .categories-page .category-card .card-header {
      padding: 18px 20px 0;
    }

    .categories-page .category-card .card-body {
      padding: 0 20px 18px;
    }

    .category-table thead th {
      background: #f8fafc;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      font-size: 0.72rem;
      border-top: 1px solid #e2e8f0;
      border-bottom: 1px solid #e2e8f0;
    }

    .category-table td {
      border-top: 1px solid #e2e8f0;
      vertical-align: middle;
    }

    .category-thumb {
      width: 72px;
      height: 72px;
      object-fit: cover;
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      background: #ffffff;
      box-shadow: 0 10px 18px rgba(15, 23, 42, 0.08);
    }

    .category-thumb.placeholder {
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      color: #94a3b8;
      background: #f1f5f9;
    }

    .category-actions {
      display: inline-flex;
      gap: 8px;
    }

    .category-actions .btn {
      border-radius: 999px;
      font-weight: 600;
      padding: 0.25rem 0.75rem;
    }
  </style>
@endsection
