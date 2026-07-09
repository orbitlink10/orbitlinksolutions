@extends('theme.my_account')

@section('account-content')
    <h3 class="mb-4">Addresses</h3>
    @if(count($addresses) > 0)
        <ul class="list-group">
            @foreach($addresses as $address)
                <li class="list-group-item">
                    <h5>{{ $address->label }}</h5>
                    <p>{{ $address->address }}</p>
                    <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                    <p>ZIP: {{ $address->zip }}</p>
                    <a href="{{ route('address.edit', $address->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('address.delete', $address->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No addresses found.</p>
    @endif
@endsection
