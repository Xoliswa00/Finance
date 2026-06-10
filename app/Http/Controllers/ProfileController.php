<?php

namespace App\Http\Controllers;

use App\Models\cards;
use App\Models\category;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user    = auth()->user();
        $cards   = cards::where('Added_by', auth()->id())->get();
        $balance = category::select('Balance')->where('category', 'Bank (Dr)')->where('Added_by', auth()->id())->first();
        $CreditB = category::select('Balance')->where('category', 'Credit Card')->where('Added_by', auth()->id())->first();
        return view('Profile.index', compact('user', 'cards', 'balance', 'CreditB'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'Surname'  => 'required|string|max:255',
            'Mobile'   => 'required|string|max:30',
            'Location' => 'required|string|max:255',
        ]);

        auth()->user()->update([
            'name'     => $request->name,
            'Surname'  => $request->Surname,
            'Mobile'   => $request->Mobile,
            'Location' => $request->Location,
        ]);

        return back()->with('success', 'Profile updated successfully.');
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
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
