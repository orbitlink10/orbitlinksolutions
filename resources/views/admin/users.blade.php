@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-12">
                        <h1 class="page-title text-dark">Manage Users</h1>
                        <p class="text-muted">Manage and oversee all system users efficiently</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold text-primary">List of Users</h3>
                        <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-user-plus"></i> Add New User
                        </button>
                    </div>

                    <!-- Add User Modal -->
                    @include('admin.users.modals.add')

                    <!-- User List (Table Format) -->
                    <div class="card-body">
                        @if ($users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Joined On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ ucfirst($user->user_type) }}</td>
                                                <td>{{ $user->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('login_as', $user->id) }}" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-sign-in-alt"></i> Login As
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#edit-user{{ $user->id }}">
                                                        <i class="fas fa-edit"></i> Update
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Edit User Modal -->
                                            @include('admin.users.modals.edit')
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-users-slash fa-3x"></i><br>No users found.
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-white d-flex justify-content-center">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
