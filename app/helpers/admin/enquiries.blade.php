@extends('layouts.appbar')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Enquiries</h1>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Enquiries List</h3>
                                
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    @if ($enquiries->count() > 0)
                                        <tbody>
                                            @foreach ($enquiries as $key => $page)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $page->name }}</td>
                                                    <td>{{ $page->email }}</td>
                                                    <td>{{ $page->phone }}</td>
                                                    <td>{{ $page->subject }}</td>
                                                    <td>{{ strip_tags($page->message) }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    @else
                                        <span>No Enquiries Found</span>
                                    @endif
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                {{ $enquiries->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        <!-- /.card -->

                    </div>

                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
