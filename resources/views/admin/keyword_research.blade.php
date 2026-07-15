@extends('layouts.appbar')

@section('content')
<div class="content-wrapper keyword-page">
    <section class="keyword-hero">
        <div class="container-fluid">
            <div class="keyword-hero-copy">
                <span class="keyword-kicker">SEO tools</span>
                <h1>Keyword Research</h1>
                <p>Find keyword ideas, estimated search volume, difficulty, and traffic potential by country.</p>
            </div>

            <form class="keyword-search" method="GET" action="{{ route('admin.keyword-research') }}">
                <div class="engine-tabs" aria-label="Search engine">
                    <span class="active">Google</span>
                    <span>Bing</span>
                    <span>YouTube</span>
                    <span>Amazon</span>
                </div>
                <div class="keyword-input-row">
                    <input type="text"
                           name="input"
                           value="{{ $keyword }}"
                           placeholder="Enter keyword, e.g. mikrotik kenya"
                           autocomplete="off">
                    <select name="country" aria-label="Select country">
                        @foreach($countries as $code => $option)
                            <option value="{{ $code }}" {{ $country === $code ? 'selected' : '' }}>
                                {{ $option['code'] }} - {{ $option['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit">Find keywords</button>
                </div>
                <div class="keyword-example">
                    For example, <a href="{{ route('admin.keyword-research', ['country' => 'ke', 'input' => 'mikrotik kenya']) }}">mikrotik kenya</a>
                </div>
            </form>
        </div>
    </section>

    <section class="content keyword-content">
        <div class="container-fluid">
            <div class="keyword-alert">
                <i class="fas fa-info-circle"></i>
                <span>These are internal keyword estimates based on your site catalog, content matches, and market multipliers. Connect a paid SEO data API later if exact third-party volumes are required.</span>
            </div>

            <div class="keyword-results-header">
                <div>
                    <h2>Keyword ideas for "{{ $research['summary']['keyword'] }}"</h2>
                    <p>The first {{ number_format($research['phrase']->count()) }} keywords out of {{ number_format($research['summary']['ideas_total']) }} estimated ideas in {{ $research['country']['name'] }}.</p>
                </div>
                <a class="ahrefs-link"
                   href="https://ahrefs.com/keyword-generator/?country={{ $country }}&input={{ rawurlencode($keyword) }}"
                   target="_blank"
                   rel="noopener">
                    Compare in Ahrefs <i class="fas fa-external-link-alt"></i>
                </a>
            </div>

            <div class="keyword-summary-grid">
                <div class="keyword-summary-card">
                    <span>Volume</span>
                    <strong>{{ $research['summary']['volume_label'] }}</strong>
                    <small>Estimated monthly searches</small>
                </div>
                <div class="keyword-summary-card">
                    <span>KD</span>
                    <strong>{{ $research['summary']['kd_label'] }}</strong>
                    <small>{{ $research['summary']['kd'] === null ? 'Not enough signal' : $research['summary']['kd'] . '/100 difficulty' }}</small>
                </div>
                <div class="keyword-summary-card">
                    <span>Traffic potential</span>
                    <strong>{{ number_format($research['summary']['traffic']) }}</strong>
                    <small>Estimated monthly visits</small>
                </div>
                <div class="keyword-summary-card">
                    <span>CPC</span>
                    <strong>${{ number_format($research['summary']['cpc'], 2) }}</strong>
                    <small>Estimated paid-search CPC</small>
                </div>
            </div>

            <div class="keyword-main-grid">
                <div class="keyword-table-card">
                    <div class="keyword-tabs" role="tablist" aria-label="Keyword idea type">
                        <button type="button" class="keyword-tab active" data-keyword-tab="phrase">Phrase match</button>
                        <button type="button" class="keyword-tab" data-keyword-tab="questions">Questions</button>
                    </div>

                    <div class="keyword-panel active" data-keyword-panel="phrase">
                        @include('admin.partials.keyword_table', ['rows' => $research['phrase']])
                    </div>
                    <div class="keyword-panel" data-keyword-panel="questions" hidden>
                        @include('admin.partials.keyword_table', ['rows' => $research['questions']])
                    </div>
                </div>

                <aside class="keyword-side-card">
                    <div class="keyword-side-header">
                        <h3>Matched site content</h3>
                        <span>{{ number_format($research['summary']['matched_content']) }} matches</span>
                    </div>
                    <div class="matched-list">
                        @forelse($research['matches'] as $match)
                            <a href="{{ $match['url'] }}" target="_blank" rel="noopener" class="matched-item">
                                <span>{{ $match['type'] }}</span>
                                <strong>{{ $match['label'] }}</strong>
                                @if(!empty($match['value']))
                                    <em>{{ $match['value'] }}</em>
                                @endif
                            </a>
                        @empty
                            <div class="matched-empty">
                                No close matches in your existing content. Consider creating a page targeting this keyword.
                            </div>
                        @endforelse
                    </div>
                </aside>
            </div>
        </div>
    </section>
</div>

<style>
    .keyword-page {
        background: #f3f4f7;
        min-height: 100vh;
        color: #111827;
        font-family: Arial, sans-serif;
        padding-bottom: 32px;
    }

    .keyword-hero {
        background: #1f1f1f;
        color: #fff;
        padding: 42px 0 52px;
    }

    .keyword-hero-copy {
        max-width: 980px;
        margin-bottom: 28px;
    }

    .keyword-kicker {
        display: block;
        color: #bdbdbd;
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .keyword-hero h1 {
        font-size: clamp(2.3rem, 6vw, 5rem);
        line-height: 1;
        font-weight: 800;
        margin: 0 0 16px;
        letter-spacing: 0;
    }

    .keyword-hero p {
        font-size: 1.2rem;
        margin: 0;
        color: #f8fafc;
    }

    .keyword-search {
        max-width: 1120px;
    }

    .engine-tabs {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        font-size: 1.35rem;
        font-weight: 700;
        color: #c9c9c9;
    }

    .engine-tabs span:not(:last-child)::after {
        content: "/";
        color: #c9c9c9;
        margin-left: 12px;
    }

    .engine-tabs .active {
        color: #ff8b00;
        border-bottom: 3px solid #ff8b00;
    }

    .keyword-input-row {
        display: grid;
        grid-template-columns: minmax(260px, 1fr) minmax(180px, 290px) 210px;
        gap: 12px;
    }

    .keyword-input-row input,
    .keyword-input-row select {
        height: 58px;
        background: #1f1f1f;
        border: 2px solid #8a8a8a;
        color: #fff;
        border-radius: 5px;
        padding: 0 18px;
        font-size: 1.08rem;
        outline: none;
    }

    .keyword-input-row input:focus,
    .keyword-input-row select:focus {
        border-color: #ff8b00;
        box-shadow: 0 0 0 3px rgba(255, 139, 0, 0.18);
    }

    .keyword-input-row button {
        height: 58px;
        border: 0;
        border-radius: 6px;
        background: #ff8b00;
        color: #fff;
        font-size: 1.05rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .keyword-example {
        margin-top: 14px;
        color: #d0d0d0;
        font-size: 1rem;
    }

    .keyword-example a {
        color: #fff;
        font-weight: 700;
    }

    .keyword-content {
        margin-top: -26px;
    }

    .keyword-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        padding: 12px 14px;
        color: #5f6368;
        font-size: 0.9rem;
        margin-bottom: 14px;
    }

    .keyword-alert i {
        color: #1a73e8;
    }

    .keyword-results-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
        background: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        padding: 22px 24px;
        margin-bottom: 14px;
    }

    .keyword-results-header h2 {
        margin: 0 0 6px;
        font-size: 1.7rem;
        color: #111827;
        font-weight: 800;
    }

    .keyword-results-header p {
        margin: 0;
        color: #5f6368;
        font-size: 1rem;
    }

    .ahrefs-link {
        color: #ff6500;
        font-weight: 700;
        text-decoration: none;
    }

    .ahrefs-link:hover {
        color: #d85700;
        text-decoration: underline;
    }

    .keyword-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 14px;
    }

    .keyword-summary-card {
        background: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        padding: 18px;
        min-height: 122px;
    }

    .keyword-summary-card span {
        display: block;
        color: #5f6368;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
    }

    .keyword-summary-card strong {
        display: block;
        font-size: 2rem;
        color: #111827;
        margin: 10px 0;
        line-height: 1;
    }

    .keyword-summary-card small {
        color: #6b7280;
    }

    .keyword-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 14px;
        align-items: start;
    }

    .keyword-table-card,
    .keyword-side-card {
        background: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        overflow: hidden;
    }

    .keyword-tabs {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 20px 24px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .keyword-tab {
        border: 0;
        border-bottom: 3px solid transparent;
        background: transparent;
        padding: 0 0 11px;
        font-size: 1.05rem;
        font-weight: 700;
        color: #304ffe;
    }

    .keyword-tab.active {
        color: #ff5b00;
        border-bottom-color: #ff5b00;
    }

    .keyword-panel {
        overflow-x: auto;
    }

    .keyword-table {
        width: 100%;
        min-width: 880px;
        border-collapse: collapse;
    }

    .keyword-table th,
    .keyword-table td {
        border-bottom: 1px solid #e5e7eb;
        padding: 14px 18px;
        vertical-align: middle;
        font-size: 0.98rem;
    }

    .keyword-table th {
        text-align: left;
        color: #111827;
        font-weight: 800;
        font-size: 1rem;
    }

    .keyword-table th.numeric,
    .keyword-table td.numeric {
        text-align: right;
        white-space: nowrap;
    }

    .keyword-cell {
        min-width: 300px;
    }

    .keyword-cell strong {
        display: block;
        color: #111827;
        font-weight: 500;
    }

    .keyword-cell span {
        display: inline-flex;
        margin-top: 4px;
        color: #6b7280;
        font-size: 0.78rem;
    }

    .kd-badge {
        display: inline-flex;
        min-width: 58px;
        justify-content: center;
        border-radius: 4px;
        padding: 6px 9px;
        font-weight: 800;
        line-height: 1;
    }

    .kd-easy {
        background: #28a879;
        color: #fff;
    }

    .kd-medium {
        background: #fbbc04;
        color: #111827;
    }

    .kd-hard {
        background: #d93025;
        color: #fff;
    }

    .kd-na {
        background: #f1f3f4;
        color: #374151;
    }

    .keyword-side-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 18px;
        border-bottom: 1px solid #e5e7eb;
    }

    .keyword-side-header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
    }

    .keyword-side-header span {
        color: #5f6368;
        font-size: 0.84rem;
    }

    .matched-list {
        display: flex;
        flex-direction: column;
    }

    .matched-item {
        display: block;
        padding: 14px 18px;
        border-bottom: 1px solid #f0f1f3;
        text-decoration: none;
    }

    .matched-item:hover {
        background: #f8fafc;
        text-decoration: none;
    }

    .matched-item span {
        display: block;
        color: #ff6500;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .matched-item strong {
        display: block;
        color: #111827;
        margin: 4px 0;
        line-height: 1.25;
    }

    .matched-item em,
    .matched-empty {
        color: #5f6368;
        font-size: 0.84rem;
        font-style: normal;
    }

    .matched-empty {
        padding: 18px;
    }

    @media (max-width: 1200px) {
        .keyword-main-grid {
            grid-template-columns: 1fr;
        }

        .keyword-summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .keyword-input-row {
            grid-template-columns: 1fr;
        }

        .keyword-summary-grid {
            grid-template-columns: 1fr;
        }

        .keyword-hero {
            padding-top: 28px;
        }
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('[data-keyword-tab]');
        const panels = document.querySelectorAll('[data-keyword-panel]');

        tabButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const target = button.dataset.keywordTab;

                tabButtons.forEach(function (item) {
                    item.classList.toggle('active', item === button);
                });

                panels.forEach(function (panel) {
                    const active = panel.dataset.keywordPanel === target;
                    panel.classList.toggle('active', active);
                    panel.hidden = !active;
                });
            });
        });
    });
</script>
@endpush
