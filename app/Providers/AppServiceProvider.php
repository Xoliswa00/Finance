<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Activitylog;
use Illuminate\Support\Facades\Log;
use App\Models\ErrorTicket;
use App\Observers\ErrorTicketObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
            public function boot()
        {
                ErrorTicket::observe(ErrorTicketObserver::class);

                    app()->terminating(function () {
            try {
                $request = request();

                if (
                    !$request->isMethod('get') ||
                    $request->ajax() ||
                    str_starts_with($request->path(), 'api') ||
                    $request->is('favicon.ico')
                ) return;

                 $user = Auth::user();

                $addedBy = $user ? $user->id : 'guest_' . session()->getId();

                session(['guest_id' => $addedBy]);

                if ($user) {
                    $user->update(['last_seen' => now()]);
                }

                \App\Models\Activitylog::create([
                    'Added_by'     => $addedBy,
                    'page_visited' => $request->path(),
                    'ip_address'   => $request->ip(),
                    'user_agent'   => $request->userAgent(),
                    'referrer'     => $request->headers->get('referer'),
                    'session_id'   => session()->getId(),
                ]);

                Log::info("✅ Activity tracked: {$request->path()} by {$addedBy}");

            } catch (\Throwable $e) {
                Log::error('❌ Logging failed in terminating hook: ' . $e->getMessage());
            }
        });


   
      // Capture fatal errors
    register_shutdown_function(function () {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            try {
                $request = request();
                \App\Models\ErrorTicket::create([
                    'error_type' => 'FatalError',
                    'message' => $error['message'],
                    'file' => $error['file'],
                    'line' => $error['line'],
                    'url' => optional($request)->fullUrl() ?? 'N/A',
                    'ip_address' => optional($request)->ip() ?? 'N/A',
                    'user_agent' => optional($request)->userAgent() ?? 'N/A',
                    'user_id' => optional(Auth::user())->id,
                ]);

                Log::error("🔥 Fatal error captured manually.");
            } catch (\Throwable $e) {
                Log::error("❌ Failed to log fatal error: " . $e->getMessage());
            }
        }
    });




        }


}