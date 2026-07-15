@extends('layouts.appbar')

@php
    $hasAudit = !empty($audit);
    $summary = $audit['summary'] ?? [
        'pages_crawled' => 0,
        'resources' => 0,
        'links_found' => 0,
        'uncrawled' => 0,
        'health_score' => 0,
        'health_label' => 'Pending',
        'errors' => 0,
        'warnings' => 0,
        'notices' => 0,
        'issues_total' => 0,
        'pages_with_errors' => 0,
        'pages_without_errors' => 0,
    ];
    $totalUrls = max(1, $summary['pages_crawled'] + $summary['resources']);
    $internalPercent = round(($summary['pages_crawled'] / $totalUrls) * 100, 1);
    $resourcePercent = max(0, 100 - $internalPercent);
    $linkTotal = max(1, $summary['links_found'] + $summary['uncrawled']);
    $crawledLinks = max(0, $summary['links_found'] - $summary['uncrawled']);
    $crawledLinkPercent = round(($crawledLinks / $linkTotal) * 100, 1);
    $healthAngle = round(($summary['health_score'] / 100) * 180, 1) . 'deg';
    $maxIssueCount = max(1, $summary['errors'], $summary['warnings'], $summary['notices']);
    $errorUrlTotal = max(1, $summary['pages_with_errors'] + $summary['pages_without_errors']);
    $errorUrlPercent = round(($summary['pages_with_errors'] / $errorUrlTotal) * 100, 1);
    $issueGroups = $audit['issue_groups'] ?? collect();
@endphp

