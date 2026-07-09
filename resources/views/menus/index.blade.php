@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-6">
                        <h1 class="page-title">Menus</h1>
                        <p class="text-muted">Manage and view all menus</p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('menus.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus"></i> Add Menu
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Menu List</h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-hover table-bordered">
                
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($menus as $key => $menu)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ $menu->url }}</td>
                                        <td>
                                            <a href="{{ route('menus.edit', $menu) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                            <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No menus found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white">
                        {{ $menus->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
