<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\cards;
use App\Models\category;
use App\Models\Goals;
use App\Models\Milestone;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {




                $balance=category::select('Balance')->where("category","=","Bank (Dr)")->where("Added_by", "=", auth()->user()->id)->get();
                $CreditB=category::select('Balance')->where("category","=","Credit Card")->where("Added_by", "=", auth()->user()->id)->get();
                $goals = Goals::where("Added_by", "=", auth()->user()->id)->where('Status',"=",'In-Progress')->orderBy('end_date')->Paginate(5);
                $cards = cards::where("Added_by", "=", auth()->user()->id)->get();
                $main = cards::where("Added_by",'=', auth()->user()->id)->where("Type","=", "Debit Card")->first();

                $budget = DB::table('budgets')
            ->selectRaw('
                SUM(CASE WHEN categories.Nature = "Income" THEN budgets.Amount ELSE 0 END) AS income_budgeted,
                SUM(CASE WHEN categories.Nature like "%Assets%" THEN budgets.Amount ELSE 0 END) AS Investment,
                SUM(CASE WHEN categories.Nature = "Expenses" OR categories.Nature = "Current Liabilities" THEN budgets.Amount ELSE 0 END) AS expense_budgeted
            ')
            ->join('categories', 'budgets.category', '=', 'categories.id')
            ->where('budgets.Status', 'Planning')
            ->where('budgets.Added_by', auth()->user()->id)
            ->get();
         

             $actual = DB::table('budgets')
            ->selectRaw('
                SUM(CASE WHEN categories.Nature = "Income" THEN IFNULL(budgets.Limit, 0) ELSE 0 END) AS income_actual,
                SUM(CASE WHEN categories.Nature like "%Assets%" THEN budgets.Amount ELSE 0 END) AS Investment,
                SUM(CASE WHEN categories.Nature = "Expenses" OR categories.Nature = "Current Liabilities" THEN IFNULL(budgets.Limit, 0) ELSE 0 END) AS expense_actual
            ')
            ->join('categories', 'budgets.category', '=', 'categories.id')
            ->where('budgets.Status', 'Planning')
            ->where('budgets.Added_by', auth()->user()->id)
            ->get();

            $data = Transaction::select(
                DB::raw('SUM(CASE WHEN Action IN ("Paid", "Bought") THEN Amount ELSE 0 END) as Outgoing'),
                DB::raw('SUM(CASE WHEN Action IN ("Received", "Earned") THEN Amount ELSE 0 END) as Incoming'),
                DB::raw('Date_format(updated_at,"%Y-%m") as Month')
            )
            ->groupBy('Month')
            ->where('Added_by', auth()->user()->id)
            ->get();

            $labels = $data->pluck('Month');
            $outgoing = $data->pluck('Outgoing');
            $incoming = $data->pluck('Incoming');


            $budgetDates =Budget::select('Description','due_date')->Where('Status','=','Planning')->where('budgets.Added_by', auth()->user()->id)->orderby('due_date')->Paginate(4); ;

            $currentDate = Carbon::now();
            $startOfMonth = $currentDate->startOfMonth();

            $milestonedates = Milestone::join('goals', 'goals.id', '=', 'milestones.goal_id')->select('goals.title','milestones.due_date','milestone_number')->where('milestones.milestone_status', 'Pending')
            ->where('goals.Status', 'In-Progress')
            ->whereBetween('milestones.due_date', [$startOfMonth, $currentDate])
            ->where('Added_by', auth()->user()->id)
            ->orderBy('goals.title', 'ASC')
            ->get();

            $CurrentB = Budget::all()->where("Added_by", "=", auth()->user()->id)->where("Status","=","Planning")->sortby('due_date');


         



        return view('home',compact('balance' ,'CreditB','goals','main','cards','budget','actual','labels','outgoing', 'incoming','budgetDates','milestonedates','CurrentB'));
    }


    public function Category( $user){

        /**Create the following for each new user register controller */

        DB::table('categories')->insert([

            ['category'=>'Loan ABC Company','Nature'=>'Non-Current Liabilities','Added_by'=>$user],
            ['category'=>'Loan XXX Company','Nature'=>'Non-Current Liabilities','Added_by'=>$user],
            ['category'=>'Mortage bond','Nature'=>'Non-Current Liabilities','Added_by'=>$user],
            ['category'=>'Credit Card','Nature'=>'Current Liabilities','Added_by'=>$user],
            ['category'=>'Bank (Dr)','Nature'=>'Current Assets','Added_by'=>$user],
     
            ['category'=>'Accrued Expenses','Nature'=>'Current Liabilities','Added_by'=>$user],
            ['category'=>'Income Recived in-advance','Nature'=>'Current Liabilities','Added_by'=>$user],
            ['category'=>'Other Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Sales','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Rent Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Interest Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Profit on Asset Desposal','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Salary Earned','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Gift Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Allowance Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Rent Apartment','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Salary and Wages','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Stationery','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Fuel','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Groceries','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Repairs','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Telephone and Connection','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Water and Electricity','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Entertainment','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Sundry Expenses','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Transport','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Business: Cash drawings ','Nature'=>'Drawings','Added_by'=>$user],
            ['category'=>'Business: Stock drawings ','Nature'=>'Drawings','Added_by'=>$user],
            ['category'=>'Business: Cash Capital ','Nature'=>'Capital','Added_by'=>$user],
            ['category'=>'Equipment','Nature' =>'Non-Current Assets','Added_by'=>$user],
            ['category'=>'Vehicle','Nature' =>'Non-Current Assets','Added_by'=>$user],
            ['category'=>'Land and Buildings','Nature' =>'Non-Current Assets','Added_by'=>$user],
            ['category'=>'Debtor Control','Nature' =>'Current Assets','Added_by'=>$user],
            ['category'=>'Prepared Expenses','Nature' =>'Current Assets','Added_by'=>$user],


            
        ]   );
    }
}