@section('content')
<div class="content-wrapper audit-page">
    <section class="audit-topbar">
        <div class="audit-topbar-row">
            <div class="audit-brand">ahrefs</div>
            <div class="audit-topnav">
                <span>Dashboard</span>
                <span>Site Explorer</span>
                <span>Keywords Explorer</span>
                <span>Site Audit</span>
            </div>
        </div>
        <div class="audit-project-row">
            <div class="audit-crumbs">
                <span>All projects</span>
                <i class="fas fa-chevron-right"></i>
                <strong>{{ $audit['host'] ?? parse_url($inputUrl, PHP_URL_HOST) ?? 'Website' }}</strong>
                <i class="fas fa-chevron-right"></i>
                <strong>Site Audit</strong>
            </div>
            <div class="audit-actions">
                <span><i class="far fa-calendar-alt"></i> {{ $audit['date'] ?? now()->format('j M') }}</span>
                <span>Compare with: {{ $audit['compare_date'] ?? now()->subDays(7)->format('j M') }}</span>
                <button type="submit" form="siteAuditForm" name="fresh" value="1">
                    <i class="fas fa-play"></i> Site audit
                </button>
            </div>
        </div>
    </section>

    <section class="audit-shell">
        <aside class="audit-rail">
            <a href="#overview" class="active"><i class="fas fa-tachometer-alt"></i><span>Overview</span></a>
            <a href="#all-issues"><i class="fas fa-exclamation-circle"></i><span>All Issues</span></a>
            <a href="#all-issues"><i class="fas fa-bell"></i><span>Alerts</span></a>
            <a href="#all-issues"><i class="fas fa-download"></i><span>Bulk export</span></a>
            <strong>Tools</strong>
            <a href="#all-issues"><i class="fas fa-file-alt"></i><span>Page explorer</span></a>
            <a href="#all-issues"><i class="fas fa-link"></i><span>Link explorer</span></a>
            <a href="#all-issues"><i class="fas fa-sitemap"></i><span>Structure explorer</span></a>
            <strong>Reports</strong>
            <a href="#all-issues"><i class="fas fa-file-code"></i><span>Internal pages</span></a>
            <a href="#all-issues"><i class="fas fa-search"></i><span>Indexability</span></a>
            <a href="#all-issues"><i class="fas fa-align-left"></i><span>Content</span></a>
            <a href="#all-issues"><i class="fas fa-share-alt"></i><span>Social tags</span></a>
            <a href="#all-issues"><i class="fas fa-copy"></i><span>Duplicates</span></a>
            <a href="#all-issues"><i class="fas fa-image"></i><span>Images</span></a>
            <a href="#all-issues"><i class="fab fa-js"></i><span>JavaScript</span></a>
            <a href="#all-issues"><i class="fab fa-css3-alt"></i><span>CSS</span></a>
            <a href="#all-issues"><i class="fas fa-sitemap"></i><span>Sitemaps</span></a>
        </aside>

        <main class="audit-main">
            <form id="siteAuditForm" class="audit-url-form" method="GET" action="{{ route('admin.site-audit') }}">
                <div>
                    <label for="auditUrl">Website URL</label>
                    <input id="auditUrl" type="url" name="url" value="{{ $inputUrl }}" placeholder="https://example.com" required>
                </div>
                <button type="submit" name="fresh" value="1">
                    <i class="fas fa-search"></i> Site audit
                </button>
            </form>

            @if($auditError)
                <div class="audit-alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ $auditError }}</span>
                </div>
            @endif

            <div id="overview" class="audit-section-head">
                <div>
                    <h1>Overview</h1>
                    @if($hasAudit)
                        <p>{{ $summary['pages_crawled'] }} pages crawled in {{ $audit['duration'] }}s</p>
                    @endif
                </div>
                <button type="button" onclick="window.print()">
                    <i class="fas fa-file-download"></i> Print to PDF
                </button>
            </div>

            @if($hasAudit)
                <div class="audit-overview-grid">
                    <article class="audit-panel">
                        <h2>Crawled URLs distribution <span>{{ number_format($totalUrls) }}</span></h2>
                        <div class="audit-donut-wrap">
                            <div class="audit-donut" style="--first: {{ $internalPercent }}%; --first-color: #a9d0f1; --second-color: #2f86d9;"></div>
                            <div class="audit-legend">
                                <div><i style="background:#a9d0f1"></i><span>Internal</span><strong>{{ number_format($summary['pages_crawled']) }}</strong></div>
                                <div><i style="background:#2f86d9"></i><span>Resources</span><strong>{{ number_format($summary['resources']) }}</strong></div>
                            </div>
                        </div>
                    </article>

                    <article class="audit-panel audit-health">
                        <h2>Health Score</h2>
                        <div class="audit-meter" style="--angle: {{ $healthAngle }};">
                            <div>
                                <strong>{{ $summary['health_score'] }}</strong>
                                <span>{{ $summary['health_label'] }}</span>
                            </div>
                        </div>
                        <p>Health Score reflects the proportion of crawled internal URLs without critical errors.</p>
                        <div class="audit-mini-bars">
                            @for($i = 0; $i < 10; $i++)
                                <span style="height: {{ 14 + (($summary['health_score'] + ($i * 11)) % 40) }}px"></span>
                            @endfor
                        </div>
                    </article>

                    <article class="audit-panel">
                        <h2>Issues distribution <span>{{ number_format($summary['issues_total']) }}</span></h2>
                        <div class="audit-bars">
                            <div>
                                <span>Errors</span>
                                <strong>{{ number_format($summary['errors']) }}</strong>
                                <em class="bar-red" style="width: {{ round(($summary['errors'] / $maxIssueCount) * 100) }}%"></em>
                            </div>
                            <div>
                                <span>Warnings</span>
                                <strong>{{ number_format($summary['warnings']) }}</strong>
                                <em class="bar-yellow" style="width: {{ round(($summary['warnings'] / $maxIssueCount) * 100) }}%"></em>
                            </div>
                            <div>
                                <span>Notices</span>
                                <strong>{{ number_format($summary['notices']) }}</strong>
                                <em class="bar-blue" style="width: {{ round(($summary['notices'] / $maxIssueCount) * 100) }}%"></em>
                            </div>
                        </div>
                    </article>

                    <article class="audit-panel">
                        <h2>Crawl status of links found <span>{{ number_format($linkTotal) }}</span></h2>
                        <div class="audit-donut-wrap">
                            <div class="audit-donut" style="--first: {{ $crawledLinkPercent }}%; --first-color: #58b24d; --second-color: #e7eaee;"></div>
                            <div class="audit-legend">
                                <div><i style="background:#58b24d"></i><span>Crawled</span><strong>{{ number_format($crawledLinks) }}</strong></div>
                                <div><i style="background:#e7eaee"></i><span>Uncrawled</span><strong>{{ number_format($summary['uncrawled']) }}</strong></div>
                            </div>
                        </div>
                    </article>

                    <article class="audit-panel">
                        <h2>Error distribution <span>{{ number_format($errorUrlTotal) }}</span></h2>
                        <div class="audit-donut-wrap">
                            <div class="audit-donut" style="--first: {{ $errorUrlPercent }}%; --first-color: #dc0000; --second-color: #58b24d;"></div>
                            <div class="audit-legend">
                                <div><i style="background:#dc0000"></i><span>URLs with errors</span><strong>{{ number_format($summary['pages_with_errors']) }}</strong></div>
                                <div><i style="background:#58b24d"></i><span>URLs without errors</span><strong>{{ number_format($summary['pages_without_errors']) }}</strong></div>
                            </div>
                        </div>
                    </article>
                </div>

                <section id="all-issues" class="audit-issues-panel">
                    <div class="audit-issues-toolbar">
                        <div class="audit-tabs">
                            <span class="active">Actual {{ number_format(count($audit['issues'])) }}</span>
                            <span>New {{ number_format(collect($audit['issues'])->sum('new')) }}</span>
                            <span>All tracked {{ number_format($summary['issues_total']) }}</span>
                            <span>Turned off 0</span>
                        </div>
                        <div class="audit-toolbar-actions">
                            <button type="button">Importance <i class="fas fa-chevron-down"></i></button>
                            <button type="button"><i class="fas fa-code"></i> AI · API</button>
                            <button type="button" onclick="window.print()"><i class="fas fa-download"></i> Export all issues</button>
                        </div>
                    </div>

                    <div class="audit-table-wrap">
                        <table class="audit-table">
                            <thead>
                                <tr>
                                    <th>Issue</th>
                                    <th>Crawled</th>
                                    <th>Change</th>
                                    <th>Added</th>
                                    <th>New</th>
                                    <th>Removed</th>
                                    <th>Missing</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($issueGroups as $category => $rows)
                                    <tr class="audit-category-row">
                                        <td colspan="8">{{ $category }}</td>
                                    </tr>
                                    @foreach(collect($rows)->groupBy('group') as $group => $groupRows)
                                        <tr class="audit-group-row">
                                            <td colspan="8">{{ $group }}</td>
                                        </tr>
                                        @foreach($groupRows as $row)
                                            <tr>
                                                <td>
                                                    <span class="audit-issue-icon {{ $row['severity'] }}">
                                                        {{ $row['severity'] === 'error' ? '!' : 'i' }}
                                                    </span>
                                                    <span>{{ $row['issue'] }}</span>
                                                    @if($row['new'] > 0)
                                                        <em>New</em>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($row['crawled']) }}</td>
                                                <td class="{{ $row['trend'] === 'down' ? 'down' : ($row['trend'] === 'up' ? 'up' : 'muted') }}">
                                                    {{ $row['change'] ?: 0 }}
                                                    @if($row['trend'] === 'up')
                                                        <i class="fas fa-caret-up"></i>
                                                    @elseif($row['trend'] === 'down')
                                                        <i class="fas fa-caret-down"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $row['added'] ? number_format($row['added']) : 0 }}</td>
                                                <td>{{ $row['new'] ? number_format($row['new']) : 0 }}</td>
                                                <td>{{ $row['removed'] ? number_format($row['removed']) : 0 }}</td>
                                                <td>{{ $row['missing'] ? number_format($row['missing']) : 0 }}</td>
                                                <td>
                                                    <div class="audit-spark">
                                                        @foreach($row['spark'] as $height)
                                                            <i style="height: {{ $height }}px"></i>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="8" class="audit-empty">No issues found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            @else
                <div class="audit-empty-state">
                    <i class="fas fa-search"></i>
                    <strong>Run a crawl to see the audit overview.</strong>
                </div>
            @endif
        </main>
    </section>
