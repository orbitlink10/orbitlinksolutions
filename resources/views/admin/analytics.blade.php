@extends('layouts.appbar')

@section('content')
<div class="content-wrapper analytics-page">
    <section class="content-header analytics-header">
        <div class="container-fluid">
            <div class="analytics-title-row">
                <div>
                    <span class="analytics-kicker">Search performance</span>
                    <h1 class="analytics-title">Analytics</h1>
                    <p class="analytics-subtitle">
                        Search Console-style visibility snapshot for {{ get_option('site_name') }}.
                    </p>
                </div>
                <div class="analytics-actions">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="analyticsExport">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt"></i> View site
                    </a>
                </div>
            </div>

            <div class="analytics-filter-bar">
                @foreach($analytics['ranges'] as $days => $label)
                    <a href="{{ route('admin.analytics', ['range' => $days]) }}"
                       class="analytics-range {{ $analytics['range'] === $days ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
                <span class="analytics-date-range">
                    {{ $analytics['startDate']->format('M j, Y') }} - {{ $analytics['endDate']->format('M j, Y') }}
                </span>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="analytics-note">
                <i class="fas fa-info-circle"></i>
                <span>Clicks and impressions are estimated from available site content, orders, product leads, and activity because no Google Search Console API credentials are configured.</span>
            </div>

            <div class="analytics-metrics">
                <div class="analytics-metric metric-clicks">
                    <span class="metric-label">Total clicks</span>
                    <strong>{{ number_format($analytics['totals']['clicks']) }}</strong>
                    <span class="metric-help">Estimated visits from search intent</span>
                </div>
                <div class="analytics-metric metric-impressions">
                    <span class="metric-label">Total impressions</span>
                    <strong>{{ number_format($analytics['totals']['impressions']) }}</strong>
                    <span class="metric-help">Estimated result visibility</span>
                </div>
                <div class="analytics-metric metric-ctr">
                    <span class="metric-label">Average CTR</span>
                    <strong>{{ number_format($analytics['totals']['ctr'], 1) }}%</strong>
                    <span class="metric-help">Clicks divided by impressions</span>
                </div>
                <div class="analytics-metric metric-position">
                    <span class="metric-label">Average position</span>
                    <strong>{{ number_format($analytics['totals']['position'], 1) }}</strong>
                    <span class="metric-help">{{ number_format($analytics['totals']['indexed_pages']) }} indexed URLs tracked</span>
                </div>
            </div>

            <div class="analytics-card analytics-chart-card">
                <div class="analytics-card-header">
                    <div>
                        <h2>Performance</h2>
                        <p>{{ $analytics['rangeLabel'] }} trend</p>
                    </div>
                    <div class="analytics-legend">
                        <span><i class="legend-clicks"></i> Clicks</span>
                        <span><i class="legend-impressions"></i> Impressions</span>
                    </div>
                </div>
                <div class="analytics-chart-wrap">
                    <canvas id="analyticsChart" height="120"></canvas>
                </div>
            </div>

            <div class="analytics-card analytics-table-card">
                <div class="gsc-tabs" role="tablist" aria-label="Analytics dimensions">
                    @foreach($analytics['tabs'] as $key => $tab)
                        <button type="button"
                                class="gsc-tab {{ $loop->first ? 'active' : '' }}"
                                data-tab="{{ $key }}"
                                role="tab"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ $tab['label'] }}
                        </button>
                    @endforeach
                </div>

                <div class="gsc-toolbar">
                    <span class="gsc-toolbar-title">Performance by dimension</span>
                    <button type="button" class="gsc-filter" aria-label="Filter table">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>

                @foreach($analytics['tabs'] as $key => $tab)
                    <div class="gsc-panel {{ $loop->first ? 'active' : '' }}" data-panel="{{ $key }}" {{ $loop->first ? '' : 'hidden' }}>
                        <div class="gsc-table-wrap">
                            <table class="gsc-table" data-export-table="{{ $key }}">
                                <thead>
                                    <tr>
                                        <th>{{ $tab['firstColumn'] }}</th>
                                        <th class="numeric sorted"><i class="fas fa-arrow-down"></i> Clicks</th>
                                        <th class="numeric">Impressions</th>
                                        <th class="numeric">CTR</th>
                                        <th class="numeric">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tab['rows'] as $row)
                                        <tr>
                                            <td>
                                                <div class="dimension-cell">
                                                    @if(!empty($row['url']))
                                                        <a href="{{ $row['url'] }}" target="_blank" rel="noopener">{{ $row['label'] }}</a>
                                                        <span>{{ $row['url'] }}</span>
                                                    @else
                                                        <strong>{{ $row['label'] }}</strong>
                                                    @endif
                                                    @if(!empty($row['type']) && $key === 'pages')
                                                        <em>{{ $row['type'] }}</em>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="numeric clicks">{{ number_format($row['clicks']) }}</td>
                                            <td class="numeric impressions">{{ number_format($row['impressions']) }}</td>
                                            <td class="numeric">{{ number_format($row['ctr'], 1) }}%</td>
                                            <td class="numeric">{{ number_format($row['position'], 1) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="empty-state">No analytics data available for this range.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<style>
    .analytics-page {
        background: #f1f3f4;
        color: #202124;
        min-height: 100vh;
        padding-bottom: 32px;
        font-family: Arial, sans-serif;
    }

    .analytics-header {
        padding: 22px 0 10px;
    }

    .analytics-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 18px;
        flex-wrap: wrap;
    }

    .analytics-kicker {
        color: #5f6368;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .analytics-title {
        margin: 4px 0;
        font-size: 1.9rem;
        font-weight: 500;
        color: #202124;
    }

    .analytics-subtitle {
        margin: 0;
        color: #5f6368;
        font-size: 0.95rem;
    }

    .analytics-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .analytics-actions .btn {
        border-radius: 18px;
        font-weight: 600;
    }

    .analytics-filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .analytics-range {
        border: 1px solid #dadce0;
        border-radius: 18px;
        color: #3c4043;
        padding: 7px 14px;
        font-size: 0.85rem;
        text-decoration: none;
        background: #fff;
    }

    .analytics-range:hover,
    .analytics-range.active {
        border-color: #1a73e8;
        background: #e8f0fe;
        color: #1967d2;
        text-decoration: none;
    }

    .analytics-date-range {
        color: #5f6368;
        font-size: 0.85rem;
        margin-left: 4px;
    }

    .analytics-note {
        display: flex;
        gap: 10px;
        align-items: center;
        border: 1px solid #dadce0;
        border-radius: 8px;
        padding: 10px 12px;
        background: #fff;
        color: #5f6368;
        font-size: 0.85rem;
        margin-bottom: 14px;
    }

    .analytics-note i {
        color: #1a73e8;
    }

    .analytics-metrics {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 14px;
    }

    .analytics-metric {
        border-radius: 8px;
        padding: 16px;
        min-height: 128px;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .metric-clicks {
        background: #1a73e8;
    }

    .metric-impressions {
        background: #673ab7;
    }

    .metric-ctr {
        background: #188038;
    }

    .metric-position {
        background: #f29900;
    }

    .metric-label,
    .metric-help {
        font-size: 0.84rem;
        opacity: 0.92;
    }

    .analytics-metric strong {
        display: block;
        font-size: 2rem;
        line-height: 1.1;
        font-weight: 500;
        margin: 12px 0;
    }

    .analytics-card {
        background: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        box-shadow: none;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .analytics-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px 8px;
    }

    .analytics-card-header h2 {
        margin: 0;
        font-size: 1rem;
        color: #202124;
        font-weight: 500;
    }

    .analytics-card-header p {
        margin: 3px 0 0;
        color: #5f6368;
        font-size: 0.83rem;
    }

    .analytics-legend {
        display: flex;
        gap: 14px;
        color: #5f6368;
        font-size: 0.83rem;
    }

    .analytics-legend i {
        display: inline-block;
        width: 22px;
        height: 3px;
        border-radius: 999px;
        margin-right: 6px;
        vertical-align: middle;
    }

    .legend-clicks {
        background: #1a73e8;
    }

    .legend-impressions {
        background: #673ab7;
    }

    .analytics-chart-wrap {
        height: 260px;
        padding: 6px 14px 16px;
    }

    .gsc-tabs {
        display: grid;
        grid-template-columns: repeat(6, minmax(120px, 1fr));
        border-bottom: 1px solid #dadce0;
        overflow-x: auto;
    }

    .gsc-tab {
        border: 0;
        border-bottom: 3px solid transparent;
        background: #fff;
        color: #5f6368;
        padding: 17px 14px;
        font-size: 0.95rem;
        font-weight: 600;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .gsc-tab.active {
        color: #202124;
        border-bottom-color: #3c4043;
    }

    .gsc-toolbar {
        min-height: 78px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 28px;
        border-bottom: 1px solid #dadce0;
    }

    .gsc-toolbar-title {
        color: #5f6368;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .gsc-filter {
        border: 0;
        background: transparent;
        color: #3c4043;
        font-size: 1.1rem;
        padding: 8px;
    }

    .gsc-table-wrap {
        overflow-x: auto;
    }

    .gsc-table {
        width: 100%;
        min-width: 860px;
        border-collapse: collapse;
        background: #fff;
    }

    .gsc-table th,
    .gsc-table td {
        border-bottom: 1px solid #e0e0e0;
        padding: 14px 28px;
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .gsc-table th {
        color: #777;
        font-weight: 600;
        text-align: left;
        height: 58px;
    }

    .gsc-table th.numeric,
    .gsc-table td.numeric {
        text-align: right;
        white-space: nowrap;
    }

    .gsc-table th.sorted {
        color: #202124;
    }

    .gsc-table td {
        color: #202124;
    }

    .gsc-table .clicks {
        color: #1a73e8;
        font-weight: 500;
    }

    .gsc-table .impressions {
        color: #673ab7;
        font-weight: 500;
    }

    .dimension-cell {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 260px;
    }

    .dimension-cell a,
    .dimension-cell strong {
        color: #202124;
        font-weight: 500;
        text-decoration: none;
    }

    .dimension-cell a:hover {
        color: #1a73e8;
        text-decoration: underline;
    }

    .dimension-cell span,
    .dimension-cell em {
        color: #777;
        font-size: 0.78rem;
        font-style: normal;
    }

    .dimension-cell em {
        display: inline-flex;
        width: fit-content;
        border: 1px solid #dadce0;
        border-radius: 999px;
        padding: 2px 8px;
        background: #f8fafd;
    }

    .empty-state {
        text-align: center;
        color: #777;
        padding: 32px !important;
    }

    @media (max-width: 1200px) {
        .analytics-metrics {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .gsc-tabs {
            grid-template-columns: repeat(6, minmax(150px, 1fr));
        }
    }

    @media (max-width: 576px) {
        .analytics-title-row,
        .analytics-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .analytics-metrics {
            grid-template-columns: 1fr;
        }

        .analytics-chart-wrap {
            height: 220px;
        }

        .gsc-toolbar,
        .gsc-table th,
        .gsc-table td {
            padding-left: 16px;
            padding-right: 16px;
        }
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($analytics['chart']['labels']);
        const clicks = @json($analytics['chart']['clicks']);
        const impressions = @json($analytics['chart']['impressions']);
        const chartElement = document.getElementById('analyticsChart');

        if (chartElement && window.Chart) {
            new Chart(chartElement.getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Clicks',
                            data: clicks,
                            borderColor: '#1a73e8',
                            backgroundColor: 'rgba(26, 115, 232, 0.08)',
                            borderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 4,
                            lineTension: 0.25,
                            fill: false
                        },
                        {
                            label: 'Impressions',
                            data: impressions,
                            borderColor: '#673ab7',
                            backgroundColor: 'rgba(103, 58, 183, 0.08)',
                            borderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 4,
                            lineTension: 0.25,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    tooltips: { mode: 'index', intersect: false },
                    hover: { mode: 'nearest', intersect: true },
                    scales: {
                        xAxes: [{
                            gridLines: { display: false },
                            ticks: { maxTicksLimit: 8, fontColor: '#5f6368' }
                        }],
                        yAxes: [{
                            gridLines: { color: '#edf0f2', drawBorder: false },
                            ticks: { beginAtZero: true, fontColor: '#5f6368' }
                        }]
                    }
                }
            });
        }

        const tabButtons = document.querySelectorAll('.gsc-tab');
        const panels = document.querySelectorAll('.gsc-panel');

        tabButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const target = button.dataset.tab;

                tabButtons.forEach(function (item) {
                    item.classList.toggle('active', item === button);
                    item.setAttribute('aria-selected', item === button ? 'true' : 'false');
                });

                panels.forEach(function (panel) {
                    const isActive = panel.dataset.panel === target;
                    panel.classList.toggle('active', isActive);
                    panel.hidden = !isActive;
                });
            });
        });

        const exportButton = document.getElementById('analyticsExport');

        if (exportButton) {
            exportButton.addEventListener('click', function () {
                const activePanel = document.querySelector('.gsc-panel.active');
                const table = activePanel ? activePanel.querySelector('table') : null;

                if (!table) {
                    return;
                }

                const rows = Array.from(table.querySelectorAll('tr')).map(function (row) {
                    return Array.from(row.children).map(function (cell) {
                        return '"' + cell.innerText.replace(/\s+/g, ' ').trim().replace(/"/g, '""') + '"';
                    }).join(',');
                }).join('\n');
                const blob = new Blob([rows], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'analytics-' + (table.dataset.exportTable || 'report') + '.csv';
                link.click();
                URL.revokeObjectURL(link.href);
            });
        }
    });
</script>
@endpush
