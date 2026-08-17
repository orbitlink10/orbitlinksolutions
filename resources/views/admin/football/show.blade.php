@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">{{ $match->home_team }} vs {{ $match->away_team }}</h1>
            <p class="text-muted mb-0">{{ $match->competition ?: 'Football promotion' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.football-matches.index') }}" class="btn btn-outline-secondary mr-2">Back</a>
            @if($match->status !== 'finished')
                <a href="{{ route('admin.football-matches.edit', $match) }}" class="btn btn-outline-primary mr-2">Edit</a>
                <a href="{{ route('admin.football-matches.result', $match) }}" class="btn btn-primary">Enter Result</a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <dl class="mb-0">
                        <dt>Abbreviations</dt>
                        <dd>{{ $match->home_abbreviation }} / {{ $match->away_abbreviation }}</dd>
                        <dt>Kickoff</dt>
                        <dd>{{ $match->match_date?->format('d M Y') }} {{ $match->kickoff_time }}</dd>
                        <dt>Prediction Closing Time</dt>
                        <dd>{{ $match->prediction_closes_at?->format('d M Y H:i') }}</dd>
                        <dt>Status</dt>
                        <dd>{{ ucwords(str_replace('_', ' ', $match->status)) }}</dd>
                        <dt>Result</dt>
                        <dd>{{ $match->resultLabel() }}</dd>
                        <dt>Coupon</dt>
                        <dd>{{ $match->coupon->code ?? '-' }}</dd>
                        <dt>Reward</dt>
                        <dd>
                            @if($match->coupon_discount_type === 'percentage')
                                {{ rtrim(rtrim(number_format($match->coupon_discount_value, 2), '0'), '.') }}%
                            @else
                                KES {{ number_format($match->coupon_discount_value, 2) }}
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0">Predictions</h3>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Prediction</th>
                                <th>Status</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($match->predictions as $prediction)
                                <tr>
                                    <td>{{ $prediction->user->name ?? '-' }}</td>
                                    <td>{{ $prediction->home_score }}-{{ $prediction->away_score }}</td>
                                    <td>{{ ucfirst($prediction->status) }}</td>
                                    <td>{{ $prediction->created_at?->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No predictions yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0">Reward Entitlements</h3>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($match->entitlements as $entitlement)
                                <tr>
                                    <td>{{ $entitlement->user->name ?? '-' }}</td>
                                    <td>{{ $entitlement->redeemed_at ? 'Redeemed' : 'Available' }}</td>
                                    <td>{{ $entitlement->order_id ? '#'.$entitlement->order_id : '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">No rewards generated yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
