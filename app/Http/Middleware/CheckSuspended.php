<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspended
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        if ($user->isSuspended()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account has been suspended. Please contact support.']);
        }

        // Force logout: if admin triggered it after this session started
        if ($user->force_logout_at !== null) {
            $loggedInAt = $request->session()->get('logged_in_at', 0);
            if ($user->force_logout_at->timestamp > $loggedInAt) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')
                    ->with('status', 'You have been signed out by an administrator.');
            }
        }

        return $next($request);
    }
}
