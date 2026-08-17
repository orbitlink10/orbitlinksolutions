@php
    $coupon = $coupon ?? null;
    $isEdit = (bool) $coupon?->exists;
    $action = $isEdit ? route('admin.coupons.update', $coupon) : route('admin.coupons.store');
@endphp

<form action="{{ $action }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="code">Coupon Code</label>
                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code ?? '') }}" {{ $coupon?->isFootballCoupon() ? 'readonly' : '' }} required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="discount_type">Discount Type</label>
                        <select name="discount_type" id="discount_type" class="form-control @error('discount_type') is-invalid @enderror" required>
                            <option value="percentage" {{ old('discount_type', $coupon->discount_type ?? '') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="fixed" {{ old('discount_type', $coupon->discount_type ?? '') === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        </select>
                        @error('discount_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="discount_value">Discount Value</label>
                        <input type="number" step="0.01" min="0" name="discount_value" id="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value', $coupon->discount_value ?? '') }}" required>
                        @error('discount_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $coupon->description ?? '') }}">
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="usage_limit">Usage Limit</label>
                        <input type="number" min="1" name="usage_limit" id="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit', $coupon->usage_limit ?? 1) }}" {{ $coupon?->isFootballCoupon() ? 'readonly' : '' }}>
                        @error('usage_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="expires_at">Expiry Date</label>
                        <input type="datetime-local" name="expires_at" id="expires_at" class="form-control @error('expires_at') is-invalid @enderror" value="{{ old('expires_at', optional($coupon?->expires_at)->format('Y-m-d\TH:i')) }}">
                        @error('expires_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <input type="hidden" name="is_active" value="0">
                    <div class="custom-control custom-switch mt-3">
                        <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active" {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update Coupon' : 'Create Coupon' }}</button>
        </div>
    </div>
</form>
