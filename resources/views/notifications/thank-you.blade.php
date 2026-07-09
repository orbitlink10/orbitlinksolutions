@extends('theme.lucare.layouts.main')

@section('title', 'Thank You!')

@section('main')
<section class="py-5" id="thank-you">
    <div class="container text-center">
        <h1 class="display-4 text-success">Thank You!</h1>
        <p class="lead mt-3">
            Your request has been successfully received.
        </p>
        <p>
            We will process your request and notify you accordingly. If you need further assistance, feel free to contact us.
        </p>
        <p>
            In the meantime, you can explore our <a href="{{ url('/shop') }}" class="text-primary">products</a>, check out our <a href="{{ url('/blog') }}" class="text-primary">blog</a>, or <a href="{{ url('/contacts') }}" class="text-primary">get in touch</a>.
        </p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-4">Return to Home</a>
    </div>
</section>
@endsection
