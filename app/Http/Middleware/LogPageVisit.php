<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Activitylog;
use Illuminate\Support\Facades\Auth;

class LogPageVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::id();
        if ($userId !== null) {
        Activitylog::create([
            'Added_by' => Auth::id(),
            'page_visited' => $request->path(),
        ]);
        }else {
            // Log the page visit for guest users
            $guestId = $this->getGuestIdentifier($request);
            Activitylog::create([
                'Added_by' => $guestId,
                'page_visited' => $request->path(),
            ]);
        }
        return $next($request);
    }
    private function getGuestIdentifier(Request $request)
    {
        $guestId = $request->session()->get('guest_id');

        if (!$guestId) {
            // Generate a unique identifier for the guest
            $guestId = uniqid('guest_', true);

            // Store the identifier in the session for subsequent requests
            $request->session()->put('guest_id', $guestId);
        }

        return $guestId;
    }
}
