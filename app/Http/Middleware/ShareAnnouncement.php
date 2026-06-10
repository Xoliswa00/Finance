<?php

namespace App\Http\Middleware;

use App\Models\Announcement;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ShareAnnouncement
{
    public function handle(Request $request, Closure $next): Response
    {
        $announcement = Cache::remember('active_announcement', 60, function () {
            return Announcement::active()->latest()->first();
        });

        view()->share('activeAnnouncement', $announcement);

        return $next($request);
    }
}
