<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Models\ErrorTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ErrorTicketMail;
use Illuminate\Http\Request;



class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];



    use Throwable;

    public function report(Throwable $exception)
    {
      try {
        // Optional: Ignore some exceptions (e.g., 404s)
        if ($this->shouldntReport($exception)) {
            parent::report($exception);
            return;
        }

        // Custom DB logging
        ErrorTicket::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'level' => 'error',
            'message' => $exception->getMessage(),
            'trace' => substr($exception->getTraceAsString(), 0, 5000), // Optional truncate
            'url' => Request::fullUrl(),
            'method' => Request::method(),
            'ip' => Request::ip(),
        ]);
    } catch (\Throwable $e) {
        // Log to default Laravel log if DB logging fails
        Log::error('🛑 Failed to log to logs_main: ' . $e->getMessage());
    }
        parent::report($exception); // let Laravel do its default reporting too (e.g., Sentry, Bugsnag)
    }

    public function render($request, Throwable $exception)
{
    if ($request->expectsJson()) {
        return response()->json([
            'error' => 'Something went wrong. Please try again later.',
        ], 500);
    }

    return parent::render($request, $exception); // default error page
}








}


