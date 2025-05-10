<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NatureController extends Controller
{
    public function index()
    {
        $natures = Nature::all();

        return view('natures.index', compact('natures'));
    }

    public function create()
    {
        return view('natures.creates');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Classification' => 'required|string|max:220',
            'Nature' => 'required|string|unique:natures|max:220',
        ]);

        $nature = new Nature;
        $nature->Classification = $request->Classification;
        $nature->Nature = $request->Nature;
        $nature->Added_by=Auth::id();
        $nature->save();

        return redirect()->route('natures.index')->with('success', 'Nature created successfully.');
    }

    public function edit(Nature $nature)
    {
        return view('natures.Modify', compact('nature'));
    }

    public function update(Request $request, Nature $nature)
    {
        $request->validate([
            'Classification' => 'required|string|max:220',
            'Nature' => 'required|string|unique:natures,Nature,'.$nature->id.'|max:220',
        ]);

        $nature->Classification = $request->Classification;
        $nature->Nature = $request->Nature;
        $nature->save();

        return redirect()->route('natures.index')->with('success', 'Nature updated successfully.');
    }

    public function destroy(Nature $nature)
    {
        $nature->delete();

        return redirect()->route('natures.index')->with('success', 'Nature deleted successfully.');
    }
}
