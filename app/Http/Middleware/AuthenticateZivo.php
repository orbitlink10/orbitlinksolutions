<?php

namespace App\Http\Middleware;

use App\Models\ZivoApiKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AuthenticateZivo
{
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        $localHttp = app()->environment(['local', 'testing']) && config('zivo.allow_local_http');
        if (! $request->secure() && ! $localHttp) {
            return $this->error('HTTPS is required.', 403);
        }

        $token = $request->bearerToken();
        $key = is_string($token) && preg_match('/^zivo_[a-f0-9]{64}$/D', $token)
            ? ZivoApiKey::where('key_hash', hash('sha256', $token))
                ->where('store_id', config('zivo.store_id'))
                ->whereNull('revoked_at')
                ->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>', now()))
                ->first()
            : null;

        if (! $key) {
            return $this->error('Invalid or expired API key.', 401)
                ->header('WWW-Authenticate', 'Bearer');
        }

        $limit = max(1, (int) config('zivo.rate_limit', 60));
        $bucket = 'zivo:store:'.$key->store_id;
        if (RateLimiter::tooManyAttempts($bucket, $limit)) {
            return $this->error('Rate limit exceeded.', 429)
                ->header('Retry-After', RateLimiter::availableIn($bucket))
                ->header('X-RateLimit-Limit', $limit)
                ->header('X-RateLimit-Remaining', 0);
        }
        RateLimiter::hit($bucket, 60);

        // This key never authenticates a User or grants access to other API routes.
        return $next($request)
            ->header('Cache-Control', 'private, no-store')
            ->header('X-RateLimit-Limit', $limit)
            ->header('X-RateLimit-Remaining', max(0, $limit - RateLimiter::attempts($bucket)));
    }

    private function error(string $message, int $status)
    {
        return response()->json(['message' => $message], $status)
            ->header('Cache-Control', 'private, no-store');
    }
}
