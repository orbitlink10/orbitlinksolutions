@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Edit Coupon</h1>
            <p class="text-muted mb-0">{{ $coupon->code }}</p>
        </div>
        <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-outline-secondary">Back</a>
    </div>

    @include('admin.coupons._form', ['coupon' => $coupon])
</div>
@endsection
