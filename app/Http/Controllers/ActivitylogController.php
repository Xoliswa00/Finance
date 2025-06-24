<?php

namespace App\Http\Controllers;

use App\Models\Activitylog;
use Illuminate\Http\Request;

class ActivitylogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Activitylog $activitylog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activitylog $activitylog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activitylog $activitylog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activitylog $activitylog)
    {
        //
    }
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
