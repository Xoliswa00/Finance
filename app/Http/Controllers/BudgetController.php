<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Journal_entry;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DD;
use PHPUnit\TextUI\Configuration\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination;
use illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;



class BudgetController extends Controller
{
    public function index()
    {
        
        $CurrentB = Budget::all()->where('Added_by', "=", auth()->user()->id)->where("Status","=","Planning")->sortBy('due_date');



        $budgets = Budget::where('Added_by', auth()->user()->id)
        ->where('Status', 'Finalized')->latest()
        ->paginate(10);



        

        $budgetData = DB::table('budgets')
        ->selectRaw('DATE_FORMAT(due_date, "%Y-%m") AS month, 
                     SUM(CASE WHEN Nature = "Income" THEN Amount ELSE 0 END) AS income_budgeted,
                     SUM(CASE WHEN Nature != "Income"  THEN Amount ELSE 0 END) AS expense_budgeted,
                     SUM(CASE WHEN Nature = "Income" THEN Amount ELSE -Amount END) AS net_budgeted,
                     SUM(CASE WHEN Nature = "Income" THEN IFNULL(budgets.Limit, 0) ELSE 0 END) AS income_actual,
                     SUM(CASE WHEN Nature != "Income"  THEN IFNULL(budgets.Limit, 0) ELSE 0 END) AS expense_actual,
                     SUM(CASE WHEN Nature = "Income" THEN IFNULL(budgets.Limit, 0) ELSE -IFNULL(budgets.Limit, 0) END) AS net_actual')
        ->join('categories', 'budgets.category', '=', 'categories.id')
        ->where('budgets.Status', 'Planning')
        ->where('budgets.Added_by', auth()->user()->id)
        ->groupBy('month')
        ->get();


        $chart = DB::table('budgets')
        ->selectRaw('DATE_FORMAT(due_date, "%Y-%m") AS month, 
                     SUM(CASE WHEN Nature = "Income" THEN Amount ELSE 0 END) AS income_budgeted,
                     SUM(CASE WHEN Nature != "Income"  and Nature != "Expenses"  THEN Amount ELSE 0 END) AS other_spending,
                     SUM(CASE WHEN Nature = "Expenses"  THEN Amount ELSE 0 END) AS expense_budgeted')
        ->join('categories', 'budgets.category', '=', 'categories.id')
        
        ->where('budgets.Added_by', auth()->user()->id)
        ->whereNot('budgets.Status', 'Deleted')
        ->groupBy('month')
        ->get();
       


       
      



        return view('budgets.index', compact('budgets','budgetData','CurrentB','chart'));
    }

    public function create()
    {

        $category=category::all()->where("Added_by", "=", auth()->user()->id);
        return view('budgets.create',compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|numeric',
            'description' => 'required|string|max:200',
            'amount' => 'required|numeric',
            'limit' => 'required|numeric',
            'due_date' => 'required|date',
            'recurring' => 'required|string|in:Once-off,Weekly,Monthly,Yearly',
          
            'priority' => 'nullable|string|in:High,Moderate,Normal',
           
        ]);

        $budget = new Budget([
            'Category' => $request->input('category'),
            'Description' => $request->input('description'),
            'Amount' => $request->input('amount'),
            'Limit' => $request->input('limit'),
            'due_date' => $request->input('due_date'),
            'Recurring' => $request->input('recurring'),
            'Priority' => $request->input('priority'),
            'Status' => 'Planning',
            'Added_by' => auth()->user()->id,
        ]);

        $budget->save();

        return redirect('/budgets')->with('success', 'Budget item created successfully.');
    }

    public function show(Budget $budget)
    {
        return view('budgets.show', compact('budget'));
    }

    public function edit(Budget $budget)
    {
      

        return view('budgets.edit', compact('budget'));
    }

    public function update(Request $request)
    {

       
        $request->validate([
      
            'description' => 'required|string|max:200',
            'amount' => 'nullable|numeric',
            'limit' => 'required|numeric',
            'due_date' => 'required|date',
            'recurring' => 'required|string|in:Once-off,Weekly,Monthly,Yearly',
   
         
        ]);
  $budget =Budget::findorfail( $request->input('id'));
      
        $budget->Description= $request->input('description');
        $budget->  Amount= $request->input('amount');
        $budget->Limit = $request->input('limit');
        $budget->due_date = $request->input('due_date');
        $budget->recurring = $request->input('recurring');
      
      
        $budget->save();

        return redirect('/budgets')->with('success', 'Budget item updated successfully.');
    }

    public function destroy($budget)
    {
        
        $transaction = Budget::findOrFail($budget);
        $transaction->Status="Deleted";
        $transaction->save();

        return redirect('/budgets')->with('success', 'Budget item deleted successfully.');
    }

    public function Balance($category,$amount)
    {
        
        $balance = category::findOrFail($category);
        $balance->Balance=$balance->Balance+$amount;
        $balance->save();

    }
    public function Finalized($budget)
    {
        $X_query=  Budget::findOrFail($budget);
     

        $nature = Category::where("Added_by", "=", auth()->user()->id)->where('id', '=', $X_query->Category)->first();

        
        $Bank = Category::where("Added_by", "=", auth()->user()->id)->where('category', '=', 'Bank (Dr)')->first();

        $Budgets = Budget::findOrFail($budget);
            $Budgets->Status="Finalized";
            $Budgets->save();


            if($nature->Nature=="Income"){
                $action="Earned";
            }else{
                $action="Paid";
            }

            $userRegMonth = Carbon::parse(auth()->user()->created_at)->month;

            // Parse the bill_date from the request input
            $transactionDate = Carbon::parse($X_query->due_date);
            $transactionMonth = $transactionDate->month;
            
    // Calculate the financial year based on the user's registration month
    if ($transactionMonth >= $userRegMonth) {
        $financialYear = $transactionDate->year;
    } else {
        $financialYear = $transactionDate->year - 1;
    }

            $transaction = new Transaction;

            $transaction->Action = $action;
            $transaction->category = $X_query->Category;
            $transaction->Method = "Debit Card";
            $transaction->description =$X_query->Description;
            $transaction->amount = $X_query->Amount;
            $transaction->bill_date =$X_query->due_date;
            $transaction->FY = $financialYear;

          
            $transaction->added_by = auth()->user()->id;
            
            $transaction->save();
        

            $controller =app(TransactionController::class);
            $controller->Journals();
            return redirect('/budgets')->with('success', 'New Transaction was created successfully.');








        

    


      
    }
    public function Recurrings()
    {
        $currentMonth = Carbon::now();
        $MonthsAgo = $currentMonth->copy()->subMonths(1);
        $recurringOptions = [ 'Monthly', 'Yearly'];
        $categories = category::all()->where("Added_by", "=", auth()->user()->id);
    
        foreach ($recurringOptions as $option) {
            $budgets = Budget::where('Recurring', $option)
                ->where('Status', '=', 'Finalized')
                ->whereBetween('due_date',[$MonthsAgo,$currentMonth])
              
                ->where('Added_by', auth()->user()->id)
                ->whereNotIn('Description', function ($query) {
                    $query->select('Description')
                        ->from('budgets')
                        ->where('Status', 'Planning');
                })
                ->get();
               
    
            foreach ($budgets as $budget) {
                // Create new budget item based on the recurring option
                // Modify the budget attributes as needed
                $newBudget = new Budget([
                    'Category' => $budget->Category,
                    'Description' => $budget->Description,
                    'Amount' => $budget->Amount,
                    'Limit' => $budget->Limit,
                    'due_date' => $this->calculateNextDueDate($option, $budget->due_date),
                    'Recurring' => $budget->Recurring,
                    'Priority' => $budget->Priority,
                    'Status' => 'Planning',
                    'Added_by' => auth()->user()->id,
                ]);
    
                $newBudget->save();
            }
        }
    
        return redirect('/budgets')->with('success', 'Recurring budget items created successfully.');
    }
    

public function calculateNextDueDate($recurringOption, $currentDueDate)
{
    // Calculate and return the next due date based on the recurring option
    $nextDueDate = null;

    switch ($recurringOption) {
        case 'Once-off':
            // Set next due date to null for once-off budgets
            $nextDueDate = null;
            break;
        case 'Weekly':
            // Calculate next due date as 7 days from the current due date
            $nextDueDate = date('Y-m-d', strtotime($currentDueDate . ' + 7 days'));
            break;
        case 'Monthly':
            // Calculate next due date as 1 month from the current due date
            $nextDueDate = date('Y-m-d', strtotime($currentDueDate . ' + 1 month'));
            break;
        case 'Yearly':
            // Calculate next due date as 1 year from the current due date
            $nextDueDate = date('Y-m-d', strtotime($currentDueDate . ' + 1 year'));
            break;
    }

    return $nextDueDate;
}

}
