@php
    $productCardColumn = $productCardColumn ?? 'col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12';
    $productCategory = $ad->category ?: category($ad->category_id);
    $productBrand = orbit_product_brand($ad);
    $productModel = orbit_product_model($ad);
    $productFeature = orbit_product_key_feature($ad);
    $stockLabel = product_stock_status_label($ad);
    $installerPrice = installer_price_for_product($ad, 1, Auth::user());
    $hasSale = isset($ad->marked_price) && $ad->has_price && $ad->marked_price > 0 && $ad->marked_price > ($ad->price ?? 0);
    $productUrl = route('product_details', $ad->slug);
    $waLink = orbit_whatsapp_url("Hello Orbitlink Solutions, I am interested in {$ad->name}. Please confirm installer price and stock availability. {$productUrl}");
@endphp

<div class="{{ $productCardColumn }}">
    <div class="product-cart-wrap h-100 installer-product-card">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="{{ $productUrl }}">
                    <img class="default-img" src="{{ product_image_url($ad) }}" alt="{{ $ad->name }}" loading="lazy">
                    <img class="hover-img" src="{{ product_image_url($ad) }}" alt="{{ $ad->name }}" loading="lazy">
                </a>
            </div>
            @if(!empty($ad->best_for_label))
                <span class="best-for-badge">{{ $ad->best_for_label }}</span>
            @elseif(!empty($ad->installer_deal_label))
                <span class="best-for-badge">{{ $ad->installer_deal_label }}</span>
            @endif
        </div>
        <div class="product-content-wrap">
            @if($hasSale)
                <span class="badge-sale">-{{ discount($ad->id) }}%</span>
            @endif
            <div class="product-card-meta">
                @if($productBrand)
                    <span>{{ $productBrand }}</span>
                @endif
                @if($productModel)
                    <span>{{ $productModel }}</span>
                @endif
            </div>
            @if($productCategory)
                <div class="product-category">
                    <a href="{{ route('view_product_category', ['slug' => $productCategory->slug]) }}">{{ $productCategory->name }}</a>
                </div>
            @endif
            <h3><a href="{{ $productUrl }}">{{ \Illuminate\Support\Str::limit($ad->name, 46) }}</a></h3>
            @if($productFeature)
                <div class="product-key-feature">{{ $productFeature }}</div>
            @endif
            <div class="product-stock-line {{ \Illuminate\Support\Str::slug($stockLabel) }}">
                <i class="fas fa-circle"></i> {{ $stockLabel }}
            </div>
            <div class="product-price">
                @if($ad->has_price)
                    @if($installerPrice)
                        <span>{{ get_option('currency_symbol', 'KSh') }} {{ number_format($installerPrice, 2) }}</span>
                        <small class="installer-price-note">Installer price</small>
                        <small class="retail-price-note">Retail: {{ price($ad) }}</small>
                    @else
                        <span>{{ price($ad) }}</span>
                    @endif
                @else
                    <span class="text-muted">Request quote</span>
                @endif
            </div>
            <div class="installer-card-actions">
                <a aria-label="View {{ $ad->name }}" class="action-btn hover-up" href="{{ $productUrl }}"><i class="fas fa-eye"></i></a>
                @if($ad->has_price && $stockLabel !== 'Out of Stock')
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $ad->id }}">
                        <button type="submit" class="action-btn hover-up" aria-label="Add {{ $ad->name }} to cart">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </form>
                @endif
                @if($waLink)
                    <a aria-label="Ask about {{ $ad->name }} on WhatsApp" class="action-btn hover-up whatsapp-action" href="{{ $waLink }}" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>
