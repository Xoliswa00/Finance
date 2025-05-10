<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Nature;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $natures = Nature::all();
        return view('categories.create', compact('natures'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|unique:categories|max:500',
            'Nature' => 'required',
        ]);

        $category = new Category();
        $category->category = $validatedData['category'];
        $category->Nature = $validatedData['Nature'];
        $category->Added_by=Auth::id();
        $category->save();

        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        $natures = Nature::all();
        return view('categories.edit', compact('category', 'natures'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'category' => 'required|max:500|unique:categories,category,'.$category->id,
            'Nature' => 'required',
        ]);

        $category->category = $validatedData['category'];
        $category->Nature = $validatedData['Nature'];
        $category->save();

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
