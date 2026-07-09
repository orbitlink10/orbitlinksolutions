@extends('layouts.appbar')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <div>
                    <h1 class="page-title mb-1">Add Job</h1>
                    <p class="text-muted mb-0">Create a new job listing with details and pricing.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Job Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('save-posts') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="jobName">Job Name</label>
                                    <input type="text" class="form-control" name="name" id="jobName" placeholder="Enter job name">
                                </div>

                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control select2" name="category_id" style="width: 100%;">
                                        <option value="" selected>Select Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="jobPrice">Price</label>
                                    <input type="number" class="form-control" name="price" id="jobPrice" placeholder="Enter price">
                                </div>

                                <div class="form-group">
                                    <label for="jobDescription">Job Description</label>
                                    <textarea id="summernote" name="description"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="jobPhoto">Upload Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="jobPhoto" name="photo">
                                        <label class="custom-file-label" for="jobPhoto">Choose file</label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Job</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
