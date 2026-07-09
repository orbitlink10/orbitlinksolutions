@extends('theme.my_account')

@section('account-content')
    <h3 class="mb-4">Account Details</h3>
    <form action="{{ route('account.updateDetails') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Details</button>
    </form>
@endsection
