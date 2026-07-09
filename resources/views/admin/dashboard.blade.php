@extends('layouts.appbar')
@section('content')
<div class="content-wrapper dashboard-page">
    <section class="content-header">
        <div class="container-fluid">
            <div class="dashboard-header">
                <div>
                    <span class="dashboard-kicker">Admin Overview</span>
                    <h1 class="dashboard-title">Dashboard</h1>
                    <p class="dashboard-subtitle">View and manage all customer orders</p>
                </div>
                <div class="dashboard-header-actions">
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> New Invoice
                    </a>
                    <a href="{{ url('admin/users') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                    <a href="{{ url('products') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-cogs"></i> Manage Products
                    </a>
                </div>
            </div>
            <ol class="breadcrumb float-sm-right dashboard-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row dashboard-row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-stat stat-blue">
                        <div class="stat-header">
                            <span class="stat-icon"><i class="fas fa-shopping-bag"></i></span>
                            <span class="stat-label">Orders</span>
                        </div>
                        <div class="stat-value">{{ $orders->count() }}</div>
                        <a href="{{ route('orders.index') }}" class="stat-link">View orders <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-stat stat-emerald">
                        <div class="stat-header">
                            <span class="stat-icon"><i class="fas fa-file-invoice"></i></span>
                            <span class="stat-label">Invoices</span>
                        </div>
                        <div class="stat-value">{{ $invoices->count() }}</div>
                        <a href="{{ route('invoices.index') }}" class="stat-link">View invoices <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                @if(Auth::user()->is_admin())
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-stat stat-amber">
                        <div class="stat-header">
                            <span class="stat-icon"><i class="fas fa-user-friends"></i></span>
                            <span class="stat-label">Users</span>
                        </div>
                        <div class="stat-value">{{ $users->count() }}</div>
                        <a href="{{ route('admin.users') }}" class="stat-link">View users <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                @endif
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-stat stat-rose">
                        <div class="stat-header">
                            <span class="stat-icon"><i class="fas fa-bell"></i></span>
                            <span class="stat-label">Enquiries</span>
                        </div>
                        <div class="stat-value">{{ $enquiries->count() }}</div>
                        <a href="{{ route('notifications.index') }}" class="stat-link">View enquiries <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row dashboard-row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-metric metric-slate">
                        <div class="metric-label">Total Revenue</div>
                        <div class="metric-value">KSh {{ number_format($totalRevenue, 2) }}</div>
                        <div class="metric-sub">Paid orders</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-metric metric-blue">
                        <div class="metric-label">Recent Orders</div>
                        <div class="metric-value">{{ $recentOrders }}</div>
                        <div class="metric-sub">Last 7 days</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-metric metric-emerald">
                        <div class="metric-label">New Users</div>
                        <div class="metric-value">{{ $newUsers }}</div>
                        <div class="metric-sub">Last 30 days</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="dashboard-metric metric-amber">
                        <div class="metric-label">Active Users</div>
                        <div class="metric-value">{{ $users->where('last_login_at', '>=', now()->subDay())->count() }}</div>
                        <div class="metric-sub">Last 24 hours</div>
                    </div>
                </div>
            </div>

            <div class="row dashboard-row">
                <div class="col-lg-7 mb-4">
                    <div class="card dashboard-panel">
                        <div class="dashboard-panel-header">
                            <h4 class="dashboard-panel-title">Recent Activities</h4>
                            <span class="dashboard-panel-meta">Latest updates</span>
                        </div>
                        <ul class="dashboard-activity-list">
                            @forelse($recentActivities as $activity)
                                <li class="dashboard-activity-item">
                                    <div class="activity-title">{{ $activity->description }}</div>
                                    <div class="activity-meta">{{ $activity->created_at->diffForHumans() }}</div>
                                </li>
                            @empty
                                <li class="dashboard-activity-item">
                                    <div class="activity-title">No recent activity yet.</div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 mb-4">
                    <div class="card dashboard-panel">
                        <div class="dashboard-panel-header">
                            <h4 class="dashboard-panel-title">Quick Actions</h4>
                            <span class="dashboard-panel-meta">Shortcuts</span>
                        </div>
                        <div class="dashboard-action-list">
                            <a href="{{ route('invoices.create') }}" class="dashboard-action-link">
                                <span class="action-icon"><i class="fas fa-plus"></i></span>
                                <span>
                                    <strong>Add New Invoice</strong>
                                    <small>Generate and send payment requests</small>
                                </span>
                            </a>
                            <a href="{{ url('admin/users') }}" class="dashboard-action-link">
                                <span class="action-icon"><i class="fas fa-users"></i></span>
                                <span>
                                    <strong>Manage Users</strong>
                                    <small>Review customers and permissions</small>
                                </span>
                            </a>
                            <a href="{{ url('products') }}" class="dashboard-action-link">
                                <span class="action-icon"><i class="fas fa-cogs"></i></span>
                                <span>
                                    <strong>Manage Products</strong>
                                    <small>Update pricing and availability</small>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .dashboard-page {
        background: #f4f6fb;
        padding-bottom: 24px;
    }

    .dashboard-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .dashboard-kicker {
        display: inline-flex;
        padding: 6px 14px;
        border-radius: 999px;
        background: #e2e8f0;
        color: #475569;
        font-size: 0.7rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        font-weight: 600;
    }

    .dashboard-title {
        margin: 8px 0 6px;
        font-size: 2rem;
        color: #0f172a;
        font-weight: 600;
    }

    .dashboard-subtitle {
        margin: 0;
        color: #64748b;
        font-size: 0.95rem;
    }

    .dashboard-header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }

    .dashboard-header-actions .btn {
        border-radius: 999px;
        padding: 0.35rem 0.95rem;
        font-weight: 600;
    }

    .dashboard-breadcrumb {
        margin-top: 12px;
    }

    .dashboard-stat {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
        position: relative;
        overflow: hidden;
        min-height: 150px;
    }

    .dashboard-stat::after {
        content: "";
        position: absolute;
        right: -40px;
        top: -40px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--stat-glow);
        opacity: 0.12;
    }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--stat-soft);
        color: var(--stat-accent);
        font-size: 18px;
    }

    .stat-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #64748b;
        font-weight: 600;
    }

    .stat-value {
        font-size: 1.9rem;
        font-weight: 600;
        color: #0f172a;
        margin: 10px 0 8px;
    }

    .stat-link {
        font-size: 0.85rem;
        text-decoration: none;
        color: var(--stat-accent);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
    }

    .stat-blue {
        --stat-accent: #2563eb;
        --stat-soft: rgba(37, 99, 235, 0.12);
        --stat-glow: #2563eb;
    }

    .stat-emerald {
        --stat-accent: #059669;
        --stat-soft: rgba(5, 150, 105, 0.12);
        --stat-glow: #059669;
    }

    .stat-amber {
        --stat-accent: #d97706;
        --stat-soft: rgba(217, 119, 6, 0.12);
        --stat-glow: #d97706;
    }

    .stat-rose {
        --stat-accent: #e11d48;
        --stat-soft: rgba(225, 29, 72, 0.12);
        --stat-glow: #e11d48;
    }

    .dashboard-metric {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 14px 26px rgba(15, 23, 42, 0.06);
        position: relative;
        overflow: hidden;
    }

    .dashboard-metric::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 4px;
        width: 100%;
        background: var(--metric-accent);
    }

    .metric-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #64748b;
        font-weight: 600;
    }

    .metric-value {
        font-size: 1.4rem;
        font-weight: 600;
        color: #0f172a;
        margin: 10px 0 6px;
    }

    .metric-sub {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .metric-slate {
        --metric-accent: #334155;
    }

    .metric-blue {
        --metric-accent: #3b82f6;
    }

    .metric-emerald {
        --metric-accent: #10b981;
    }

    .metric-amber {
        --metric-accent: #f59e0b;
    }

    .dashboard-panel {
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .dashboard-panel-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .dashboard-panel-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #0f172a;
    }

    .dashboard-panel-meta {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .dashboard-activity-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .dashboard-activity-item {
        padding: 14px 20px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .dashboard-activity-item:last-child {
        border-bottom: none;
    }

    .activity-title {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .activity-meta {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .dashboard-action-list {
        display: grid;
        gap: 12px;
        padding: 18px 20px 20px;
    }

    .dashboard-action-link {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #0f172a;
        text-decoration: none;
    }

    .dashboard-action-link:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #1e3a8a;
    }

    .dashboard-action-link small {
        display: block;
        color: #64748b;
        font-size: 0.82rem;
    }

    .action-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #e0e7ff;
        color: #1d4ed8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .dashboard-title {
            font-size: 1.6rem;
        }

        .dashboard-header-actions {
            width: 100%;
        }
    }
</style>
@endsection
