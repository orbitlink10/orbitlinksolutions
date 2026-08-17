@extends('layouts.appbar')

@section('content')
<div class="content-wrapper p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Football Promotions</h1>
            <p class="text-muted mb-0">Manage prediction matches and generated rewards.</p>
        </div>
        <a href="{{ route('admin.football-matches.create') }}" class="btn btn-primary">Create Match</a>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.football-matches.index') }}" class="row g-2">
                <div class="col-md-7">
                    <input type="search" name="search" class="form-control" placeholder="Search team or competition" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All statuses</option>
                        @foreach(['upcoming' => 'Upcoming', 'prediction_closed' => 'Prediction Closed', 'live' => 'Live', 'finished' => 'Finished', 'cancelled' => 'Cancelled'] as $value => $label)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Match</th>
                        <th>Competition</th>
                        <th>Kickoff</th>
                        <th>Prediction Deadline</th>
                        <th>Predictions</th>
                        <th>Status</th>
                        <th>Result</th>
                        <th>Generated Coupon</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matches as $match)
                        <tr>
                            <td><strong>{{ $match->home_team }}</strong> vs <strong>{{ $match->away_team }}</strong></td>
                            <td>{{ $match->competition ?: '-' }}</td>
                            <td>{{ $match->match_date?->format('d M Y') }} {{ $match->kickoff_time }}</td>
                            <td>{{ $match->prediction_closes_at?->format('d M Y H:i') }}</td>
                            <td>{{ $match->predictions_count }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $match->status)) }}</td>
                            <td>{{ $match->resultLabel() }}</td>
                            <td>{{ $match->coupon->code ?? '-' }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.football-matches.show', $match) }}" class="btn btn-sm btn-outline-info">View</a>
                                @if($match->status !== 'finished')
                                    <a href="{{ route('admin.football-matches.edit', $match) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <a href="{{ route('admin.football-matches.result', $match) }}" class="btn btn-sm btn-outline-primary">Result</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">No football matches found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $matches->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
