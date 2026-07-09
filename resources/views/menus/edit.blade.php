@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Edit Menu</h1>
                <p class="text-muted">Update the details of the menu</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('menus.update', $menu->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control" value="{{ $menu->name }}" required>
                            </div>
                            <div class="form-group">
                                <label>URL:</label>
                                <input type="text" name="url" class="form-control" value="{{ $menu->url }}" required>
                            </div>
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('menus.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
