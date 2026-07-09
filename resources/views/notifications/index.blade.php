@extends('layouts.appbar')

@section('title', 'Notifications')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Notifications</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('notifications.create') }}" class="btn btn-primary">Add Notification</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Notification List -->
    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Notification List</h3>
                </div>
                <div class="card-body">
                    @if($notifications->isEmpty())
                        <p class="text-center">No notifications available.</p>
                    @else
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Product</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notification)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $notification->email }}</td>
                                        <td>{{ $notification->phone }}</td>
                                        <td>{{ $notification->product ? $notification->product->name : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('notifications.edit', $notification) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-footer">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
