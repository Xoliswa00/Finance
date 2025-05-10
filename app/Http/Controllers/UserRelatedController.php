<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_Related;

class UserRelatedController extends Controller
{
    public function index()
    {
        
        return view('user_related.index');
    }

    public function create()
    {
        return view('user_related.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'Relation' => 'required|string|max:255',
            'id_user' => 'required|integer',
            'Added_by' => 'required|integer',
        ]);

        $userRelated = User_Related::create($validatedData);
        return redirect()->route('user_related.index')->with('success', 'User related record created successfully');
    }

    public function edit(User_Related $userRelated)
    {
        return view('user_related.edit', compact('userRelated'));
    }

    public function update(Request $request, User_Related $userRelated)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'Relation' => 'required|string|max:255',
            'id_user' => 'required|integer',
            'Added_by' => 'required|integer',
        ]);

        $userRelated->update($validatedData);
        return redirect()->route('user_related.index')->with('success', 'User related record updated successfully');
    }

    public function destroy(User_Related $userRelated)
    {
        $userRelated->delete();
        return redirect()->route('user_related.index')->with('success', 'User related record deleted successfully');
    }
}
