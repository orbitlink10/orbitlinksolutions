@extends('layouts.appbar')

@section('content')
<style>
    .football-prediction-page {
        background: #0f1c27;
        color: #edf7fc;
        min-height: calc(100vh - 56px);
    }

    .football-prediction-header {
        background: #162a3a;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 8px;
        padding: 18px 20px;
    }

    .football-prediction-header .text-muted,
    .football-match-card .text-muted {
        color: #a9bdc9 !important;
    }

    .football-shell {
        align-items: start;
        display: grid;
        gap: 18px;
        grid-template-columns: minmax(0, 1fr) 360px;
    }

    .football-match-card {
        background: #1a3144;
        border: 1px solid rgba(255, 255, 255, .07);
        border-radius: 8px;
        box-shadow: 0 10px 24px rgba(0, 0, 0, .18);
        padding: 12px;
    }

    .football-match-card + .football-match-card {
        margin-top: 12px;
    }

    .football-match-meta {
        align-items: center;
        color: #b8ccd6;
        display: flex;
        flex-wrap: wrap;
        font-weight: 600;
        gap: 10px;
    }

    .football-match-number {
        color: #ffffff;
        font-size: 1.15rem;
        min-width: 24px;
    }

    .football-teams {
        color: #ffffff;
        font-size: 1.05rem;
        font-weight: 700;
        line-height: 1.35;
        margin: 8px 0 12px;
    }

    .football-pick-grid {
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 7px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        overflow: hidden;
    }

    .football-pick-option {
        margin: 0;
        position: relative;
    }

    .football-pick-option input {
        opacity: 0;
        pointer-events: none;
        position: absolute;
    }

    .football-pick-option > span {
        align-items: center;
        background: #345468;
        border-right: 1px solid rgba(15, 28, 39, .8);
        color: #dcebf1;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 4px;
        justify-content: center;
        min-height: 72px;
        padding: 8px;
        text-align: center;
        transition: background .18s ease, color .18s ease;
    }

    .football-pick-option:last-child > span {
        border-right: 0;
    }

    .football-pick-option input:checked + span {
        background: #10aee8;
        color: #ffffff;
    }

    .football-pick-option input:focus + span {
        box-shadow: inset 0 0 0 3px rgba(255, 255, 255, .35);
    }

    .football-pick-option input:disabled + span {
        cursor: not-allowed;
        opacity: .52;
    }

    .football-pick-label {
        font-size: .82rem;
        font-weight: 800;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .football-pick-team {
        font-size: .84rem;
        font-weight: 600;
        line-height: 1.2;
    }

    .prediction-slip {
        background: #ffffff;
        border-radius: 8px;
        color: #111820;
        overflow: hidden;
        position: sticky;
        top: 14px;
    }

    .prediction-slip-header {
        align-items: center;
        background: #10aee8;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        padding: 13px 14px;
    }

    .prediction-slip-header h2 {
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: 0;
        margin: 0;
    }

    .prediction-slip-count {
        background: #ffc020;
        border-radius: 999px;
        color: #101820;
        font-weight: 800;
        min-width: 26px;
        padding: 2px 8px;
        text-align: center;
    }

    .prediction-slip-body {
        max-height: 410px;
        overflow-y: auto;
    }

    .prediction-slip-row {
        border-bottom: 1px dashed #d7dce0;
        padding: 13px 14px;
    }

    .prediction-slip-title {
        color: #111820;
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 8px;
    }

    .prediction-slip-pick {
        color: #2c3740;
        font-weight: 600;
        margin: 0;
    }

    .prediction-slip-empty {
        color: #6b7780;
        padding: 28px 14px;
        text-align: center;
    }

    .prediction-slip-summary {
        border-top: 1px solid #e4e8eb;
        padding: 14px;
    }

    .prediction-slip-summary dl {
        display: grid;
        gap: 8px 12px;
        grid-template-columns: 1fr auto;
        margin: 0 0 14px;
    }

    .prediction-slip-summary dt,
    .prediction-slip-summary dd {
        margin: 0;
    }

    .prediction-slip-actions {
        background: #0f5365;
        display: grid;
        gap: 10px;
        padding: 14px;
    }

    .prediction-history-card {
        background: #ffffff;
        border-radius: 8px;
        color: #15202b;
        overflow: hidden;
    }

    @media (max-width: 991px) {
        .football-shell {
            grid-template-columns: 1fr;
        }

        .prediction-slip {
            position: static;
        }
    }

    @media (max-width: 576px) {
        .football-prediction-page {
            padding: 12px !important;
        }

        .football-prediction-header {
            padding: 14px;
        }

        .football-pick-option > span {
            min-height: 60px;
            padding: 8px 6px;
        }

        .football-pick-team {
            display: none;
        }
    }
</style>

<div class="content-wrapper p-4 football-prediction-page">
    <div class="football-prediction-header d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Football Predictions</h1>
            <p class="text-muted mb-0">Pick Home, Draw, or Away before each match closes.</p>
        </div>
        <a href="{{ route('account.coupons') }}" class="btn btn-outline-light">My Coupons</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @error('predictions')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @php
        $hasOpenMatches = $availableMatches->contains(fn ($match) => $match->predictionsAreOpen());
    @endphp

    <form action="{{ route('account.football-predictions.store-many') }}" method="POST" id="predictionSlipForm">
        @csrf
        <div class="football-shell">
            <div>
                @forelse($availableMatches as $match)
                    @php
                        $existing = $match->predictions->first();
                        $open = $match->predictionsAreOpen();
                        $selectedPick = old('predictions.' . $match->id, $existing->prediction_pick ?? null);
                        $pickLabels = \App\Models\FootballPrediction::pickLabels();
                    @endphp
                    <article class="football-match-card"
                        data-match-card
                        data-match-id="{{ $match->id }}"
                        data-match-title="{{ $match->home_team }} - {{ $match->away_team }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="football-match-meta">
                                <span class="football-match-number">{{ $loop->iteration }}</span>
                                <span>{{ $match->match_date?->format('D d/m/y') }} - {{ $match->kickoff_time ?: 'TBA' }}</span>
                                <span>|</span>
                                <span>{{ $match->competition ?: 'Football' }}</span>
                            </div>
                            <span class="badge badge-{{ $open ? 'success' : 'secondary' }}">{{ $open ? 'Open' : 'Closed' }}</span>
                        </div>

                        <div class="football-teams">
                            <div>{{ $match->home_team }}</div>
                            <div>{{ $match->away_team }}</div>
                        </div>

                        <div class="football-pick-grid" role="radiogroup" aria-label="Prediction for {{ $match->home_team }} versus {{ $match->away_team }}">
                            <label class="football-pick-option">
                                <input type="radio"
                                    name="predictions[{{ $match->id }}]"
                                    value="{{ \App\Models\FootballPrediction::PICK_HOME }}"
                                    data-pick-radio
                                    data-match-id="{{ $match->id }}"
                                    data-pick-label="{{ $pickLabels[\App\Models\FootballPrediction::PICK_HOME] }}"
                                    @checked($selectedPick === \App\Models\FootballPrediction::PICK_HOME)
                                    {{ $open ? '' : 'disabled' }}>
                                <span>
                                    <span class="football-pick-label">Home</span>
                                    <span class="football-pick-team">{{ $match->home_team }}</span>
                                </span>
                            </label>
                            <label class="football-pick-option">
                                <input type="radio"
                                    name="predictions[{{ $match->id }}]"
                                    value="{{ \App\Models\FootballPrediction::PICK_DRAW }}"
                                    data-pick-radio
                                    data-match-id="{{ $match->id }}"
                                    data-pick-label="{{ $pickLabels[\App\Models\FootballPrediction::PICK_DRAW] }}"
                                    @checked($selectedPick === \App\Models\FootballPrediction::PICK_DRAW)
                                    {{ $open ? '' : 'disabled' }}>
                                <span>
                                    <span class="football-pick-label">Draw</span>
                                    <span class="football-pick-team">Level</span>
                                </span>
                            </label>
                            <label class="football-pick-option">
                                <input type="radio"
                                    name="predictions[{{ $match->id }}]"
                                    value="{{ \App\Models\FootballPrediction::PICK_AWAY }}"
                                    data-pick-radio
                                    data-match-id="{{ $match->id }}"
                                    data-pick-label="{{ $pickLabels[\App\Models\FootballPrediction::PICK_AWAY] }}"
                                    @checked($selectedPick === \App\Models\FootballPrediction::PICK_AWAY)
                                    {{ $open ? '' : 'disabled' }}>
                                <span>
                                    <span class="football-pick-label">Away</span>
                                    <span class="football-pick-team">{{ $match->away_team }}</span>
                                </span>
                            </label>
                        </div>

                        @error('predictions.' . $match->id)
                            <div class="text-warning mt-2">{{ $message }}</div>
                        @enderror
                        @if($existing && ! $existing->prediction_pick)
                            <div class="text-muted mt-2">Saved exact score: {{ $existing->predictionLabel() }}</div>
                        @endif
                    </article>
                @empty
                    <div class="football-match-card text-center text-muted py-5">No football prediction matches are available right now.</div>
                @endforelse
            </div>

            <aside class="prediction-slip" aria-label="Prediction slip">
                <div class="prediction-slip-header">
                    <h2><i class="fas fa-receipt mr-2"></i>Prediction Slip</h2>
                    <span class="prediction-slip-count" id="predictionSlipBadge">0</span>
                </div>
                <div class="prediction-slip-body" id="predictionSlipSelections">
                    <div class="prediction-slip-empty">No picks selected.</div>
                </div>
                <div class="prediction-slip-summary">
                    <dl>
                        <dt>Combinations:</dt>
                        <dd id="predictionSlipCombinations">0</dd>
                        <dt>Selected:</dt>
                        <dd id="predictionSlipSelected">-</dd>
                    </dl>
                    <button class="btn btn-primary btn-block font-weight-bold" type="submit" @if(! $hasOpenMatches) disabled @endif>
                        Save Predictions
                    </button>
                </div>
                <div class="prediction-slip-actions">
                    <button class="btn btn-outline-light font-weight-bold" type="button" id="clearPredictionSlip">Remove All</button>
                </div>
            </aside>
        </div>
    </form>

    <div class="prediction-history-card mt-4">
        <div class="card-header bg-white">
            <h2 class="h5 mb-0">Prediction History</h2>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Match</th>
                        <th>Your Pick</th>
                        <th>Actual Result</th>
                        <th>Status</th>
                        <th>Match Date</th>
                        <th>Reward</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($predictions as $prediction)
                        @php
                            $match = $prediction->footballMatch;
                            $entitlement = $entitlements->get($match->id);
                        @endphp
                        <tr>
                            <td>{{ $match->home_team }} vs {{ $match->away_team }}</td>
                            <td>{{ $prediction->predictionLabel() }}</td>
                            <td>{{ $match->resultLabel() }}</td>
                            <td>{{ ucfirst($prediction->status) }}</td>
                            <td>{{ $match->match_date?->format('d M Y') }}</td>
                            <td>
                                @if($entitlement)
                                    <strong>{{ $entitlement->coupon->code }}</strong>
                                    <span class="badge badge-{{ $entitlement->redeemed_at ? 'secondary' : 'success' }}">
                                        {{ $entitlement->redeemed_at ? 'Redeemed' : 'Available' }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No predictions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var radios = Array.prototype.slice.call(document.querySelectorAll('[data-pick-radio]'));
    var slip = document.getElementById('predictionSlipSelections');
    var badge = document.getElementById('predictionSlipBadge');
    var combinations = document.getElementById('predictionSlipCombinations');
    var selected = document.getElementById('predictionSlipSelected');
    var clearButton = document.getElementById('clearPredictionSlip');

    var escapeHtml = function (value) {
        return String(value).replace(/[&<>"']/g, function (character) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[character];
        });
    };

    var refreshSlip = function () {
        var checked = radios.filter(function (radio) {
            return radio.checked && !radio.disabled;
        });

        badge.textContent = checked.length;
        combinations.textContent = checked.length;
        selected.textContent = checked.length ? checked.length + ' pick' + (checked.length === 1 ? '' : 's') : '-';

        if (!checked.length) {
            slip.innerHTML = '<div class="prediction-slip-empty">No picks selected.</div>';
            return;
        }

        slip.innerHTML = checked.map(function (radio, index) {
            var card = document.querySelector('[data-match-card][data-match-id="' + radio.dataset.matchId + '"]');
            var title = card ? card.dataset.matchTitle : 'Match';
            var pick = radio.dataset.pickLabel || radio.value;

            return [
                '<div class="prediction-slip-row">',
                    '<div class="prediction-slip-title">',
                        '<span class="mr-2">' + (index + 1) + '</span>',
                        '<i class="fas fa-futbol mr-1"></i>',
                        escapeHtml(title),
                    '</div>',
                    '<p class="prediction-slip-pick">Your Pick: <strong>' + escapeHtml(pick) + '</strong></p>',
                '</div>'
            ].join('');
        }).join('');
    };

    radios.forEach(function (radio) {
        radio.addEventListener('change', refreshSlip);
    });

    clearButton.addEventListener('click', function () {
        radios.forEach(function (radio) {
            if (!radio.disabled) {
                radio.checked = false;
            }
        });
        refreshSlip();
    });

    refreshSlip();
});
</script>
@endpush
