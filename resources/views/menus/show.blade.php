@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="page-title">Menu Details</h1>
                <p class="text-muted">Details of the selected menu</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label><strong>Name:</strong></label>
                            <p>{{ $menu->name }}</p>
                        </div>
                        <div class="form-group">
                            <label><strong>URL:</strong></label>
                            <p>{{ $menu->url }}</p>
                        </div>

                        <a href="{{ route('menus.index') }}" class="btn btn-secondary shadow-sm">Back to List</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
