@extends('theme.orbit.layouts.main')

@section('title', 'Calculators')
@section('meta_description', 'Access helpful networking, internet, and product planning calculators from Orbitlink Solutions.')
@section('canonical', route('calculators'))

@section('main')
<section class="orbit-calculators-page">
    <div class="container">
        <div class="calculators-hero">
            <span>Resources</span>
            <h1>Calculators</h1>
            <p>Use these quick tools to estimate internet usage, network planning, and project requirements.</p>
        </div>

        <div class="calculator-grid">
            <a class="calculator-card" href="{{ route('speed-test') }}">
                <i class="fas fa-tachometer-alt"></i>
                <strong>Internet Speed Test</strong>
                <small>Measure ping, download speed, and upload speed.</small>
            </a>
            <a class="calculator-card" href="{{ url('shop') }}">
                <i class="fas fa-network-wired"></i>
                <strong>Network Equipment Planner</strong>
                <small>Browse routers, switches, access points, and cabling.</small>
            </a>
            <a class="calculator-card" href="{{ route('contacts') }}">
                <i class="fas fa-calculator"></i>
                <strong>Project Cost Estimate</strong>
                <small>Request a tailored estimate for installation or supply.</small>
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .orbit-calculators-page {
        background: #f5f7fb;
        padding: 48px 0 64px;
    }

    .calculators-hero {
        max-width: 780px;
        margin-bottom: 24px;
    }

    .calculators-hero span {
        display: inline-flex;
        border-radius: 999px;
        padding: 6px 14px;
        background: #fff4e7;
        color: #c45a00;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .calculators-hero h1 {
        margin: 12px 0 8px;
        color: #0f172a;
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        letter-spacing: 0;
    }

    .calculators-hero p {
        margin: 0;
        color: #526174;
        font-size: 1.04rem;
    }

    .calculator-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .calculator-card {
        min-height: 190px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 24px;
        background: #fff;
        border: 1px solid #dbe3ee;
        border-radius: 8px;
        color: #102033;
        text-decoration: none;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
    }

    .calculator-card:hover {
        color: #102033;
        border-color: #f47a20;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .calculator-card i {
        width: 48px;
        aspect-ratio: 1;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: #eef5ff;
        color: #1d4ed8;
        font-size: 1.2rem;
    }

    .calculator-card strong {
        display: block;
        font-size: 1.15rem;
        color: #0f172a;
    }

    .calculator-card small {
        color: #526174;
        font-size: 0.94rem;
        line-height: 1.45;
    }

    @media (max-width: 900px) {
        .calculator-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
