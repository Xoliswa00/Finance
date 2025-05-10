<?php

namespace App\Http\Controllers;

use App\Models\cards;
use App\Models\Holding;
use App\models\category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HoldingController extends Controller
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
        $category = Category::where("Added_by", "=", auth()->user()->id)
        ->where('category', 'LIKE', '%Master :%')
        ->get();
                $cards=cards::all()->where("Added_by","=",auth()->user()->id);
        $action="No";
        return view('Master.Holding',compact('category','cards','action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $transaction = new Holding;

        $transaction->Action = $request->input('Action');
        $transaction->category = $request->input('category');
        $transaction->Method = $request->input('Method');
        $transaction->description = $request->input('description');
        $transaction->amount = $request->input('amount');
        $transaction->bill_date = $request->input('bill_date');
        $transaction->Invoice_slip = $request->input('Invoice_slip');
      
        $transaction->added_by = auth()->user()->id;
        
        $transaction->save();

        return redirect('/MasterIndex')->with('success', 'Form submitted successfully');


    }

    /**
     * Display the specified resource.
     */
    public function show(Holding $holding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Holding $holding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
     
        $holding= Holding::findorfail($request->id);
        $holding->Status='Paid'; 
        $holding->save();

        $transaction= new TransactionController();
        $transaction->store($request);
        return redirect('/MasterIndex')->with('success','Transaction updated Successfully!');

        
    
    
    
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holding $holding)
    {
        //
    }
}
