@extends('layouts.appbar')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <div>
                    <h1 class="page-title mb-1">Edit Job</h1>
                    <p class="text-muted mb-0">Update job details and featured images.</p>
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
                            <form action="{{ route('update_category',$post->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="jobTitle">Job Name</label>
                                    <input type="text" class="form-control" name="title" value="{{$post->title}}" id="jobTitle" placeholder="Enter job name">
                                </div>

                                <div class="form-group">
                                    <label>Job Type</label>
                                    <select class="form-control select2" name="job_type" style="width: 100%;">
                                        @if($post->job_type == 1)
                                            <option value="1" selected>Full Time</option>
                                        @elseif ($post->job_type == 2)
                                            <option value="2" selected>Part Time</option>
                                        @elseif ($post->job_type == 3)
                                            <option value="3" selected>Contract</option>
                                        @else
                                            <option value="4" selected>Remote</option>
                                        @endif
                                        <option value="1">Full Time</option>
                                        <option value="2">Part Time</option>
                                        <option value="3">Contract</option>
                                        <option value="4">Remote</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Location</label>
                                    <?php $counties=\App\Models\County::all(); ?>
                                    <select class="form-control select2" name="location" style="width: 100%;">
                                        <option value="{{$post->location}}">{{getCounty($post->location)->name ?? "No County"}}</option>
                                        @foreach ($counties as $count)
                                            <option value="{{$count->id}}">{{$count->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Job Category</label>
                                    <select class="form-control select2" name="category_id" style="width: 100%;">
                                        <?php 
                                            $cat=\App\Models\Category::whereId($post->category_id)->first(); 
                                            $categories=\App\Models\Category::all(); 
                                        ?>
                                        <option value="{{$cat->id ?? "No Category"}}" selected>{{$cat->name ?? "No Category"}}</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="companyName">Company Name</label>
                                    <input type="text" class="form-control" name="company_name" value="{{$post->company_name}}" id="companyName" placeholder="Enter company name">
                                </div>

                                <div class="form-group">
                                    <label for="jobDescription">Job Description</label>
                                    <textarea id="summernote" name="description">{{$post->description}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="jobPhoto">Featured Image</label>
                                    <div class="mb-2">
                                        <img src="/images?path={{$post->photo}}" width="120" height="120" alt="Job image" class="rounded">
                                    </div>
                                    <input type="file" class="form-control" name="photo" id="jobPhoto" value="{{old('photo')}}">
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
