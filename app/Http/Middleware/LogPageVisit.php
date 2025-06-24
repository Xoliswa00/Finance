<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Activitylog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogPageVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = auth()->id();

        if ($userId !== null) {
            $addedBy = $userId;
        } else {
            $addedBy = $this->getGuestIdentifier($request);
        }

        try {
            Activitylog::create([
                'Added_by' => $addedBy,
                'page_visited' => $request->path(),

            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log activity: ' . $e->getMessage());
        }

        return $next($request);
    }

    private function getGuestIdentifier(Request $request)
    {
        $guestId = $request->session()->get('guest_id');

        if (!$guestId) {
            $guestId = uniqid('guest_', true);
            $request->session()->put('guest_id', $guestId);
        }

        return $guestId;
    }
}
