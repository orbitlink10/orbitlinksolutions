@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Publish Result</h1>
            <p class="text-muted mb-0">{{ $match->home_team }} vs {{ $match->away_team }}</p>
        </div>
        <a href="{{ route('admin.football-matches.show', $match) }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('admin.football-matches.publish-result', $match) }}" method="POST" class="card border-0 shadow-sm">
                @csrf
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-5">
                            <label for="home_score">{{ $match->home_team }}</label>
                            <input type="number" min="0" max="30" name="home_score" id="home_score" class="form-control form-control-lg @error('home_score') is-invalid @enderror" value="{{ old('home_score', $match->home_score) }}" required>
                            @error('home_score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-2 text-center pb-2">vs</div>
                        <div class="col-md-5">
                            <label for="away_score">{{ $match->away_team }}</label>
                            <input type="number" min="0" max="30" name="away_score" id="away_score" class="form-control form-control-lg @error('away_score') is-invalid @enderror" value="{{ old('away_score', $match->away_score) }}" required>
                            @error('away_score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="alert alert-info mt-4 mb-0">
                        <div><strong>Generated Coupon:</strong> <span id="generatedCoupon">-</span></div>
                        <div><strong>Discount:</strong>
                            @if($match->coupon_discount_type === 'percentage')
                                {{ rtrim(rtrim(number_format($match->coupon_discount_value, 2), '0'), '.') }}%
                            @else
                                KES {{ number_format($match->coupon_discount_value, 2) }}
                            @endif
                        </div>
                        <div><strong>Correct predictions:</strong> <span id="winnerCount">0</span> customer(s)</div>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Confirm & Publish</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var homeAbbr = @json($match->home_abbreviation);
    var awayAbbr = @json($match->away_abbreviation);
    var predictions = @json($match->predictions->map(fn ($prediction) => ['home' => $prediction->home_score, 'away' => $prediction->away_score])->values());
    var homeInput = document.getElementById('home_score');
    var awayInput = document.getElementById('away_score');
    var codeLabel = document.getElementById('generatedCoupon');
    var winnerLabel = document.getElementById('winnerCount');

    var refresh = function () {
        var home = parseInt(homeInput.value, 10);
        var away = parseInt(awayInput.value, 10);

        if (Number.isNaN(home) || Number.isNaN(away)) {
            codeLabel.textContent = '-';
            winnerLabel.textContent = '0';
            return;
        }

        codeLabel.textContent = (homeAbbr + home + awayAbbr + away).toUpperCase().replace(/[^A-Z0-9]/g, '');
        winnerLabel.textContent = predictions.filter(function (prediction) {
            return parseInt(prediction.home, 10) === home && parseInt(prediction.away, 10) === away;
        }).length;
    };

    homeInput.addEventListener('input', refresh);
    awayInput.addEventListener('input', refresh);
    refresh();
});
</script>
@endpush
