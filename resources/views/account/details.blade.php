@extends('layouts.appbar')
@section('content')
<div class="content-wrapper p-4">
    <h3 class="mb-4 text-dark">Account Details</h3>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('account.updateDetails') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" placeholder="Enter your name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="Enter your email">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Update Details</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
