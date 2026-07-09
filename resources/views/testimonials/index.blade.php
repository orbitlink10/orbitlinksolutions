@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-6">
                        <h1 class="page-title">Testimonials</h1>
                        <p class="text-muted">Manage and view all testimonials provided by users</p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('testimonials.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus"></i> Add Testimonial
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Testimonials List -->
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h3 class="card-title font-weight-bold">Testimonial List</h3>
                            </div>

                            <!-- Testimonial Table -->
                            <div class="card-body p-0">
                                <table class="table table-hover table-bordered table-responsive-sm">
                                    @include('flash_msg')
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Rating</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($testimonials as $key => $testimonial)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $testimonial->name }}</td>
                                                <td>{{ Str::limit($testimonial->description, 50) }}</td>
                                                <td>{{ $testimonial->rating_count }}</td>
                                                <td>
                                                    <a href="{{ route('testimonials.show', $testimonial->id) }}" class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Update
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#delete-testimonial{{ $testimonial->id }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Delete Testimonial Modal -->
                                            <div class="modal fade" id="delete-testimonial{{ $testimonial->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Testimonial</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <p>Are you sure you want to delete this testimonial?</p>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal -->
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No testimonials found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="card-footer bg-white d-flex justify-content-center">
                                {{ $testimonials->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
