<?php

namespace App\Http\Controllers;
use App\Models\Budget;
use App\Models\Budget_subitems;
use Illuminate\Http\Request;

class BudgetSubitems extends Controller
{
    
    public function index()
    {
        $subitems = Budget_subitems::all();
        return view('budget_subitems.index', compact('subitems'));
    }

    public function create()
    {
        $budgets = Budget::all();
        return view('budget_subitems.create', compact('budgets'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'budget_id' => 'required|exists:budgets,id',
            'Category' => 'required|max:200',
            'Description' => 'required|max:200',
            'Amount' => 'nullable|numeric',
            'Limit' => 'required|numeric',
            'due_date' => 'required|date',
            'Recurring' => 'required|in:Daily,Weekly,Monthly,Yearly',
            'SubItems' => 'required|in:Yes,No',
            'Priority' => 'required|in:High,Modarate,normal',
            'Status' => 'required|max:200'
        ]);

        $subitem = new Budget_subitems($validatedData);
        $subitem->save();

        return redirect()->route('budget_subitems.index');
    }

    public function edit(Budget_subitems $subitem)
    {
        $budgets = Budget::all();
        return view('budget_subitems.edit', compact('budgets', 'subitem'));
    }

    public function update(Request $request, Budget_subitems $subitem)
    {
        $validatedData = $request->validate([
            'budget_id' => 'required|exists:budgets,id',
            'Category' => 'required|max:200',
            'Description' => 'required|max:200',
            'Amount' => 'nullable|numeric',
            'Limit' => 'required|numeric',
            'due_date' => 'required|date',
            'Recurring' => 'required|in:Daily,Weekly,Monthly,Yearly',
            'SubItems' => 'required|in:Yes,No',
            'Priority' => 'required|in:High,Modarate,normal',
            'Status' => 'required|max:200'
        ]);

        $subitem->update($validatedData);

        return redirect()->route('budget_subitems.index');
    }

    public function destroy(Budget_subitems $subitem)
    {
        $subitem->delete();
        return redirect()->route('budget_subitems.index');
    }
}
