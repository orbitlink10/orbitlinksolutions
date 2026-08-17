@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Create Football Match</h1>
            <p class="text-muted mb-0">Post a match and define the winner reward coupon.</p>
        </div>
        <a href="{{ route('admin.football-matches.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    @include('admin.football._form', ['match' => $match])
</div>
@endsection
