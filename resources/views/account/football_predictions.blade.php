@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Football Predictions</h1>
            <p class="text-muted mb-0">Submit exact-score predictions before the closing time.</p>
        </div>
        <a href="{{ route('account.coupons') }}" class="btn btn-outline-primary">My Coupons</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @forelse($availableMatches as $match)
            @php
                $existing = $match->predictions->first();
                $open = $match->predictionsAreOpen();
            @endphp
            <div class="col-lg-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge badge-light">{{ $match->competition ?: 'Football' }}</span>
                                <h3 class="h5 mt-2 mb-1">{{ $match->home_team }}</h3>
                                <p class="text-muted mb-1">vs</p>
                                <h3 class="h5 mb-3">{{ $match->away_team }}</h3>
                            </div>
                            <span class="badge badge-{{ $open ? 'success' : 'secondary' }}">{{ $open ? 'Open' : 'Closed' }}</span>
                        </div>
                        <p class="mb-1"><strong>Kickoff:</strong> {{ $match->match_date?->format('d M Y') }} {{ $match->kickoff_time }}</p>
                        <p class="mb-3"><strong>Predictions close:</strong> {{ $match->prediction_closes_at?->format('d M Y H:i') }}</p>

                        <form action="{{ route('account.football-predictions.store', $match) }}" method="POST">
                            @csrf
                            <div class="row align-items-end">
                                <div class="col-5">
                                    <label>{{ $match->home_team }}</label>
                                    <input type="number" min="0" max="30" name="home_score" class="form-control" value="{{ old('home_score', $existing->home_score ?? 0) }}" {{ $open ? '' : 'disabled' }}>
                                </div>
                                <div class="col-2 text-center pb-2">-</div>
                                <div class="col-5">
                                    <label>{{ $match->away_team }}</label>
                                    <input type="number" min="0" max="30" name="away_score" class="form-control" value="{{ old('away_score', $existing->away_score ?? 0) }}" {{ $open ? '' : 'disabled' }}>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3" type="submit" {{ $open ? '' : 'disabled' }}>
                                {{ $existing ? 'Update Prediction' : 'Submit Prediction' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center text-muted py-5">No football prediction matches are available right now.</div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white">
            <h2 class="h5 mb-0">Prediction History</h2>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Match</th>
                        <th>Your Prediction</th>
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
                            <td>{{ $prediction->home_score }}-{{ $prediction->away_score }}</td>
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
