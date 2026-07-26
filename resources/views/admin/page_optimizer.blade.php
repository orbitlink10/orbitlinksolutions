@extends('layouts.appbar')

@section('content')
<div class="content-wrapper optimizer-page">
    <section class="content-header optimizer-header">
        <div class="container-fluid">
            <div class="optimizer-title-row">
                <div>
                    <span class="optimizer-kicker">SEO tools</span>
                    <h1>Page Optimizer</h1>
                    <p>Check on-page SEO gaps and compare your page against a competitor.</p>
                </div>
                @if($analysis && !empty($analysis['url']))
                    <a class="btn btn-outline-secondary btn-sm optimizer-open-link" href="{{ $analysis['url'] }}" target="_blank" rel="noopener">
                        <i class="fas fa-external-link-alt"></i> Open checked page
                    </a>
                @endif
            </div>

            <form class="optimizer-form" method="GET" action="{{ route('admin.page-optimizer') }}">
                <div class="optimizer-form-grid">
                    <label>
                        <span>Page URL</span>
                        <input type="url"
                               name="url"
                               value="{{ $targetUrl }}"
                               placeholder="https://example.com/page"
                               required>
                    </label>
                    <label>
                        <span>Competitor URL</span>
                        <input type="url"
                               name="competitor_url"
                               value="{{ $competitorUrl }}"
                               placeholder="https://competitor.com/page">
                    </label>
                    <button type="submit">
                        <i class="fas fa-search"></i>
                        <span>Check SEO Gaps</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="content optimizer-content">
        <div class="container-fluid">
            @if(!$analysis)
                <div class="optimizer-empty">
                    <i class="fas fa-magic"></i>
                    <h2>Enter a page URL to start.</h2>
                    <p>The optimizer will fetch the page, inspect its crawlable HTML, and return the highest-priority fixes.</p>
                </div>
            @elseif(!$analysis['ok'])
                <div class="optimizer-alert optimizer-alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>{{ $analysis['error'] }}</strong>
                        <span>{{ $analysis['url'] }}</span>
                    </div>
                </div>
            @else
                @php
                    $issueCount = collect($analysis['issues'] ?? [])->count();
                    $highCount = collect($analysis['issues'] ?? [])->where('severity', 'High')->count();
                    $scoreClass = $analysis['score'] >= 80 ? 'good' : ($analysis['score'] >= 60 ? 'warning' : 'danger');
                @endphp

                @if($analysis['redirect'])
                    <div class="optimizer-alert optimizer-alert-warning">
                        <i class="fas fa-random"></i>
                        <div>
                            <strong>This URL redirects.</strong>
                            <span>{{ $analysis['redirect'] }}</span>
                        </div>
                    </div>
                @endif

                <div class="optimizer-summary-grid">
                    <div class="optimizer-summary optimizer-score-card {{ $scoreClass }}">
                        <span>SEO score</span>
                        <strong>{{ $analysis['score'] }}</strong>
                        <small>out of 100</small>
                    </div>
                    <div class="optimizer-summary">
                        <span>Gaps found</span>
                        <strong>{{ number_format($issueCount) }}</strong>
                        <small>{{ number_format($highCount) }} high priority</small>
                    </div>
                    <div class="optimizer-summary">
                        <span>Content depth</span>
                        <strong>{{ number_format($analysis['metrics']['word_count']) }}</strong>
                        <small>visible words</small>
                    </div>
                    <div class="optimizer-summary">
                        <span>Fetch time</span>
                        <strong>{{ number_format($analysis['load_ms']) }}</strong>
                        <small>milliseconds</small>
                    </div>
                </div>

                <div class="optimizer-main-grid">
                    <div class="optimizer-panel">
                        <div class="optimizer-panel-header">
                            <div>
                                <h2>SEO Gaps</h2>
                                <p>{{ $analysis['url'] }}</p>
                            </div>
                        </div>
                        <div class="optimizer-table-wrap">
                            <table class="optimizer-table">
                                <thead>
                                    <tr>
                                        <th>Priority</th>
                                        <th>Gap</th>
                                        <th>Recommended fix</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($analysis['issues'] as $issue)
                                        <tr>
                                            <td>
                                                <span class="severity severity-{{ strtolower($issue['severity']) }}">{{ $issue['severity'] }}</span>
                                            </td>
                                            <td>{{ $issue['item'] }}</td>
                                            <td>{{ $issue['fix'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="optimizer-empty-row">No major SEO gaps found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <aside class="optimizer-panel optimizer-side-panel">
                        <div class="optimizer-panel-header compact">
                            <h2>Page Signals</h2>
                        </div>
                        <dl class="optimizer-signals">
                            <div>
                                <dt>Status</dt>
                                <dd>{{ $analysis['status'] }}</dd>
                            </div>
                            <div>
                                <dt>Title</dt>
                                <dd>{{ $analysis['metrics']['title_length'] }} chars</dd>
                            </div>
                            <div>
                                <dt>Description</dt>
                                <dd>{{ $analysis['metrics']['description_length'] }} chars</dd>
                            </div>
                            <div>
                                <dt>H1 / H2</dt>
                                <dd>{{ $analysis['metrics']['headings']['counts']['h1'] }} / {{ $analysis['metrics']['headings']['counts']['h2'] }}</dd>
                            </div>
                            <div>
                                <dt>Images alt</dt>
                                <dd>{{ $analysis['metrics']['images']['alt_coverage'] }}%</dd>
                            </div>
                            <div>
                                <dt>Links</dt>
                                <dd>{{ $analysis['metrics']['links']['internal'] }} internal, {{ $analysis['metrics']['links']['external'] }} external</dd>
                            </div>
                            <div>
                                <dt>Schema</dt>
                                <dd>{{ $analysis['metrics']['schema_count'] }} blocks</dd>
                            </div>
                            <div>
                                <dt>Canonical</dt>
                                <dd>{{ $analysis['metrics']['canonical'] ? 'Present' : 'Missing' }}</dd>
                            </div>
                        </dl>

                        <div class="optimizer-terms">
                            <h3>Top terms</h3>
                            <div class="term-list">
                                @forelse($analysis['terms'] as $term)
                                    <span>{{ $term }}</span>
                                @empty
                                    <em>No clear terms found.</em>
                                @endforelse
                            </div>
                        </div>
                    </aside>
                </div>

                <div class="optimizer-panel optimizer-detail-panel">
                    <div class="optimizer-panel-header compact">
                        <h2>Working Signals</h2>
                    </div>
                    <div class="pass-grid">
                        @forelse($analysis['passes'] as $pass)
                            <div class="pass-item">
                                <i class="fas fa-check"></i>
                                <span>{{ $pass['item'] }}</span>
                            </div>
                        @empty
                            <div class="pass-item muted">
                                <i class="fas fa-minus"></i>
                                <span>No passing signals listed.</span>
                            </div>
                        @endforelse
                    </div>
                </div>

                @if($competitorUrl !== '')
                    @if(!$competitor || !$competitor['ok'])
                        <div class="optimizer-alert optimizer-alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <strong>Competitor page could not be checked.</strong>
                                <span>{{ $competitor['error'] ?? 'Check the competitor URL and try again.' }}</span>
                            </div>
                        </div>
                    @elseif($comparison)
                        <div class="optimizer-panel optimizer-compare-panel">
                            <div class="optimizer-panel-header">
                                <div>
                                    <h2>Competitor Gap Comparison</h2>
                                    <p>{{ $competitor['url'] }}</p>
                                </div>
                                <span class="compare-count">{{ number_format($comparison['gap_count']) }} competitive gaps</span>
                            </div>

                            <div class="optimizer-table-wrap">
                                <table class="optimizer-table compare-table">
                                    <thead>
                                        <tr>
                                            <th>Signal</th>
                                            <th>Your page</th>
                                            <th>Competitor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($comparison['rows'] as $row)
                                            <tr>
                                                <td>{{ $row['label'] }}</td>
                                                <td>{{ $row['target'] }}</td>
                                                <td>{{ $row['competitor'] }}</td>
                                                <td>
                                                    <span class="compare-status compare-{{ $row['status'] }}">{{ $row['status_label'] }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="competitor-terms-grid">
                                <div>
                                    <h3>Competitor terms missing from your page</h3>
                                    <div class="term-list">
                                        @forelse($comparison['missing_terms'] as $term)
                                            <span>{{ $term }}</span>
                                        @empty
                                            <em>No notable missing terms.</em>
                                        @endforelse
                                    </div>
                                </div>
                                <div>
                                    <h3>Shared terms</h3>
                                    <div class="term-list muted">
                                        @forelse($comparison['shared_terms'] as $term)
                                            <span>{{ $term }}</span>
                                        @empty
                                            <em>No shared top terms found.</em>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </section>
</div>

<style>
    .optimizer-page {
        background: #f3f5f8;
        color: #111827;
        min-height: 100vh;
        padding-bottom: 32px;
        font-family: Arial, sans-serif;
    }

    .optimizer-header {
        background: #151a22;
        color: #fff;
        padding: 30px 0 36px;
    }

    .optimizer-title-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .optimizer-kicker {
        display: inline-flex;
        color: #a8c7fa;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .optimizer-title-row h1 {
        margin: 8px 0 6px;
        font-size: 2.25rem;
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: 0;
    }

    .optimizer-title-row p {
        margin: 0;
        color: #d1d5db;
        font-size: 0.98rem;
    }

    .optimizer-open-link {
        border-radius: 18px;
        color: #f8fafc;
        border-color: #475569;
        font-weight: 700;
    }

    .optimizer-form {
        background: #fff;
        border: 1px solid #d7dde7;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 18px 45px rgba(3, 7, 18, 0.16);
    }

    .optimizer-form-grid {
        display: grid;
        grid-template-columns: minmax(260px, 1fr) minmax(260px, 1fr) 210px;
        gap: 12px;
        align-items: end;
    }

    .optimizer-form label {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin: 0;
        color: #374151;
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .optimizer-form input {
        height: 48px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 0 14px;
        color: #111827;
        font-size: 0.96rem;
        text-transform: none;
        outline: none;
    }

    .optimizer-form input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .optimizer-form button {
        height: 48px;
        border: 0;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        background: #f97316;
        color: #fff;
        font-size: 0.94rem;
        font-weight: 900;
        text-transform: uppercase;
    }

    .optimizer-content {
        margin-top: -18px;
    }

    .optimizer-empty,
    .optimizer-alert,
    .optimizer-panel,
    .optimizer-summary {
        background: #fff;
        border: 1px solid #d7dde7;
        border-radius: 8px;
    }

    .optimizer-empty {
        min-height: 260px;
        display: grid;
        place-items: center;
        text-align: center;
        padding: 34px;
        color: #475569;
    }

    .optimizer-empty i {
        width: 54px;
        aspect-ratio: 1;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 1.5rem;
        margin-bottom: 12px;
    }

    .optimizer-empty h2 {
        margin: 0 0 8px;
        color: #111827;
        font-size: 1.35rem;
        font-weight: 800;
    }

    .optimizer-empty p {
        margin: 0;
        max-width: 560px;
    }

    .optimizer-alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }

    .optimizer-alert i {
        margin-top: 3px;
    }

    .optimizer-alert strong,
    .optimizer-alert span {
        display: block;
    }

    .optimizer-alert span {
        color: #64748b;
        word-break: break-word;
    }

    .optimizer-alert-danger {
        border-color: #fecaca;
        color: #991b1b;
    }

    .optimizer-alert-warning {
        border-color: #fed7aa;
        color: #9a3412;
    }

    .optimizer-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 14px;
    }

    .optimizer-summary {
        padding: 16px;
        min-height: 122px;
    }

    .optimizer-summary span {
        display: block;
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .optimizer-summary strong {
        display: block;
        color: #111827;
        font-size: 2rem;
        line-height: 1;
        margin: 14px 0 8px;
    }

    .optimizer-summary small {
        color: #64748b;
    }

    .optimizer-score-card.good {
        border-color: #86efac;
        background: #f0fdf4;
    }

    .optimizer-score-card.warning {
        border-color: #fdba74;
        background: #fff7ed;
    }

    .optimizer-score-card.danger {
        border-color: #fca5a5;
        background: #fef2f2;
    }

    .optimizer-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 350px;
        gap: 14px;
        align-items: start;
    }

    .optimizer-panel {
        overflow: hidden;
        margin-bottom: 14px;
    }

    .optimizer-panel-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .optimizer-panel-header.compact {
        padding-bottom: 12px;
    }

    .optimizer-panel-header h2 {
        margin: 0;
        font-size: 1.05rem;
        color: #111827;
        font-weight: 800;
    }

    .optimizer-panel-header p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 0.82rem;
        word-break: break-word;
    }

    .optimizer-table-wrap {
        overflow-x: auto;
    }

    .optimizer-table {
        width: 100%;
        min-width: 760px;
        border-collapse: collapse;
    }

    .optimizer-table th,
    .optimizer-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
        color: #1f2937;
        font-size: 0.92rem;
    }

    .optimizer-table th {
        text-align: left;
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 900;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .optimizer-empty-row {
        text-align: center;
        color: #64748b !important;
        padding: 28px !important;
    }

    .severity,
    .compare-status,
    .compare-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 5px 9px;
        font-size: 0.76rem;
        line-height: 1;
        font-weight: 900;
        white-space: nowrap;
    }

    .severity-high,
    .compare-gap {
        background: #fee2e2;
        color: #991b1b;
    }

    .severity-medium {
        background: #ffedd5;
        color: #9a3412;
    }

    .severity-low,
    .compare-match {
        background: #e0f2fe;
        color: #075985;
    }

    .compare-ahead {
        background: #dcfce7;
        color: #166534;
    }

    .compare-count {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .optimizer-signals {
        margin: 0;
    }

    .optimizer-signals div {
        display: grid;
        grid-template-columns: 118px minmax(0, 1fr);
        gap: 12px;
        padding: 12px 18px;
        border-bottom: 1px solid #edf2f7;
    }

    .optimizer-signals dt {
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 900;
        text-transform: uppercase;
    }

    .optimizer-signals dd {
        margin: 0;
        color: #111827;
        font-weight: 700;
        word-break: break-word;
    }

    .optimizer-terms {
        padding: 18px;
    }

    .optimizer-terms h3,
    .competitor-terms-grid h3 {
        margin: 0 0 10px;
        color: #111827;
        font-size: 0.92rem;
        font-weight: 900;
    }

    .term-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .term-list span {
        display: inline-flex;
        border: 1px solid #cbd5e1;
        border-radius: 999px;
        padding: 5px 10px;
        background: #f8fafc;
        color: #334155;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .term-list.muted span {
        background: #f1f5f9;
        color: #64748b;
    }

    .term-list em {
        color: #64748b;
        font-style: normal;
        font-size: 0.86rem;
    }

    .pass-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
        padding: 18px;
    }

    .pass-item {
        display: flex;
        align-items: center;
        gap: 9px;
        min-height: 46px;
        border: 1px solid #dbe7de;
        border-radius: 6px;
        padding: 10px 12px;
        color: #166534;
        background: #f0fdf4;
        font-size: 0.88rem;
        font-weight: 700;
    }

    .pass-item.muted {
        color: #64748b;
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    .optimizer-compare-panel {
        margin-top: 2px;
    }

    .compare-table {
        min-width: 820px;
    }

    .competitor-terms-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        padding: 18px 20px 22px;
        border-top: 1px solid #e5e7eb;
    }

    @media (max-width: 1200px) {
        .optimizer-form-grid,
        .optimizer-main-grid {
            grid-template-columns: 1fr;
        }

        .optimizer-form button {
            width: 100%;
        }

        .optimizer-summary-grid,
        .pass-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .optimizer-header {
            padding-top: 24px;
        }

        .optimizer-title-row h1 {
            font-size: 1.85rem;
        }

        .optimizer-summary-grid,
        .pass-grid,
        .competitor-terms-grid {
            grid-template-columns: 1fr;
        }

        .optimizer-panel-header {
            flex-direction: column;
        }

        .optimizer-signals div {
            grid-template-columns: 1fr;
            gap: 3px;
        }
    }
</style>
@endsection
