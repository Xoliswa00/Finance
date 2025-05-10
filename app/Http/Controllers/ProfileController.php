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
        $user=User::all()->where("Added_by","=",auth()->user()->id);
        $cards=cards::all()->where("Added_by","=",auth()->user()->id);
        $balance=category::select('Balance')->where("category","=","Bank (Dr)")->where("Added_by", "=", auth()->user()->id)->get();
        $CreditB=category::select('Balance')->where("category","=","Credit Card")->where("Added_by", "=", auth()->user()->id)->get();
        return view('profile.index',compact('user','cards','balance','CreditB'));
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
