<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Master_X;
use App\Models\MasterX;
use App\Models\Nature;
use App\Models\X_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class XItemController extends Controller
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
        $Section=X_item::select('x_items.*')->join('Master_X','Master_X.id',"=","x_items.Master")->where('Added_by','=',auth()->user()->id)->get();
        $balance=X_item::select( 'Master',DB::raw( "sum(x_items.Budget) as Budget" ), DB::raw('sum(x_items.Actual) as Actual' ))->join('Master_X','Master_X.id',"=",'x_items.Master')->groupby('master')->where('Added_by','=',auth()->user()->id)->get();
   
    
        $master= Master_X::where('Added_by','=',auth()->user()->id)->get();
        $masters= Master_X::where('Added_by','=',auth()->user()->id)->get();
       
        $natures = Nature::all();
        return view('Master.create', compact('natures','master','masters','Section','balance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
      
        // Validate the request
        $validatedData = $request->validate([
            'Section' => 'required|string|max:250',
            'Description' => 'required|string|max:500',
            'Nature' => 'required|string|max:200',
            'Budget' => 'required|numeric',
      
            'Start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'Status' => 'required|in:Not Started,Delayed,In-progress,Completed',
            'Progress' => 'required|integer',
            'master_id' => 'required|exists:master_x,id'
        ]);

        // Create a new XItem
        $section = new X_item();
        $section->section=$request->input('Section');
        $section->description=$request->input('Description');
        $section->nature=$request->input('Nature');
        $section->budget=$request->input('Budget');
        $section->start_date=$request->input('Start_date');
        $section->end_date=$request->input('end_date');
        $section->status=$request->input('Status');
        $section->progress=$request->input('Progress');
        $section->Master=$request->input('master_id');
        $section->save();



      


        $category = new category();
        $category->category ="Master : ". $request->input('Section');
        
        $category->Nature = $request->input('Nature');


        $category->Added_by=Auth::id();
        $category->save();

        $section= X_item::SELECT('sum(Budget) as budget')->WHERE('Master','=',$request->input('master_id'));
        $master= Master_X::findorfail($request->input('master_id'));
        if (!is_null($master)){
            if(($master->budget-$master->actual)<=$request->budget or $section->budget>=$master->budget){
                $master->update(['budget'=>$master->budget+$request->budget]);

            }
        }



        return redirect()->route('section')->with('success', 'X Item created successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(X_item $x_item)
    {
        //
        $section = X_item::findorfail($x_item);

        return view('Master.update',compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $section = X_item::findorfail($id);
        

        return view('Master.update',compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
     
          // Validate the request data
       
    $request->validate([
        'Section' => 'required|max:250',
        'Description' => 'required|max:500',
        'Nature' => 'required|max:200',
        'Budget' => 'required|numeric',
       
        'Start_date' => 'required|date',
        'end_date' => 'required|date',
        'Status' => 'required',
        'Progress' => 'required|numeric',
    ]);

    // Find the x_item by ID
  
    $x_item = X_item::findorfail($request->id);

    // Check if the x_item exists
    if (!$x_item) {
        return redirect()->route('section')->with('error', 'x_item not found.');
    }

    // Update the x_item
    $x_item->Section = $request->Section;
    $x_item->Description = $request->Description;
    $x_item->Nature = $request->Nature;
    $x_item->Budget = $request->Budget;

    $x_item->Start_date = $request->Start_date;
    $x_item->end_date = $request->end_date;
    $x_item->Status = $request->Status;
    $x_item->Progress = $request->Progress;
    
    $x_item->save();
  
    $section=  DB::table("x_items")
    ->select(DB::raw("SUM(Budget) as budget"))
    ->where('Master', $request->master)
    ->first();

 
    $master= Master_X::findorfail($request->master);
   
    if (!is_null($master)){
      
        if(($master->budget-$master->actual)<=$request->budget or $section->budget>=$master->budget){
           
            $master->Budget=$section->budget-$master->budget;
            $master->save();

        }
    }

    return redirect()->route('section')->with('success', 'x_item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the x_item by ID
        $x_item = X_item::find($id);
    
        // Check if the x_item exists
        if (!$x_item) {
            return redirect()->route('section')->with('error', 'x_item not found.');
        }
    
        // Delete the x_item
        $x_item->Status="Deleted";
        $x_item->save();
    
        return redirect()->route('master.index')->with('success', 'x_item deleted successfully.');
    }
    
}
