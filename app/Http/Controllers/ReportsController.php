<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        // Use the current financial year (July-June) as the reporting period
        $fy      = \App\Models\FinancialYear::forDate(Carbon::now());
        $fyStart = $fy['start_date'];   // e.g. 2026-07-01
        $fyEnd   = $fy['end_date'];     // e.g. 2027-06-30
        $fyLabel = $fy['label'];        // e.g. FY2027

        // Three most recent complete months within the FY to use as column headers
        $now    = Carbon::now();
        $m1Date = $now->copy()->startOfMonth();
        $m2Date = $now->copy()->subMonth()->startOfMonth();
        $m3Date = $now->copy()->subMonths(2)->startOfMonth();

        // Clamp to FY start so we never show data from a prior FY
        $fyStartDate = Carbon::parse($fyStart);
        if ($m3Date->lt($fyStartDate)) $m3Date = $fyStartDate->copy();
        if ($m2Date->lt($fyStartDate)) $m2Date = $fyStartDate->copy();

        $m3Start = $m3Date->toDateString();
        $m3End   = $m3Date->copy()->endOfMonth()->toDateString();
        $m2Start = $m2Date->toDateString();
        $m2End   = $m2Date->copy()->endOfMonth()->toDateString();
        $m1Start = $m1Date->toDateString();
        $m1End   = $m1Date->copy()->endOfMonth()->toDateString();

        $incomeReport = DB::table('transactions')
            ->select('description',
                DB::raw("SUM(CASE WHEN Action IN ('Received','Earned') AND bill_date BETWEEN '$m3Start' AND '$m3End' THEN amount ELSE 0 END) AS month_2_total"),
                DB::raw("SUM(CASE WHEN Action IN ('Received','Earned') AND bill_date BETWEEN '$m2Start' AND '$m2End' THEN amount ELSE 0 END) AS month_1_total"),
                DB::raw("SUM(CASE WHEN Action IN ('Received','Earned') AND bill_date BETWEEN '$m1Start' AND '$m1End' THEN amount ELSE 0 END) AS current_month_total"))
            ->where('Added_by', auth()->id())
            ->whereBetween('bill_date', [$fyStart, $fyEnd])
            ->groupBy('description')
            ->get();

        $expenseReport = DB::table('transactions')
            ->select('description',
                DB::raw("SUM(CASE WHEN Action IN ('Paid','Bought') AND bill_date BETWEEN '$m3Start' AND '$m3End' THEN amount ELSE 0 END) AS month_2_total"),
                DB::raw("SUM(CASE WHEN Action IN ('Paid','Bought') AND bill_date BETWEEN '$m2Start' AND '$m2End' THEN amount ELSE 0 END) AS month_1_total"),
                DB::raw("SUM(CASE WHEN Action IN ('Paid','Bought') AND bill_date BETWEEN '$m1Start' AND '$m1End' THEN amount ELSE 0 END) AS current_month_total"))
            ->where('Added_by', auth()->id())
            ->whereBetween('bill_date', [$fyStart, $fyEnd])
            ->groupBy('description')
            ->get();

        $report = [];
        foreach ($incomeReport as $income) {
            $report[$income->description] = [
                'Income_description'         => $income->description,
                'income_month_2_total'       => $income->month_2_total,
                'income_month_1_total'       => $income->month_1_total,
                'income_current_month_total' => $income->current_month_total,
                'income_current_Balance'     => $income->month_2_total + $income->month_1_total + $income->current_month_total,
                'Expense_description'        => ' ',
                'expense_month_2_total'      => 0,
                'expense_month_1_total'      => 0,
                'expense_current_month_total'=> 0,
                'expense_current_Balance'    => 0,
            ];
        }

        foreach ($expenseReport as $expense) {
            if (isset($report[$expense->description])) {
                $report[$expense->description]['Expense_description']         = $expense->description;
                $report[$expense->description]['expense_month_2_total']       = $expense->month_2_total;
                $report[$expense->description]['expense_month_1_total']       = $expense->month_1_total;
                $report[$expense->description]['expense_current_month_total'] = $expense->current_month_total;
                $report[$expense->description]['expense_current_Balance']     = $expense->month_2_total + $expense->month_1_total + $expense->current_month_total;
            } else {
                $report[$expense->description] = [
                    'Income_description'         => '',
                    'income_month_2_total'       => 0,
                    'income_month_1_total'       => 0,
                    'income_current_month_total' => 0,
                    'income_current_Balance'     => 0,
                    'Expense_description'        => $expense->description,
                    'expense_month_2_total'      => $expense->month_2_total,
                    'expense_month_1_total'      => $expense->month_1_total,
                    'expense_current_month_total'=> $expense->current_month_total,
                    'expense_current_Balance'    => $expense->month_2_total + $expense->month_1_total + $expense->current_month_total,
                ];
            }
        }

        $month3 = $m3Date->format('M-Y');
        $month2 = $m2Date->format('M-Y');
        $month1 = $m1Date->format('M-Y');

        return view('Financials.reports', compact('report', 'month3', 'month2', 'month1', 'fyLabel'));
    }





    public function CashBudget()
    {
        $userId        = auth()->user()->id;
        $currentMonthT = Carbon::now();
        $currentMonth  = $currentMonthT->format('Y-m');
        $lastMonthT    = $currentMonthT->copy()->subMonth();
        $lastMonth     = $lastMonthT->format('Y-m');

        // Opening balance = Bank (Dr) category actual balance
        $bankRow = DB::table('categories')
            ->where('Added_by', $userId)
            ->where('category', 'Bank (Dr)')
            ->first();
        $openingBalance = $bankRow ? (float) $bankRow->Balance : 0;

        $budgetData = DB::table('budgets')
            ->select(
                'budgets.Description',
                DB::raw('MAX(categories.Nature) as Nature'),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(due_date,'%Y-%m') = '$lastMonth'    THEN budgets.Amount            ELSE 0 END) AS m2_budget"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(due_date,'%Y-%m') = '$lastMonth'    THEN COALESCE(budgets.Limit,0) ELSE 0 END) AS m2_actual"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(due_date,'%Y-%m') = '$currentMonth' THEN budgets.Amount            ELSE 0 END) AS m1_budget"),
                DB::raw("SUM(CASE WHEN DATE_FORMAT(due_date,'%Y-%m') = '$currentMonth' THEN COALESCE(budgets.Limit,0) ELSE 0 END) AS m1_actual")
            )
            ->join('categories', 'categories.id', '=', 'budgets.Category')
            ->whereIn('budgets.Status', ['Planning', 'Finalized'])
            ->where('budgets.Added_by', $userId)
            ->groupBy('budgets.Description')
            ->orderByRaw("FIELD(MAX(categories.Nature),'Income') DESC")
            ->orderBy('budgets.Description')
            ->get();

        $m2IncomeBudget = $m2IncomeActual = $m2ExpenseBudget = $m2ExpenseActual = 0;
        $m1IncomeBudget = $m1IncomeActual = $m1ExpenseBudget = $m1ExpenseActual = 0;

        foreach ($budgetData as $row) {
            if ($row->Nature === 'Income') {
                $m2IncomeBudget  += $row->m2_budget;  $m2IncomeActual  += $row->m2_actual;
                $m1IncomeBudget  += $row->m1_budget;  $m1IncomeActual  += $row->m1_actual;
            } else {
                $m2ExpenseBudget += $row->m2_budget;  $m2ExpenseActual += $row->m2_actual;
                $m1ExpenseBudget += $row->m1_budget;  $m1ExpenseActual += $row->m1_actual;
            }
        }

        // Net = Inflows - Outflows  |  Closing = Opening + Net
        $m1NetBudget    = $m1IncomeBudget  - $m1ExpenseBudget;
        $m1NetActual    = $m1IncomeActual  - $m1ExpenseActual;
        $m2NetBudget    = $m2IncomeBudget  - $m2ExpenseBudget;
        $m2NetActual    = $m2IncomeActual  - $m2ExpenseActual;
        $closingBalance = $openingBalance + $m1NetBudget;

        $data = [
            'opening_balance'   => $openingBalance,
            'closing_balance'   => $closingBalance,
            'budget_data'       => $budgetData,
            'month_2'           => $lastMonthT->format('M Y'),
            'month_1'           => $currentMonthT->format('M Y'),
            'm2_income_budget'  => $m2IncomeBudget,
            'm2_income_actual'  => $m2IncomeActual,
            'm2_expense_budget' => $m2ExpenseBudget,
            'm2_expense_actual' => $m2ExpenseActual,
            'm1_income_budget'  => $m1IncomeBudget,
            'm1_income_actual'  => $m1IncomeActual,
            'm1_expense_budget' => $m1ExpenseBudget,
            'm1_expense_actual' => $m1ExpenseActual,
            'm2_net_budget'     => $m2NetBudget,
            'm2_net_actual'     => $m2NetActual,
            'm1_net_budget'     => $m1NetBudget,
            'm1_net_actual'     => $m1NetActual,
        ];

        return view('Financials.CashBudget', compact('data'));
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
     * Monthly income vs expense trend — last 12 months
     */
    public function monthlyTrends()
    {
        $userId  = auth()->user()->id;
        $fy      = \App\Models\FinancialYear::forDate(Carbon::now());
        $fyStart = $fy['start_date'];
        $fyEnd   = $fy['end_date'];
        $fyLabel = $fy['label'];

        $rows = DB::table('transactions')
            ->select(
                DB::raw("DATE_FORMAT(bill_date, '%Y-%m') as month"),
                DB::raw("SUM(CASE WHEN Action IN ('Received','Earned') THEN amount ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN Action IN ('Paid','Bought') THEN amount ELSE 0 END) as expenses")
            )
            ->where('Added_by', $userId)
            ->whereBetween('bill_date', [$fyStart, $fyEnd])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $categoryBreakdown = DB::table('transactions')
            ->join('categories', 'transactions.Category', '=', 'categories.id')
            ->select(
                'categories.category as name',
                'categories.Nature as nature',
                DB::raw('SUM(transactions.Amount) as total')
            )
            ->where('transactions.Added_by', $userId)
            ->where('transactions.bill_date', '>=', Carbon::now()->subMonths(2)->startOfMonth())
            ->where('transactions.Action', 'IN', ['Paid', 'Bought'])
            ->groupBy('categories.id', 'categories.category', 'categories.Nature')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // fix IN — use whereIn instead
        $categoryBreakdown = DB::table('transactions')
            ->join('categories', 'transactions.Category', '=', 'categories.id')
            ->select(
                'categories.category as name',
                'categories.Nature as nature',
                DB::raw('SUM(transactions.Amount) as total')
            )
            ->where('transactions.Added_by', $userId)
            ->whereBetween('transactions.bill_date', [$fyStart, $fyEnd])
            ->whereIn('transactions.Action', ['Paid', 'Bought'])
            ->groupBy('categories.id', 'categories.category', 'categories.Nature')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $netByMonth = $rows->map(fn($r) => [
            'month'    => $r->month,
            'income'   => (float) $r->income,
            'expenses' => (float) $r->expenses,
            'net'      => (float) $r->income - (float) $r->expenses,
        ]);

        $totals = [
            'income'   => $netByMonth->sum('income'),
            'expenses' => $netByMonth->sum('expenses'),
            'net'      => $netByMonth->sum('net'),
        ];

        return view('Financials.monthly-trends', compact('netByMonth', 'totals', 'categoryBreakdown', 'fyLabel'));
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
        $userId = auth()->user()->id;

        $account = DB::table('categories')
            ->select('id', 'category', 'Nature', 'Balance', 'updated_at')
            ->where('id', $request->id)
            ->where('Added_by', $userId)
            ->first();

        if (!$account) {
            return redirect()->route('Balancesheet')->with('error', 'Account not found.');
        }

        // journal_entries.Account stores EITHER the numeric category id (as string)
        // OR the category name directly (e.g. "Bank (Dr)").  Match both.
        $result = DB::table('journal_entries')
            ->select(
                'journal_entries.Effect',
                'journal_entries.Amount',
                'journal_entries.created_at as entry_date',
                'transactions.Action',
                'transactions.bill_date',
                'transactions.Description',
                'contra_cat.category as ContraAccount'
            )
            ->join('transactions', 'journal_entries.transaction_id', '=', 'transactions.id')
            // Fetch the contra account name (the OTHER entry in the same transaction for this account)
            ->leftJoin('journal_entries as je2', function ($j) {
                $j->on('je2.transaction_id', '=', 'journal_entries.transaction_id')
                  ->whereColumn('je2.id', '<>', 'journal_entries.id');
            })
            ->leftJoin('categories as contra_cat', function ($j) {
                $j->on('contra_cat.id', '=', 'je2.Account')
                  ->orOn('contra_cat.category', '=', 'je2.Account');
            })
            ->where('transactions.Added_by', $userId)
            ->where(function ($q) use ($account) {
                // Match by numeric ID stored as string, OR by category name
                $q->where('journal_entries.Account', (string) $account->id)
                  ->orWhere('journal_entries.Account', $account->category);
            })
            ->orderBy('transactions.bill_date')
            ->get();

        // Compute T-account totals
        $totalDr = $result->where('Effect', 'Dr')->sum('Amount');
        $totalCr = $result->where('Effect', 'Cr')->sum('Amount');

        // Balance c/d and b/d
        if ($totalDr >= $totalCr) {
            $balanceSide = 'Dr';
            $balanceAmt  = $totalDr - $totalCr;
            $cd = ['side' => 'Cr', 'amount' => $balanceAmt];   // c/d on Cr side to balance
            $bd = ['side' => 'Dr', 'amount' => $balanceAmt];   // b/d on Dr side (debit balance)
        } else {
            $balanceSide = 'Cr';
            $balanceAmt  = $totalCr - $totalDr;
            $cd = ['side' => 'Dr', 'amount' => $balanceAmt];   // c/d on Dr side
            $bd = ['side' => 'Cr', 'amount' => $balanceAmt];   // b/d on Cr side (credit balance)
        }

        $runningTotal = max($totalDr, $totalCr);

        return view('Financials.T-Balance', compact(
            'account', 'result', 'totalDr', 'totalCr',
            'balanceSide', 'balanceAmt', 'cd', 'bd', 'runningTotal'
        ));
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
