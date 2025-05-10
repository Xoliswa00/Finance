<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            // Calculate the start and end dates for the last three months
    $currentMonth = Carbon::now();
   $lastMonth = $currentMonth->copy()->subMonth();
$twoMonthsAgo = $currentMonth->copy()->subMonths(2);
$thereMonthsAgo = $currentMonth->copy()->subMonths(3);
        $currentMonth;
    // Retrieve income transactions for the last three months grouped by description
    $incomeReport = DB::table('transactions')
        ->select('description',
            DB::raw("SUM(CASE WHEN (Action = 'Received' or Action = 'Earned' ) AND bill_date between '$thereMonthsAgo' and  '$twoMonthsAgo' THEN amount ELSE 0 END) AS month_2_total"),
            DB::raw("SUM(CASE WHEN (Action = 'Received' or Action = 'Earned' )  AND bill_date between '$twoMonthsAgo' and '$lastMonth' THEN amount ELSE 0 END) AS month_1_total"),
            DB::raw("SUM(CASE WHEN (Action = 'Received' or Action = 'Earned' )  AND bill_date between '$lastMonth' and  '$currentMonth' THEN amount ELSE 0 END) AS current_month_total"))
            ->where("Added_by", "=", auth()->user()->id)
            ->groupBy('description')
        ->get();

       

    // Retrieve expense transactions for the last three months grouped by description
    $expenseReport = DB::table('transactions')
        ->select('description',
            DB::raw("SUM(CASE WHEN (Action = 'Paid' or Action = 'Bought') AND bill_date BETWEEN  '$thereMonthsAgo' and  '$twoMonthsAgo' THEN amount ELSE 0 END) AS month_2_total"),
            DB::raw("SUM(CASE WHEN (Action = 'Paid' or Action = 'Bought')  AND bill_date BETWEEN '$twoMonthsAgo' and '$lastMonth' THEN amount ELSE 0 END) AS month_1_total"),
            DB::raw("SUM(CASE WHEN (Action = 'Paid' or Action = 'Bought')  AND bill_date BETWEEN '$lastMonth' and  '$currentMonth' THEN amount ELSE 0 END) AS current_month_total"))
            ->where("Added_by", "=", auth()->user()->id)
            ->groupBy('description')
      
        ->get();

    // Combine the income and expense reports into a single array
    $report = [];
    foreach ($incomeReport as $income) {
        $report[$income->description] = [
            'Income_description'=>$income->description,
            'income_month_2_total' => $income->month_2_total,
            'income_month_1_total' => $income->month_1_total,
            'income_current_month_total' => $income->current_month_total,
            'income_current_Balance'=>$income->month_2_total+$income->month_1_total+$income->current_month_total,
            'Expense_description'=>" ",
            'expense_month_2_total' => 0,
            'expense_month_1_total' => 0,
            'expense_current_month_total' => 0,
            'expense_current_Balance' => 0,
        ];
    }

    foreach ($expenseReport as $expense) {
        if (isset($report[$expense->description])) {
            $report[$expense->description]['Expense_description'] = $expense->description;
            $report[$expense->description]['expense_month_2_total'] = $expense->month_2_total;
            $report[$expense->description]['expense_month_1_total'] = $expense->month_1_total;
            $report[$expense->description]['expense_current_month_total'] = $expense->current_month_total;
            $report[$expense->description]['expense_current_Balance'] = $expense->current_month_total+$expense->month_1_total+$expense->month_2_total;

        } else {
            $report[$expense->description] = [
                'Income_description'=>"",
                'income_month_2_total' => 0,
                'income_month_1_total' => 0,
                'income_current_month_total' => 0,
                'income_current_Balance'=>0,
                'Expense_description'=>$expense->description,
                'expense_month_2_total' => $expense->month_2_total,
                'expense_month_1_total' => $expense->month_1_total,
                'expense_current_month_total' => $expense->current_month_total,
                'expense_current_Balance' => $expense->current_month_total+$expense->month_1_total+$expense->month_2_total,
            ];
        }
    }
   $month3=date_format($twoMonthsAgo,"M-Y");
   $month2=date_format($lastMonth,"M-Y");
   $month1=date_format($currentMonth,"M-Y");


        return view('Financials.reports',compact('report','month3','month2','month1') );
    }





    /***
     * Cash budget function
    */
    public function CashBudget(){
        $currentMonthT = Carbon::now();
        $currentMonth = $currentMonthT->format('Y-m');
        $nextMonthT = $currentMonthT->copy()->addMonth();
        $nextMonth = $nextMonthT->format('Y-m');
        $lastMonthT = $currentMonthT->copy()->subMonth();
     $lastMonth = $lastMonthT->format('Y-m');

        // Retrieve budget data for the last two months grouped by description
        $budgetData = DB::table('budgets')
        ->select('Description', DB::raw("MAX(categories.Nature) as Nature"),
        DB::raw("SUM(CASE WHEN DATE_FORMAT(due_date, '%Y-%m') = '$lastMonth' AND DATE_FORMAT(due_date, '%Y-%m') < '$currentMonth' THEN Amount ELSE 0 END) AS month_2_budget"),
        DB::raw("SUM(CASE WHEN DATE_FORMAT(due_date, '%Y-%m') = '$lastMonth' AND DATE_FORMAT(due_date, '%Y-%m') < '$currentMonth' THEN budgets.Limit ELSE 0 END) AS month_2_Actual"),
        DB::raw("SUM(CASE WHEN DATE_FORMAT(due_date, '%Y-%m') = '$currentMonth'  THEN Amount ELSE 0 END) AS month_1_budget"),
        DB::raw("SUM(CASE WHEN DATE_FORMAT(due_date, '%Y-%m') = '$currentMonth' THEN budgets.Limit ELSE 0 END) AS month_1_Actual"),
      
    )
                ->whereIn('budgets.Status',['Planning','Finalized'])
                ->where("budgets.Added_by", "=", auth()->user()->id)
            ->groupBy('Description')
            ->join('categories','categories.id','budgets.Category')
            ->get();
        


        $openingBalance = 0; // Initialize the opening balance

        foreach ($budgetData as $budgetItem) {
            // Accumulate the budgeted cash inflows for Month 2
            $openingBalance += $budgetItem->month_2_budget;
        }
        $totalCashInflowsMonth1=0;
        $totalCashOutflowsMonth1=0;
        foreach($budgetData as $balances){
            if($balances->Nature =="Income"  ){
                $totalCashInflowsMonth1 +=$balances->month_1_budget;

            }else{
                $totalCashOutflowsMonth1 +=$balances->month_1_budget;
            }

            
        }
           
             


                    // Calculate the net cash flow for the current month
            $currentMonthNetCashFlow = $totalCashInflowsMonth1 - $totalCashOutflowsMonth1; 

            // Calculate the closing balance for the current month
            $closingBalance = $openingBalance - $currentMonthNetCashFlow;

        // Pass the data to the view
        $data = [
            'opening_balance' => $openingBalance,
            'closing_balance'=>$closingBalance,
            'budget_data' => $budgetData,
            'month_2'=>date_format($lastMonthT,"M-Y"),
            'month_1'=>date_format($currentMonthT,"M-Y")
        ];

        
         
        return view('Financials.CashBudget',compact('data'));
    }


    /**
     * Balanace sheet 
     */

     public function Balancesheet(){
        $currentMonthT = Carbon::now();
        $currentMonth = $currentMonthT->format('Y-m');
        $nextMonthT = $currentMonthT->copy()->addMonth();
        $nextMonth = $nextMonthT->format('Y-m');
        $lastMonthT = $currentMonthT->copy()->subMonth();
        $lastMonth = $lastMonthT->format('Y-m');
        $thereMonthsAgoT = $currentMonthT->copy()->subMonths(3);
        $threeMonthsAgo =   $thereMonthsAgoT->format('Y-m');

        

       

        $results = DB::table('journal_entries as je')
        ->select('c1.nature', 'je.Account as Account_No', 'c1.category as Account_Name', 'je.Effect', 'je.Amount', 'je.created_at as Transaction_date', 'c1.added_by')
        ->leftJoin('categories as c1', function($join) {
            $join->on('je.Account', '=', 'c1.id')
                 ->orOn('je.Account', '=', 'c1.category');
        })
        ->whereNotIn('c1.nature', ['Expenses', 'Income'])
        ->where('c1.Added_by', '=', auth()->user()->id)
        ->get();

    
    $accountBalances = [];
    
    foreach ($results as $entry) {
        $date = date_create($entry->Transaction_date);
        $monthYear = date_format($date, 'Y-m');
    
        $key = $entry->Account_Name;
    
        if (!isset($accountBalances[$key])) {
            $accountBalances[$key] = [
                'Nature' => $entry->nature,
                'Account' => $entry->Account_No,
                'Account_Name' => $entry->Account_Name,
                'Balances' => [],
            ];
        }
    
        // Apply rules for different account natures
        if ($entry->nature == "Non-Current Assets" || $entry->nature == "Current Assets" || $entry->nature == "Drawings") {
            if ($entry->Effect == 'Dr') {
                $accountBalances[$key]['Balances'][$monthYear] = ($accountBalances[$key]['Balances'][$monthYear] ?? 0) + $entry->Amount;
            } elseif ($entry->Effect == 'Cr') {
                $accountBalances[$key]['Balances'][$monthYear] = ($accountBalances[$key]['Balances'][$monthYear] ?? 0) - $entry->Amount;
            }
        } else {
            if ($entry->Effect == 'Dr') {
                $accountBalances[$key]['Balances'][$monthYear] = ($accountBalances[$key]['Balances'][$monthYear] ?? 0) - $entry->Amount;
            } elseif ($entry->Effect == 'Cr') {
                $accountBalances[$key]['Balances'][$monthYear] = ($accountBalances[$key]['Balances'][$monthYear] ?? 0) + $entry->Amount;
            }
        }
    }
    
    // Initialize an array to store the total balances for each month
   // Initialize an array to store the total balances for each month
$totalBalances = [];

// Iterate through the last three months and calculate the total balances
$today = new \DateTime('now');
$grandTotal = 0;

for ($i = 0; $i < 3; $i++) {
    $totalBalance = 0;
    $currentMonthYear = $today->format('Y-m');

    foreach ($accountBalances as $key => $account) {
        if (isset($account['Balances'][$currentMonthYear])) {
            $totalBalance += $account['Balances'][$currentMonthYear];
        }
    }

    // Set total to zero if there are no transactions for the month
    if ($totalBalance === 0) {
        $totalBalances[$currentMonthYear] = 0;
    } else {
        $totalBalances[$currentMonthYear] = $totalBalance;
    }

    $grandTotal += $totalBalance;

    $today->modify('first day of previous month');
}


    
    // $totalBalances now contains the balances for the last three months
    // $grandTotal contains the sum of balances for the last three months
    

    






    $balances = DB::table('categories')
    ->select('id','Nature', 'category',
        DB::raw("SUM(CASE WHEN DATE_FORMAT(updated_at, '%Y-%m') < '$lastMonth' THEN Balance ELSE 0 END) AS Older"),
        DB::raw("SUM(CASE WHEN DATE_FORMAT(updated_at, '%Y-%m') >= '$lastMonth' AND DATE_FORMAT(updated_at, '%Y-%m') < '$currentMonth' THEN Balance ELSE 0 END) AS LastMonth"),
        DB::raw("SUM(CASE WHEN DATE_FORMAT(updated_at, '%Y-%m') >= '$currentMonth' AND DATE_FORMAT(updated_at, '%Y-%m') < '$nextMonth' THEN Balance ELSE 0 END) AS Current")
    )
    ->where('Added_by', '=', auth()->user()->id)
    ->where('Balance', '<>', 0)
    //->wherenotin('category',['Income','Expenses'])
    ->groupBy('id','Nature', 'category')  // Group by Nature and category
    ->get();
   
        return view('Financials.Balancesheet',compact('balances','currentMonth','lastMonth','accountBalances','totalBalances'));
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // Fetch the specific category using the ID
        $account = DB::table('categories')
                        ->select('category','updated_at')
                        ->where('id', $request->id)
                        ->where('Added_by', auth()->user()->id)
                        ->first();
    
        // Check if the category exists
        if (!$account) {
            return redirect()->route('your_error_route')->with('error', 'Category not found.');
        }
    
        // Retrieve transactions related to the selected category
        $result = DB::table('journal_entries')
                        ->select('Effect', 'transactions.Action', 'categories.category as Account', 'transactions.bill_date', 'transactions.Amount', 'transactions.Description')
                        ->join('transactions', 'journal_entries.transaction_id', '=', 'transactions.id')
                        ->join('categories', 'transactions.Category', '=', 'categories.id')
                        ->where('journal_entries.Account', $request->id)
                        ->where('categories.Added_by', auth()->user()->id)
                        ->get();
    
        return view('Financials.T-Balance', compact('account', 'result'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reports $reports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reports $reports)
    {
        //
    }
}
