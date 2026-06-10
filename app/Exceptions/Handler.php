<?php

namespace App\Exceptions;

use App\Models\ErrorTicket;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        // Don't pollute the error log with 404s or other "expected" exceptions
        if ($this->shouldntReport($exception)) {
            parent::report($exception);
            return;
        }

        // Write to Laravel log first — guaranteed, even if DB is down
        Log::error($exception->getMessage(), [
            'url'        => request()->fullUrl(),
            'user_id'    => Auth::check() ? Auth::id() : null,
            'exception'  => $exception,
        ]);

        // Persist to error_tickets table if it exists
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
            $status = $exception instanceof HttpException ? $exception->getStatusCode() : 500;
            return response()->json(['error' => 'Something went wrong. Please try again later.'], $status);
        }

        // Let Laravel resolve the correct error view (404.blade.php, 500.blade.php, etc.)
        return parent::render($request, $exception);
    }
}
