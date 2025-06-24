<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Activitylog;



class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function logActivity(Request $request)
{
    $user = Auth::user();
    $addedBy = $user ? $user->id : session('guest_id', uniqid('guest_', true));
    session(['guest_id' => $addedBy]);

    Activitylog::create([
        'Added_by' => $addedBy,
        'page_visited' => $request->path(),
    ]);
}
}
