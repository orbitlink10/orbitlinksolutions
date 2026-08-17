@php
    $isEdit = $match->exists;
    $action = $isEdit ? route('admin.football-matches.update', $match) : route('admin.football-matches.store');
@endphp

<form action="{{ $action }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="home_team">Home Team</label>
                        <input type="text" name="home_team" id="home_team" class="form-control @error('home_team') is-invalid @enderror" value="{{ old('home_team', $match->home_team) }}" required>
                        @error('home_team')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="home_abbreviation">Home Abbrev.</label>
                        <input type="text" name="home_abbreviation" id="home_abbreviation" class="form-control text-uppercase @error('home_abbreviation') is-invalid @enderror" value="{{ old('home_abbreviation', $match->home_abbreviation) }}" maxlength="2" required>
                        @error('home_abbreviation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="away_team">Away Team</label>
                        <input type="text" name="away_team" id="away_team" class="form-control @error('away_team') is-invalid @enderror" value="{{ old('away_team', $match->away_team) }}" required>
                        @error('away_team')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="away_abbreviation">Away Abbrev.</label>
                        <input type="text" name="away_abbreviation" id="away_abbreviation" class="form-control text-uppercase @error('away_abbreviation') is-invalid @enderror" value="{{ old('away_abbreviation', $match->away_abbreviation) }}" maxlength="2" required>
                        @error('away_abbreviation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="competition">Competition</label>
                        <input type="text" name="competition" id="competition" class="form-control @error('competition') is-invalid @enderror" value="{{ old('competition', $match->competition) }}">
                        @error('competition')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="match_date">Match Date</label>
                        <input type="date" name="match_date" id="match_date" class="form-control @error('match_date') is-invalid @enderror" value="{{ old('match_date', optional($match->match_date)->format('Y-m-d')) }}" required>
                        @error('match_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="kickoff_time">Kickoff Time</label>
                        <input type="time" name="kickoff_time" id="kickoff_time" class="form-control @error('kickoff_time') is-invalid @enderror" value="{{ old('kickoff_time', $match->kickoff_time) }}">
                        @error('kickoff_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="prediction_closes_at">Prediction Closing Time</label>
                        <input type="datetime-local" name="prediction_closes_at" id="prediction_closes_at" class="form-control @error('prediction_closes_at') is-invalid @enderror" value="{{ old('prediction_closes_at', optional($match->prediction_closes_at)->format('Y-m-d\TH:i')) }}" required>
                        @error('prediction_closes_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            @foreach(['upcoming' => 'Upcoming', 'prediction_closed' => 'Prediction Closed', 'live' => 'Live', 'finished' => 'Finished', 'cancelled' => 'Cancelled'] as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $match->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <input type="hidden" name="is_published" value="0">
                    <div class="custom-control custom-switch mt-3">
                        <input type="checkbox" name="is_published" value="1" class="custom-control-input" id="is_published" {{ old('is_published', $match->is_published) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_published">Published</label>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="coupon_discount_type">Coupon Discount Type</label>
                        <select name="coupon_discount_type" id="coupon_discount_type" class="form-control">
                            <option value="percentage" {{ old('coupon_discount_type', $match->coupon_discount_type) === 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="fixed" {{ old('coupon_discount_type', $match->coupon_discount_type) === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="coupon_discount_value">Coupon Discount Value</label>
                        <input type="number" step="0.01" min="0" name="coupon_discount_value" id="coupon_discount_value" class="form-control @error('coupon_discount_value') is-invalid @enderror" value="{{ old('coupon_discount_value', $match->coupon_discount_value) }}" required>
                        @error('coupon_discount_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="coupon_description">Coupon Description</label>
                        <input type="text" name="coupon_description" id="coupon_description" class="form-control" value="{{ old('coupon_description', $match->coupon_description) }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between">
            <a href="{{ route('admin.football-matches.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Update Match' : 'Create Match' }}</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var map = {
        'MANCHESTER UNITED': 'MA',
        'ARSENAL': 'AR',
        'CHELSEA': 'CH',
        'LIVERPOOL': 'LI',
        'MANCHESTER CITY': 'MC',
        'TOTTENHAM': 'TO'
    };

    var suggest = function (value) {
        var normalized = (value || '').trim().replace(/\s+/g, ' ').toUpperCase();
        if (map[normalized]) {
            return map[normalized];
        }
        return normalized.replace(/[^A-Z0-9]/g, '').substring(0, 2).padEnd(2, 'X');
    };

    var bindSuggestion = function (teamId, abbreviationId) {
        var team = document.getElementById(teamId);
        var abbreviation = document.getElementById(abbreviationId);
        if (!team || !abbreviation) {
            return;
        }
        abbreviation.addEventListener('input', function () {
            abbreviation.dataset.touched = '1';
            abbreviation.value = abbreviation.value.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 2);
        });
        team.addEventListener('input', function () {
            if (!abbreviation.dataset.touched || abbreviation.value.length < 2) {
                abbreviation.value = suggest(team.value);
            }
        });
    };

    bindSuggestion('home_team', 'home_abbreviation');
    bindSuggestion('away_team', 'away_abbreviation');
});
</script>
@endpush
