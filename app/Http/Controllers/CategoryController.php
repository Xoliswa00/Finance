<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Nature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = category::where('Added_by', Auth::id())
            ->orderBy('Nature')
            ->orderBy('category')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $natures = Nature::all();
        return view('categories.create', compact('natures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => [
                'required',
                'max:500',
                Rule::unique('categories')->where(fn($q) => $q->where('Added_by', Auth::id())),
            ],
            'Nature' => 'required',
        ]);

        Category::create([
            'category' => $request->category,
            'Nature'   => $request->Nature,
            'Added_by' => Auth::id(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        abort_if($category->Added_by !== Auth::id(), 403);
        $natures = Nature::all();
        return view('categories.edit', compact('category', 'natures'));
    }

    public function update(Request $request, Category $category)
    {
        abort_if($category->Added_by !== Auth::id(), 403);

        $request->validate([
            'category' => [
                'required',
                'max:500',
                Rule::unique('categories')->where(fn($q) => $q->where('Added_by', Auth::id()))->ignore($category->id),
            ],
            'Nature' => 'required',
        ]);

        $category->update([
            'category' => $request->category,
            'Nature'   => $request->Nature,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        abort_if($category->Added_by !== Auth::id(), 403);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
