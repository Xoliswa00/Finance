<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
     
        $userId = Auth::id();

        if ($userId !==null) {
            $user = User::find(auth()->user()->id);
            $user->update(['last_seen' => now()]);
            Session::put('user_active', now());
        }

        return $next($request);
    }
}
