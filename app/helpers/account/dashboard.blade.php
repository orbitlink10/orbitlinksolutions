@extends('theme.my_account')

@section('account-content')

@include('admin.flash_msg')
    <h3 class="mb-4">Dashboard</h3>
    <p>Welcome back, {{ Auth::user()->name }}!</p>
    <!-- Additional dashboard content can be added here -->
@endsection