</div>

<style>
    .audit-page {
        background: #e9edf2;
        min-height: 100vh;
        color: #333;
        font-family: Arial, sans-serif;
    }

    .audit-topbar {
        background: #2f3d57;
        color: #d7dde8;
        border-bottom: 1px solid #26334a;
    }

    .audit-topbar-row,
    .audit-project-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 14px 24px;
    }

    .audit-brand {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 800;
    }

    .audit-brand::first-letter {
        color: #ff8b00;
    }

    .audit-topnav,
    .audit-crumbs,
    .audit-actions {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .audit-topnav span {
        font-weight: 700;
        color: #c5ccda;
    }

    .audit-project-row {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .audit-crumbs strong {
        color: #fff;
        font-size: 1.05rem;
    }

    .audit-actions span,
    .audit-actions button {
        border: 0;
        border-radius: 4px;
        background: #52617a;
        color: #fff;
        padding: 9px 13px;
        font-weight: 700;
    }

    .audit-actions button {
        background: #ff8b00;
    }

    .audit-shell {
        display: grid;
        grid-template-columns: 220px minmax(0, 1fr);
        min-height: calc(100vh - 112px);
    }

    .audit-rail {
        background: #edf0f4;
        border-right: 1px solid #d8dde4;
        padding: 22px 14px;
    }

    .audit-rail a,
    .audit-rail strong {
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 4px;
        color: #3f3f46;
        padding: 8px 12px;
        text-decoration: none;
        font-size: 0.98rem;
    }

    .audit-rail a.active {
        background: #dfe3e9;
    }

    .audit-rail i {
        width: 18px;
        color: #6b7280;
        text-align: center;
    }

    .audit-rail strong {
        margin-top: 14px;
        font-weight: 800;
    }

    .audit-main {
        padding: 24px;
        overflow-x: hidden;
    }

    .audit-url-form {
        display: grid;
        grid-template-columns: minmax(240px, 1fr) 160px;
        gap: 10px;
        align-items: end;
        margin-bottom: 18px;
    }

    .audit-url-form label {
        display: block;
        margin-bottom: 6px;
        color: #5f6368;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .audit-url-form input {
        width: 100%;
        height: 46px;
        border: 1px solid #c7cbd1;
        border-radius: 4px;
        padding: 0 14px;
        font-size: 1rem;
    }

    .audit-url-form input:focus {
        border-color: #2f86d9;
        outline: none;
        box-shadow: 0 0 0 3px rgba(47, 134, 217, 0.16);
    }

    .audit-url-form button,
    .audit-section-head button,
    .audit-toolbar-actions button {
        height: 46px;
        border: 1px solid #c7cbd1;
        border-radius: 4px;
        background: #fff;
        color: #333;
        padding: 0 14px;
        font-weight: 700;
    }

    .audit-url-form button {
        background: #ff8b00;
        border-color: #ff8b00;
        color: #fff;
    }

    .audit-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff3cd;
        border: 1px solid #ffe08a;
        border-radius: 4px;
        padding: 12px 14px;
        margin-bottom: 18px;
        color: #7a5200;
    }

    .audit-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 18px;
    }

    .audit-section-head h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
    }

    .audit-section-head p {
        margin: 4px 0 0;
        color: #777;
    }

    .audit-overview-grid {
        display: grid;
        grid-template-columns: minmax(260px, 1fr) minmax(320px, 1.1fr) minmax(260px, 1fr);
        gap: 18px;
        align-items: stretch;
    }

    .audit-panel,
    .audit-issues-panel,
    .audit-empty-state {
        background: #fff;
        border: 1px solid #dde1e6;
        border-radius: 4px;
        padding: 24px;
    }

    .audit-health {
        grid-row: span 2;
    }

    .audit-panel h2 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 26px;
        font-size: 1.05rem;
        font-weight: 800;
    }

    .audit-panel h2 span {
        color: #005bb5;
        font-weight: 500;
    }

    .audit-donut-wrap {
        display: grid;
        grid-template-columns: 170px 1fr;
        gap: 20px;
        align-items: center;
    }

    .audit-donut {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: conic-gradient(var(--first-color) 0 var(--first), var(--second-color) var(--first) 100%);
        position: relative;
    }

    .audit-donut::after {
        content: "";
        position: absolute;
        inset: 40px;
        border-radius: 50%;
        background: #fff;
    }

    .audit-legend {
        display: grid;
        gap: 12px;
    }

    .audit-legend div {
        display: grid;
        grid-template-columns: 14px 1fr auto;
        gap: 10px;
        align-items: center;
        border-bottom: 1px solid #eceff3;
        padding-bottom: 8px;
    }

    .audit-legend i {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .audit-meter {
        position: relative;
        width: min(330px, 100%);
        aspect-ratio: 2 / 1;
        margin: 16px auto 12px;
        overflow: hidden;
    }

    .audit-meter::before {
        content: "";
        position: absolute;
        width: 100%;
        aspect-ratio: 1;
        border-radius: 50%;
        background: conic-gradient(from 270deg, #ff8b00 0 var(--angle), #e6e9ee var(--angle) 180deg, transparent 180deg 360deg);
    }

    .audit-meter::after {
        content: "";
        position: absolute;
        left: 20%;
        right: 20%;
        bottom: -60%;
        aspect-ratio: 1;
        border-radius: 50%;
        background: #fff;
    }

    .audit-meter div {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 10px;
        z-index: 1;
        text-align: center;
    }

    .audit-meter strong {
        display: block;
        font-size: 4rem;
        line-height: 1;
        font-weight: 400;
    }

    .audit-meter span {
        display: inline-flex;
        border-radius: 4px;
        background: #83b92d;
        color: #fff;
        padding: 3px 18px;
        font-weight: 800;
    }

    .audit-health p {
        max-width: 360px;
        margin: 0 auto 26px;
        color: #777;
        text-align: center;
    }

    .audit-mini-bars {
        display: flex;
        align-items: end;
        gap: 7px;
        border-top: 1px solid #e5e7eb;
        padding-top: 20px;
        height: 72px;
    }

    .audit-mini-bars span {
        width: 28px;
        background: linear-gradient(#ffd76a, #ff8b00);
    }

    .audit-bars {
        display: grid;
        gap: 16px;
    }

    .audit-bars div {
        display: grid;
        grid-template-columns: 120px 70px minmax(100px, 1fr);
        gap: 14px;
        align-items: center;
    }

    .audit-bars strong {
        color: #005bb5;
        font-weight: 500;
        text-align: right;
    }

    .audit-bars em {
        display: block;
        height: 32px;
        border-radius: 4px;
    }

    .bar-red {
        background: #dc0000;
    }

    .bar-yellow {
        background: #ffce00;
    }

    .bar-blue {
        background: #348bd6;
    }

    .audit-issues-panel {
        margin-top: 18px;
        padding: 0;
        overflow: hidden;
    }

    .audit-issues-toolbar {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        padding: 18px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .audit-tabs,
    .audit-toolbar-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .audit-tabs span {
        border: 1px solid #d6dbe1;
        border-radius: 4px;
        padding: 7px 12px;
        background: #fff;
    }

    .audit-tabs .active {
        background: #ffd9ad;
        border-color: #ffc37c;
    }

    .audit-toolbar-actions button {
        height: 38px;
    }

    .audit-table-wrap {
        overflow-x: auto;
    }

    .audit-table {
        width: 100%;
        min-width: 1040px;
        border-collapse: collapse;
    }

    .audit-table th,
    .audit-table td {
        border-bottom: 1px solid #e5e7eb;
        padding: 11px 14px;
        text-align: right;
        vertical-align: middle;
        font-size: 0.96rem;
    }

    .audit-table th:first-child,
    .audit-table td:first-child {
        text-align: left;
        width: 38%;
    }

    .audit-category-row td {
        background: #fff;
        color: #333;
        font-size: 1.05rem;
        font-weight: 800;
        padding-top: 18px;
    }

    .audit-group-row td {
        color: #7a7a7a;
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .audit-issue-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 800;
        margin-right: 10px;
    }

    .audit-issue-icon.error {
        background: #fa3434;
    }

    .audit-issue-icon.warning {
        background: #ffcc00;
        color: #fff;
    }

    .audit-issue-icon.notice {
        background: #2f86d9;
    }

    .audit-table em {
        display: inline-flex;
        margin-left: 10px;
        background: #2f86d9;
        color: #fff;
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 0.75rem;
        font-style: normal;
        font-weight: 800;
    }

    .audit-table .up {
        color: #f33434;
    }

    .audit-table .down {
        color: #009b55;
    }

    .audit-table .muted {
        color: #aaa;
    }

    .audit-spark {
        display: inline-flex;
        align-items: end;
        gap: 3px;
        height: 38px;
    }

    .audit-spark i {
        display: block;
        width: 6px;
        background: #bdd9f4;
    }

    .audit-empty,
    .audit-empty-state {
        color: #6b7280;
        text-align: center;
    }

    .audit-empty-state {
        display: grid;
        gap: 12px;
        place-items: center;
        min-height: 220px;
    }

    .audit-empty-state i {
        color: #2f86d9;
        font-size: 2rem;
    }

    @media (max-width: 1200px) {
        .audit-shell {
            grid-template-columns: 1fr;
        }

        .audit-rail {
            display: none;
        }

        .audit-overview-grid {
            grid-template-columns: 1fr;
        }

        .audit-health {
            grid-row: auto;
        }
    }

    @media (max-width: 768px) {
        .audit-topbar-row,
        .audit-project-row,
        .audit-section-head,
        .audit-issues-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .audit-url-form,
        .audit-donut-wrap {
            grid-template-columns: 1fr;
        }

        .audit-main {
            padding: 16px;
        }
    }

    @media print {
        .main-sidebar,
        .main-header,
        .audit-topbar,
        .audit-url-form,
        .audit-rail,
        .audit-actions,
        .audit-section-head button,
        .audit-toolbar-actions {
            display: none !important;
        }

        .audit-shell,
        .audit-overview-grid {
            display: block;
        }

        .audit-panel,
        .audit-issues-panel {
            break-inside: avoid;
            margin-bottom: 14px;
        }
    }
</style>
@endsection
