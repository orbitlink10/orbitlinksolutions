<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, \Illuminate\Http\Request $request) {
            if (! $request->is('api/zivo/*')) {
                return null;
            }
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json(['message' => 'Invalid request.', 'errors' => $e->errors()], 422)
                    ->header('Cache-Control', 'private, no-store');
            }
            $status = $e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface ? $e->getStatusCode() : 500;
            $headers = $e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface ? $e->getHeaders() : [];
            return response()->json(['message' => \Symfony\Component\HttpFoundation\Response::$statusTexts[$status] ?? 'Request failed.'], $status, $headers)
                ->header('Cache-Control', 'private, no-store');
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
