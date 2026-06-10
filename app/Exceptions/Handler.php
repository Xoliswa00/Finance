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
        // Resolve HTTP status; non-HTTP exceptions default to 500
        $status = $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : 500;

        // Skip validation — every bad form submit would create a ticket
        if ($exception instanceof ValidationException) {
            parent::report($exception);
            return;
        }

        $logContext = [
            'url'    => request()->fullUrl(),
            'method' => request()->method(),
            'ip'     => request()->ip(),
            'user'   => Auth::check() ? Auth::id() . ' (' . Auth::user()->email . ')' : 'guest',
        ];

        // ── Log file: all errors ─────────────────────────────────────────
        if ($status >= 500) {
            Log::error("[{$status}] " . $exception->getMessage(), $logContext + ['exception' => $exception]);
        } else {
            Log::warning("[{$status}] " . $exception->getMessage(), $logContext);
        }

        // ── error_tickets table: all errors ──────────────────────────────
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
