@php
    $selectedHomepageProductCount = count($selectedHomepageProductIds);
    $selectedHomepageCategoryCount = count($selectedHomepageCategoryIds);
    $productDisplayTitle = $productDisplayTitle ?? 'Product Display';
    $productDisplaySubmitLabel = $productDisplaySubmitLabel ?? 'Save Display';
@endphp

<div class="card dashboard-panel homepage-products-panel">
    <form action="{{ route('admin.homepage_product_categories.update') }}" method="POST">
        @csrf
        <div class="dashboard-panel-header homepage-products-header">
            <div>
                <h4 class="dashboard-panel-title">{{ $productDisplayTitle }}</h4>
                <span class="dashboard-panel-meta">
                    @if($selectedHomepageProductCount > 0)
                        {{ $selectedHomepageProductCount }} selected {{ $selectedHomepageProductCount === 1 ? 'product' : 'products' }}
                    @elseif($selectedHomepageCategoryCount > 0)
                        {{ $selectedHomepageCategoryCount }} selected {{ $selectedHomepageCategoryCount === 1 ? 'category' : 'categories' }}
                    @else
                        No selected products
                    @endif
                </span>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-save"></i> {{ $productDisplaySubmitLabel }}
            </button>
        </div>
        <div class="homepage-products-body">
            <p class="homepage-products-help">
                Select the exact products that should appear on the homepage. Selected products override category selections and display grouped by category. If no products are selected, the homepage uses the category fallback below.
            </p>
            <div class="homepage-product-picker">
                <div class="homepage-product-picker-header">
                    <label for="homepage-product-search">Specific homepage products</label>
                    <input
                        type="search"
                        id="homepage-product-search"
                        class="form-control form-control-sm homepage-product-search"
                        placeholder="Search products or categories"
                        autocomplete="off"
                    >
                </div>
                <div class="homepage-product-grid" id="homepage-product-grid">
                    @forelse($homepageProducts as $product)
                        @php
                            $productCategory = $product->category;
                            $searchText = strtolower(trim($product->name . ' ' . ($productCategory->name ?? '')));
                        @endphp
                        <label
                            class="homepage-product-option"
                            for="homepage-product-{{ $product->id }}"
                            data-search="{{ $searchText }}"
                        >
                            <input
                                type="checkbox"
                                name="product_ids[]"
                                id="homepage-product-{{ $product->id }}"
                                value="{{ $product->id }}"
                                {{ in_array((int) $product->id, $selectedHomepageProductIds, true) ? 'checked' : '' }}
                            >
                            <span class="homepage-product-copy">
                                <strong>{{ $product->name }}</strong>
                                <small>
                                    {{ $productCategory->name ?? 'No category' }}
                                    @if($product->has_price)
                                        - {{ price($product) }}
                                    @endif
                                </small>
                            </span>
                        </label>
                    @empty
                        <div class="homepage-category-empty">
                            No products have been created yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="homepage-fallback-heading">
                <strong>Category fallback</strong>
                <span>Used only when no specific products are selected.</span>
            </div>
            <div class="homepage-category-grid">
                @forelse($homepageCategories as $category)
                    <label class="homepage-category-option" for="homepage-category-{{ $category->id }}">
                        <input
                            type="checkbox"
                            name="category_ids[]"
                            id="homepage-category-{{ $category->id }}"
                            value="{{ $category->id }}"
                            {{ in_array((int) $category->id, $selectedHomepageCategoryIds, true) ? 'checked' : '' }}
                        >
                        <span class="homepage-category-copy">
                            <strong>{{ $category->name }}</strong>
                            <small>{{ $category->homepage_products_count }} products</small>
                        </span>
                    </label>
                @empty
                    <div class="homepage-category-empty">
                        No categories have been created yet.
                    </div>
                @endforelse
            </div>
        </div>
    </form>
</div>
