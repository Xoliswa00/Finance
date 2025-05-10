<?php

namespace App\Http\Controllers;

use App\Models\cards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class CardController extends Controller
{
    public function index()
    {
        $cards = cards::all();
        return view('cards.index', compact('cards'));
    }

    public function create()
    {
        return view('cards.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Type' => 'required',
            'CardNumber' => 'required|numeric',
            'ExpiryDate' => 'required',
            'CVC' => 'required|numeric',
            'Cardholder' => 'required',
            'Status' => 'required',
        ]);

        $validatedData['Added_by'] = auth()->id();

        cards::create($validatedData);

        return redirect()->route('cards.index')->with('success', 'Card created successfully!');
    }

    public function show(cards $card)
    {
        return view('cards.show', compact('card'));
    }

    public function edit(cards $card)
    {
        return view('cards.edit', compact('card'));
    }

    public function update(Request $request, cards $card)
    {
        $validatedData = $request->validate([
            'Type' => 'required',
            'CardNumber' => 'required|numeric',
            'ExpiryDate' => 'required',
            'CVC' => 'required|numeric',
            'Cardholder' => 'required',
            'Status' => 'required',
        ]);

        $card->update($validatedData);

        return redirect()->route('cards.index')->with('success', 'Card updated successfully!');
    }

    public function destroy(cards $card)
    {
        $card->delete();

        return redirect()->route('cards.index')->with('success', 'Card deleted successfully!');
    }
}
