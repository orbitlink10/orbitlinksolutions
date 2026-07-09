@extends('layouts.appbar')
@section('content')
<div class="content-wrapper p-4">
    <h3 class="mb-4">My Wishlist</h3>
    @if($wishlistItems->isEmpty())
        <p>Your wishlist is empty.</p>
    @else
        <div class="row g-3">
            @foreach($wishlistItems as $item)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $item->product->image_url }}" class="card-img-top" alt="{{ $item->product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->product->name }}</h5>
                            <p class="card-text">Price: KSh {{ number_format($item->product->price, 2) }}</p>
                            <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
