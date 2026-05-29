<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $cacheKey = 'last_seen_' . $userId;

            if (!cache()->has($cacheKey)) {
                \App\Models\User::where('id', $userId)->update(['last_seen' => now()]);
                cache()->put($cacheKey, true, now()->addMinutes(2));
            }
        }

        return $next($request);
    }
}
