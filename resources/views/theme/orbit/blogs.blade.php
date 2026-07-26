@extends('theme.orbit.layouts.main')

@php
    $siteName = get_option('site_name', 'Orbitlink Solutions');
    $canonicalUrl = route('blogs');
    $metaDescription = 'Read Orbitlink Solutions guides and updates on Starlink, networking, WiFi, CCTV, and connectivity equipment in Kenya.';
    $firstItem = method_exists($posts, 'firstItem') ? ($posts->firstItem() ?? 1) : 1;
    $itemListElements = [];

    foreach ($posts as $index => $post) {
        $postDescription = trim(strip_tags((string) ($post->meta_description ?: $post->description)));

        $itemListElements[] = [
            '@type' => 'ListItem',
            'position' => $firstItem + $index,
            'url' => route('blog_single', $post->slug),
            'name' => $post->title,
            'description' => \Illuminate\Support\Str::limit($postDescription, 155, ''),
        ];
    }

    $itemListSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => 'Orbitlink Solutions Resources',
        'url' => $canonicalUrl,
        'itemListElement' => $itemListElements,
    ];
@endphp

@section('title', 'Networking Resources')
@section('meta_description', $metaDescription)
@section('canonical', $canonicalUrl)
@section('og_title', 'Networking Resources | ' . $siteName)
@section('og_description', $metaDescription)
@section('og_url', $canonicalUrl)
@section('twitter_title', 'Networking Resources | ' . $siteName)
@section('twitter_description', $metaDescription)

@push('meta')
    @if(method_exists($posts, 'previousPageUrl') && $posts->previousPageUrl())
        <link rel="prev" href="{{ $posts->previousPageUrl() }}">
    @endif
    @if(method_exists($posts, 'nextPageUrl') && $posts->nextPageUrl())
        <link rel="next" href="{{ $posts->nextPageUrl() }}">
    @endif
    <script type="application/ld+json">
        {!! json_encode($itemListSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@push('styles')
    <style>
        .resources-page {
            background: #f8fafc;
        }

        .resources-hero {
            padding: clamp(32px, 5vw, 64px) 0 clamp(24px, 4vw, 44px);
            background: #ffffff;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .resources-title {
            font-size: clamp(2rem, 4vw, 3.3rem);
            line-height: 1.08;
            margin-bottom: 12px;
            color: #0f172a;
        }

        .resources-subtitle {
            max-width: 720px;
            margin: 0 auto;
            color: #475569;
            font-size: 1.05rem;
        }

        .resource-card {
            height: 100%;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 14px;
            background: #ffffff;
            overflow: hidden;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        }

        .resource-card__image {
            aspect-ratio: 16 / 10;
            background: #f1f5f9;
            overflow: hidden;
        }

        .resource-card__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .resource-card__body {
            padding: 18px;
        }

        .resource-card__title {
            font-size: 1.05rem;
            line-height: 1.35;
            margin-bottom: 10px;
        }

        .resource-card__title a {
            color: #0f172a;
            text-decoration: none;
        }

        .resource-card__title a:hover {
            color: var(--accent-color);
        }

        .resource-card__excerpt {
            color: #64748b;
            margin-bottom: 14px;
        }

        .resource-card__meta {
            color: #94a3b8;
            font-size: 0.86rem;
        }

        .resources-pagination .pagination {
            margin-bottom: 0;
            justify-content: center;
        }

        .resources-pagination .page-link {
            min-width: 46px;
            min-height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #0f172a;
            border-color: rgba(15, 23, 42, 0.14);
            text-decoration: none;
        }

        .resources-pagination .page-item.active .page-link {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: #ffffff;
        }

        .resources-pagination svg {
            width: 18px;
            height: 18px;
        }
    </style>
@endpush

@section('main')
<div class="resources-page">
    <section class="resources-hero">
        <div class="container text-center">
            <nav class="breadcrumb justify-content-center mb-3">
                <a href="{{ url('/') }}">Home</a>
                <span class="mx-2">/</span>
                <span>Resources</span>
            </nav>
            <h1 class="resources-title">Networking Resources</h1>
            <p class="resources-subtitle">{{ $metaDescription }}</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($posts as $post)
                    @php
                        $postUrl = route('blog_single', $post->slug);
                        $postImage = uploaded_image_url($post->photo, asset('assets/images/placeholder.svg'));
                        $postAlt = trim((string) $post->alter_text) !== '' ? $post->alter_text : $post->title . ' image';
                        $excerpt = trim(strip_tags((string) ($post->meta_description ?: $post->description)));
                        $excerpt = \Illuminate\Support\Str::limit($excerpt, 150);
                    @endphp
                    <div class="col-sm-6 col-lg-4">
                        <article class="resource-card">
                            <a class="resource-card__image d-block" href="{{ $postUrl }}" aria-label="{{ $post->title }}">
                                <img src="{{ $postImage }}"
                                     alt="{{ $postAlt }}"
                                     loading="lazy"
                                     decoding="async">
                            </a>
                            <div class="resource-card__body">
                                <h2 class="resource-card__title">
                                    <a href="{{ $postUrl }}">{{ $post->title }}</a>
                                </h2>
                                @if($excerpt !== '')
                                    <p class="resource-card__excerpt">{{ $excerpt }}</p>
                                @endif
                                <div class="resource-card__meta">
                                    Updated {{ optional($post->updated_at ?: $post->created_at)->format('M j, Y') }}
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center mb-0">
                            Resources will be published here soon.
                        </div>
                    </div>
                @endforelse
            </div>

            @if(method_exists($posts, 'links'))
                <div class="resources-pagination mt-5 d-flex justify-content-center">
                    {{ $posts->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
