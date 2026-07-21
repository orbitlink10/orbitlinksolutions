@extends('layouts.appbar')

@section('content')
<div class="content-wrapper product-display-page">
    @include('flash_msg')

    <section class="content-header">
        <div class="container-fluid">
            <div class="product-display-header">
                <div>
                    <span class="product-display-kicker">Homepage Setup</span>
                    <h1 class="product-display-title">Product Display</h1>
                    <p class="product-display-subtitle">Choose the products or categories shown on the homepage.</p>
                </div>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm" target="_blank" rel="noopener">
                    <i class="fas fa-external-link-alt"></i> View Homepage
                </a>
            </div>
            <ol class="breadcrumb float-sm-right product-display-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Product Display</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('admin.partials.homepage_product_display_form')
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .product-display-page {
        background: #f4f7fb;
        min-height: 100vh;
        padding-bottom: 32px;
    }

    .product-display-page .content-header {
        padding: 32px 32px 18px;
    }

    .product-display-page .content {
        padding: 0 32px 32px;
    }

    .product-display-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }

    .product-display-kicker {
        display: inline-flex;
        margin-bottom: 8px;
        color: #2563eb;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .product-display-title {
        margin: 0 0 6px;
        color: #0f172a;
        font-size: 2rem;
        font-weight: 700;
    }

    .product-display-subtitle {
        margin: 0;
        color: #64748b;
        font-size: 0.95rem;
    }

    .product-display-breadcrumb {
        margin-top: 12px;
    }

    .dashboard-panel {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .dashboard-panel-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .dashboard-panel-title {
        margin: 0;
        color: #0f172a;
        font-size: 1.15rem;
        font-weight: 700;
    }

    .dashboard-panel-meta {
        display: block;
        margin-top: 4px;
        color: #64748b;
        font-size: 0.86rem;
    }

    .homepage-products-panel form {
        margin: 0;
    }

    .homepage-products-body {
        padding: 18px 20px 20px;
    }

    .homepage-products-help {
        margin: 0 0 14px;
        color: #64748b;
        font-size: 0.9rem;
    }

    .homepage-product-picker {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        margin-bottom: 18px;
        overflow: hidden;
    }

    .homepage-product-picker-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .homepage-product-picker-header label {
        margin: 0;
        font-weight: 600;
        color: #0f172a;
    }

    .homepage-product-search {
        max-width: 280px;
        border-radius: 999px;
    }

    .homepage-product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 10px;
        max-height: 420px;
        overflow: auto;
        padding: 14px;
    }

    .homepage-product-option,
    .homepage-category-option {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin: 0;
        padding: 12px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        color: #0f172a;
        cursor: pointer;
    }

    .homepage-product-option {
        min-height: 76px;
    }

    .homepage-category-option {
        min-height: 68px;
    }

    .homepage-product-option input,
    .homepage-category-option input {
        margin-top: 4px;
        flex-shrink: 0;
    }

    .homepage-product-copy,
    .homepage-category-copy {
        display: grid;
        gap: 3px;
        line-height: 1.25;
    }

    .homepage-product-copy strong {
        font-size: 0.9rem;
        font-weight: 600;
    }

    .homepage-category-copy strong {
        font-size: 0.92rem;
        font-weight: 600;
    }

    .homepage-product-copy small,
    .homepage-category-copy small,
    .homepage-category-empty {
        color: #64748b;
        font-size: 0.82rem;
    }

    .homepage-product-option:has(input:checked) {
        border-color: #86efac;
        background: #f0fdf4;
    }

    .homepage-fallback-heading {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 12px;
        margin: 4px 0 10px;
        color: #0f172a;
    }

    .homepage-fallback-heading span {
        color: #64748b;
        font-size: 0.82rem;
    }

    .homepage-category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 10px;
    }

    .homepage-category-option:has(input:checked) {
        border-color: #93c5fd;
        background: #eff6ff;
    }

    @media (max-width: 768px) {
        .product-display-page .content-header,
        .product-display-page .content {
            padding-left: 16px;
            padding-right: 16px;
        }

        .product-display-header,
        .homepage-product-picker-header,
        .homepage-fallback-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .homepage-product-search {
            max-width: 100%;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var search = document.getElementById('homepage-product-search');
        var grid = document.getElementById('homepage-product-grid');

        if (!search || !grid) {
            return;
        }

        search.addEventListener('input', function () {
            var query = search.value.trim().toLowerCase();
            var options = grid.querySelectorAll('.homepage-product-option');

            options.forEach(function (option) {
                var text = option.getAttribute('data-search') || '';
                option.style.display = text.indexOf(query) === -1 ? 'none' : '';
            });
        });
    });
</script>
@endsection
