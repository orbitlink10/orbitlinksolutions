{{-- resources/views/sliders/index.blade.php --}}
@extends('layouts.appbar')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Card -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-images text-primary me-2"></i> Sliders
                    </h5>
                    <a href="{{ route('sliders.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add Slider
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="slidersTable" class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:7%">#</th>
                                    <th>H1 Title</th>
                                    <th>H2 Title</th>
                                    <th>H4 Title</th>
                                    <th style="width:15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                    <tr>
                                        <td class="text-center">{{ $slider->id }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($slider->h1_title, 40) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($slider->h2_title, 40) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($slider->h4_title, 40) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('sliders.edit', $slider) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('sliders.destroy', $slider) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Delete this slider?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- /table-responsive -->
                </div><!-- /card-body -->
            </div><!-- /card -->

        </div>
    </div>
</div>



    {{-- Bootstrap 5.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-M7Tzo6wdb5aQ0+DKubq8Jku9yzx0LzN6Up9EPaqI6k3Eph+yzx7c4OKefUqDLaSz"
          crossorigin="anonymous">

    {{-- Bootstrap Icons 1.12 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.0/font/bootstrap-icons.css"
          rel="stylesheet">

    {{-- DataTables + Bootstrap 5 skin --}}
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"
          rel="stylesheet">

    {{-- Bootstrap bundle (includes Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pUZUSp6jNT9cSkpRGyur35HpWq7Ewh9WuY/YEyt6TXcP7WJ1MIUcQFUsEU31D/8S"
            crossorigin="anonymous"></script>

    {{-- jQuery (required by DataTables) --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        $('#slidersTable').DataTable({
            order      : [[0, 'desc']],
            pageLength : 10,
            lengthMenu : [5, 10, 25, 50],
            columnDefs : [
                { targets: [0, 4], className: 'text-center' },
                { targets: 4,      orderable: false, searchable: false }
            ]
        });
    });
    </script>
@endsection




