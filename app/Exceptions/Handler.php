<?php

namespace App\Exceptions;

use App\Models\ErrorTicket;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception): void
    {
        // Resolve HTTP status code; non-HTTP exceptions count as 500
        $status = $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : 500;

        // ── Log everything to the Laravel log file ──────────────────────
        // Skip validation (user input errors) — they're not bugs
        if (!($exception instanceof ValidationException)) {
            $logContext = [
                'url'    => request()->fullUrl(),
                'method' => request()->method(),
                'ip'     => request()->ip(),
                'user'   => Auth::check() ? Auth::id() . ' (' . Auth::user()->email . ')' : 'guest',
            ];

            if ($status >= 500) {
                Log::error("[{$status}] " . $exception->getMessage(), $logContext + ['exception' => $exception]);
            } elseif ($status >= 400) {
                Log::warning("[{$status}] " . $exception->getMessage(), $logContext);
            } else {
                Log::info("[{$status}] " . $exception->getMessage(), $logContext);
            }
        }

        // ── Persist server errors (500+) to error_tickets table ─────────
        // 4xx are expected user/client errors — no point polluting the DB
        if ($status >= 500) {
            try {
                if (Schema::hasTable('error_tickets')) {
                    ErrorTicket::create([
                        'user_id'    => Auth::check() ? Auth::id() : null,
                        'error_type' => get_class($exception),
                        'message'    => $exception->getMessage(),
                        'file'       => $exception->getFile(),
                        'line'       => $exception->getLine(),
                        'url'        => request()->fullUrl(),
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);
                }
            } catch (Throwable $e) {
                Log::error('Failed to persist error ticket: ' . $e->getMessage());
            }
        }

        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            $status = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;
            return response()->json(['error' => 'Something went wrong. Please try again later.'], $status);
        }

        return parent::render($request, $exception);
    }
}
