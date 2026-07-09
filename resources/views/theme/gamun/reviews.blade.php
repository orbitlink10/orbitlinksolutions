@extends('theme.gamun.layouts.main')

@section('title') 
    Reviews & Testimonials
@endsection

@section('meta_description', 'Read what our clients have to say about our services.')

@section('main')

<section class="py-5 bg-light" id="testimonials">
    <div class="container">
        <h2 class="text-center mb-5">What Our Clients Say</h2>

        <!-- Testimonials List -->
        <div class="row">
            @forelse($testimonials as $testimonial)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-light h-100 rounded-lg p-3">
                        <div class="card-body text-center">
                            <blockquote class="blockquote mb-0">
                                <p class="font-italic">"{{ $testimonial->description }}"</p>
                                <footer class="blockquote-footer mt-3">{{ $testimonial->name }}</footer>
                            </blockquote>
                            @if(isset($testimonial->rating))
                                <p class="text-warning mt-2">
                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                        ⭐
                                    @endfor
                                </p>
                            @else
                                <p class="text-warning mt-2">⭐⭐⭐⭐⭐</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No testimonials available at the moment. Be the first to leave a review!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $testimonials->links() }}
        </div>
    </div>
</section>

@endsection
