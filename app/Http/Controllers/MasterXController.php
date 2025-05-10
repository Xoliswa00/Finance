<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Master_X;
use App\Models\MasterX;
use App\Models\Nature;
use App\Models\X_item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterXController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $Section=X_item::select('x_items.*')->join('Master_X','Master_X.id',"=","x_items.Master")->where('Added_by','=',auth()->user()->id)->get();
        $balance=X_item::select( 'Master',DB::raw( "sum(x_items.Budget) as Budget" ), DB::raw('sum(x_items.Actual) as Actual' ))->join('Master_X','Master_X.id',"=",'x_items.Master')->groupby('master')->where('Added_by','=',auth()->user()->id)->get();
   
    
        $master= Master_X::where('Added_by','=',auth()->user()->id)->get();
        $masters= Master_X::where('Added_by','=',auth()->user()->id)->get();

        return view('Master.index',compact('master','masters','Section','balance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
        return view('Master.MasterCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            // Validate the request
            $validatedData = $request->validate([
                'Name' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'Start_date' => 'required|date',
                'end_date' => 'required|date',
               
                'Budget' => 'required',
                'progress' => 'required|numeric',
           
            ]);
    
            // Create a new MasterX

            $master = new Master_X();
            $master->name=  $request['Name'];
            $master->description=  $request['description'];
          
                    $master->start_date=$request['Start_date'];
                    $master->end_date =$request['end_date'] ;
                    $master->budget=  $request['Budget'];
                    $master->progress=  $request['progress'];
                    $master->Added_by=auth()->user()->id;

            $master->save();
    
            return redirect()->route('section')->with('success', 'MasterX created successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $transactions = DB::table('transactions')
        ->select('transactions.*', 'x_items.Section', 'x_items.id', 'x_items.Master')
        ->join('categories', 'transactions.Category', '=', 'categories.id')
        ->join('x_items', function ($join) {
            $join->on('categories.category', 'like', DB::raw("CONCAT('Master : ', x_items.Section)"));
        })
        ->where('x_items.id', '=', $id)
        ->get();
        $holding = DB::table('holdings')
        ->select('holdings.*')
        ->join('categories', 'holdings.Category', '=', 'categories.id')
        ->join('x_items', function ($join) {
            $join->on('categories.category', 'like', DB::raw("CONCAT('Master : ', x_items.Section)"));
        })
        ->where('x_items.id', '=', $id)
        ->get();


        $sum = DB::table('holdings')
        ->select(DB::raw("sum(holdings.Amount) as total"))
        ->join('categories', 'holdings.Category', '=', 'categories.id')
        ->join('x_items', function ($join) {
            $join->on('categories.category', 'like', DB::raw("CONCAT('Master : ', x_items.Section)"));
        })
        ->where('x_items.id', '=', $id)
        ->where('holdings.Status', '=', "holding")
        ->get();




       
    $Section = X_item::where('id', $id)->get();
    return view('Master.Sections', compact('transactions','holding', 'Section','sum'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterX $masterX)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterX $masterX)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterX $masterX)
    {
        //
    }
}
