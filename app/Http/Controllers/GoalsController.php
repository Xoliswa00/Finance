<?php

namespace App\Http\Controllers;
use App\Models\cards;
use App\Models\category;
use Carbon\Carbon;
use App\Models\Goals;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination;
use illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View; 
use Illuminate\Database\Eloquent\Model;



class GoalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goals = Goals::where("Added_by", "=", auth()->user()->id)->where('Status',"=",'In-Progress')->orderBy('end_date', 'ASC')->Paginate(10);
      
        
     if ($goals->isEmpty()) {
            return view('Goals.Goals');
        } else {
            return view('goals.index', compact('goals'));
        }

       
    }
    



    public function Goals()
    {
        $goals = Goals::where("Added_by", "=", auth()->user()->id)->where('Status',"=",'In-Progress')
        ->orderBy('end_date', 'ASC')
      
        ->Paginate(10);
       

        return view('Goals.index', compact('goals'));
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('goals.create');
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'goal_category' => 'required',
            'target_amount' => 'required',
            'start_date' => 'required|date',

            'end_date' => 'required|date|after:start_date',
        ]);

       // Create budget object and save to database using model

        $Goals = new Goals([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'goal_category' => $request->input('goal_category'),
            'target_amount' => $request->input('target_amount'),
            'start_date' => $request->input('start_date'),
            'Added_by' => auth()->user()->id,
            'end_date' => $request->input('end_date'),
           
        ]);

        $Goals->save();


        /***Creates a new cataegory based on the title of the goal, to allow the balance to updated nicely */
        $category = new category();
        $category->category ="Goal : ". $request->input('title');
        If($request->goal_category=="Saving" || $request->goal_category=="Investing" ){
            $category->Nature = "Current Assets";

        }else{
            $category->Nature = "Current Liabilities";

        }
        $category->Added_by=Auth::id();
        $category->save();





        $NewGoal=DB::table('Goals')->where("Added_by","=",auth()->user()->id)->latest()->first();
          $this->Milestone($NewGoal);


        return redirect()->route('Goals.index')
            ->with('success', 'Goal created successfully.');
    }

    /**
     * Display the specified resource.
     */
   
     public function show($id)
{
    $goal = Goals::findOrFail($id);

    // Retrieve milestone data associated with the goal
    $milestones = Milestone::where('goal_id', $id)->orderBy('milestone_number')->get();

    // Prepare the data for the chart
    $milestonesData = [];
    foreach ($milestones as $milestone) {
        $milestonesData[] = [
            'label' => 'Milestone ' . ($milestone->milestone_number),
            'status' => $milestone->milestone_status,
            'date' => $milestone->due_date->format('Y-m-d'), // Format the date as needed
            'amount' => $milestone->milestone_amount,
        ];
    }

    // Get the current balance
    $currentAmount = $goal->current_amount;

    // Find the correct position to insert "Current Balance" milestone
    $currentIndex = 0;
    while ($currentIndex < count($milestonesData) && $currentAmount >= $milestonesData[$currentIndex]['amount']) {
        $currentIndex++;
    }

    // Create a new array with the "Current Balance" milestone included
    $milestonesChartData = $milestonesData;
    array_splice($milestonesChartData, $currentIndex, 0, [
        [
            'label' => 'Current Balance',
            'status' => 'current',
            'date' => date('Y-m-d'), // Use the current date when the balance is added
            'amount' => $currentAmount,
        ]
    ]);

    return view('Goals.show', compact('goal', 'milestonesData', 'milestonesChartData'));
}

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goals $goals)
    {
        return view('Goals.edit', compact('goal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Goals $goal)
    {
        $request->validate([
            'current_amount' => 'required|numeric',
        ]);
        if($goal->target_amount>$request->input('current_amount')){
            $goal->current_amount = $request->input('current_amount');
           
            $goal->save();
        }
        else{

        $goal->current_amount = $request->input('current_amount');
        $goal->Status="Completed";
        $goal->save();
        }

   
       /** */ $this->updateMilestones($goal->current_amount);
    
        return redirect()->route('Goals.show', $goal)
            ->with('success', 'Goal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goals $goal)
    {
      
        $goal->Status="Deleted";
        $goal->save();
        return redirect()->route('Goals.Matter')
        ->with('success', 'Goal updated successfully.');
    }

    public function Milestone($goal)
{
    // Retrieve the goal details
    $targetAmount = $goal->target_amount;
    $duration = $this->calculateDuration($goal->start_date, $goal->end_date);

    // Calculate the milestone amount increment
    $milestoneIncrement = $targetAmount / $duration;

    // Create and save the milestones
    for ($i = 0; $i <= $duration; $i++) {
        $milestoneAmount = $milestoneIncrement * $i;
        $milestone = new Milestone([
            'goal_id' => $goal->id,
            'milestone_number' => $i,
            'milestone_amount' => $milestoneAmount,
            'due_date' =>  Carbon::parse($goal->start_date)->addMonths($i),
        ]);

        $milestone->save();
    }
}
    public function calculateDuration($Start, $end)
        {
            $startDate = Carbon::parse($Start);
            $endDate = Carbon::parse($end);
            $duration = $startDate->diffInMonths($endDate) + 1; // Add 1 to include the start month

            return $duration;

        }
        

        public function updateBalance()
        {
            // Retrieve categories that have "Goal :" in their name and are associated with in-progress goals
            $category = Category::select('categories.*')
                ->join(DB::raw('(SELECT title FROM goals WHERE Status = "In-Progress" AND target_amount > current_amount) AS g'), function ($join) {
                    $join->on('categories.category', '=', DB::raw('CONCAT("Goal : ", g.title)'));
                })
                ->where('categories.Added_by', '=', auth()->user()->id)
                ->get();
            // Get cards for view
            $cards = Cards::where("Added_by", "=", auth()->user()->id)->get();
            $action = "Yes";
        
            return view('Transactions.create', compact('category', 'cards', 'action'));
        }
        
        
        
        
        
        
        
        
        
        
        
}