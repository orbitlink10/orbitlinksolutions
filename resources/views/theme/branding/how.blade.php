@extends('theme.branding.layouts.main')

@section('title') 
    How to Place an Online Order 
@endsection

@section('main')


<!-- Services Section -->
<section class="bg-light py-5" id="medias">
    <div class="container">
        <h2 class="text-center mb-5">Our Recent Installations</h2>
<?php 
$medias = \App\Models\Media::all();
?>
        <!-- Carousel -->
        <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($medias->chunk(4) as $key => $mediaChunk)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <div class="row">
                            @foreach($mediaChunk as $media)
                                <div class="col-md-3">
                                    <div class="media-card" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('{{ $media->file_path }}')">
                                        <img class="d-block w-100" src="{{ $media->file_path }}" alt="Installation">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Full View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Full View" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- CSS for hover and enlarge effect -->
<style>
    .media-card {
        overflow: hidden;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .media-card img {
        transition: transform 0.3s ease;
        object-fit: cover;
        height: 500px;
    }

    .media-card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .media-card:hover img {
        transform: scale(1.1);
    }
</style>

<!-- JavaScript -->
<script>
    function showImage(imagePath) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imagePath;
    }
</script>




<section class="py-5" id="header" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-md-8 col-lg-6 text-md-start text-center">
                <h1 class="text-dark fw-bold">How to Place an Online Order</h1>
                <p class="lead text-muted">Follow these simple steps to place your order online and enjoy a seamless shopping experience.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-6" id="order-steps">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="text-dark fw-bold">Step-by-Step Guide</h2>
                <p class="text-muted">Here’s a simple breakdown of the steps to place your order quickly and efficiently.</p>
            </div>
        </div>

        <!-- Step 1 -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h3 class="fs-5 text-uppercase text-dark">1. Browse Products</h3>
                <p class="text-muted">Visit the website and explore a wide range of products available for purchase. Use the search bar or navigate through categories to find what you need.</p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h3 class="fs-5 text-uppercase text-dark">2. Add to Cart</h3>
                <p class="text-muted">Once you find a product you like, click on it to view the details. Select any options (like size or color) and click the <strong>Add to Cart</strong> button.</p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h3 class="fs-5 text-uppercase text-dark">3. View Cart</h3>
                <p class="text-muted">After adding products to your cart, click on the cart icon at the top right corner of the page to review your selected items.</p>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h3 class="fs-5 text-uppercase text-dark">4. Proceed to Checkout</h3>
                <p class="text-muted">When you're ready to place your order, click the <strong>Proceed to Checkout</strong> button. You will be prompted to log in or create an account if you haven't already.</p>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h3 class="fs-5 text-uppercase text-dark">5. Enter Shipping Information</h3>
                <p class="text-muted">Fill in your shipping address and choose your preferred shipping method. Make sure all information is accurate to avoid delays.</p>
            </div>
        </div>

        <!-- Step 6 -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h3 class="fs-5 text-uppercase text-dark">6. Choose Payment Method</h3>
                <p class="text-muted">Select your preferred payment method (e.g., credit card, Mpesa, etc.) and enter the required payment details. Ensure that your payment information is secure.</p>
            </div>
        </div>

        <!-- Step 7 -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h3 class="fs-5 text-uppercase text-dark">7. Review and Place Order</h3>
                <p class="text-muted">Review your order summary, including products, shipping details, and total cost. Once everything looks good, click on the <strong>Place Order</strong> button to finalize your purchase.</p>
            </div>
        </div>

        <!-- Step 8 -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h3 class="fs-5 text-uppercase text-dark">8. Receive Confirmation</h3>
                <p class="text-muted">After placing your order, you will receive a confirmation email with your order details. Keep this email for your records.</p>
            </div>
        </div>

        <!-- Step 9 -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h3 class="fs-5 text-uppercase text-dark">9. Track Your Order</h3>
                <p class="text-muted">You can track the status of your order through your account on the website or via the link provided in your confirmation email.</p>
            </div>
        </div>
    </div>
</section>
@endsection
