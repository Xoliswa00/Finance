<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade as PDF;

use App\Models\Budget;
use App\Models\Milestone;
use App\Models\Master_X;
use App\Models\cards;
use App\Models\category;
use App\Models\Goals;
use App\Models\Journal_entry;
use App\Models\X_item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Cache\RateLimiting\Limit;
use PHPUnit\TextUI\Configuration\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination;
use illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\View; 
use Illuminate\Database\Eloquent\Model;



use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now();
        $lastMonth = $currentMonth->copy()->subMonth();
     $twoMonthsAgo = $currentMonth->copy()->subMonths(2);
     $thereMonthsAgo = $currentMonth->copy()->subMonths(3);


        $budgets = Budget::where("Added_by", "=", auth()->user()->id)->where("Status","=","Planning")->paginate(5);
        $cards = cards::where("Added_by", "=", auth()->user()->id)->get();
        $main = cards::where("Added_by",'=', auth()->user()->id)->where("Type","=", "Debit Card")->first();
        $transactions = Transaction::where("Added_by", "=", auth()->user()->id)->where('Status', '!=','Deleted')->where('updated_at','>',$lastMonth)->latest()->orderBy('created_at')->paginate(15);
        $balance=category::select('Balance')->where("category","=","Bank (Dr)")->where("Added_by", "=", auth()->user()->id)->get();
        $CreditB=category::select('Balance')->where("category","=","Credit Card")->where("Added_by", "=", auth()->user()->id)->get();


        return view('transactions.index', compact('budgets','transactions','cards','main','balance' ,'CreditB'));
    }

    public function Dashboard()
    {
        $transactions = Transaction::all()->where("Added_by","=",auth()->user()->id)->whereNotBetween( 'Status',['Deleted'] );
        return view('transactions.Dashboard', compact('transactions'));
    }

    public function create()
    {
        $category = Category::where("Added_by", "=", auth()->user()->id)
        ->where('category', 'NOT LIKE', '%Goal :%')
        ->get();
                $cards=cards::all()->where("Added_by","=",auth()->user()->id);
        $action="No";
        return view('transactions.create',compact('category','cards','action'));
    }

    public function store(Request $request)
    {

         $userRegMonth = Carbon::parse(auth()->user()->created_at)->month;

    // Parse the bill_date from the request input
    $transactionDate = Carbon::parse($request->input('bill_date'));
    $transactionMonth = $transactionDate->month;

    // Calculate the financial year based on the user's registration month
    if ($transactionMonth >= $userRegMonth) {
        $financialYear = $transactionDate->year;
    } else {
        $financialYear = $transactionDate->year - 1;
    }
        $transaction = new Transaction;

        $transaction->Action = $request->input('Action');
        $transaction->category = $request->input('category');
        $transaction->Method = $request->input('Method');
        $transaction->description = $request->input('description');
        $transaction->amount = $request->input('amount');
        $transaction->bill_date = $request->input('bill_date');
        $transaction->Invoice_slip = $request->input('Invoice_slip');
          $transaction->FY = $financialYear;

        $transaction->added_by = auth()->user()->id;
        
        $transaction->save();
        $this->Journals();

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $categories=category::all();
        return view('transactions.edit', compact('transaction','categories'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->category = $request->input('category');
        $transaction->description = $request->input('description');
        $transaction->amount = $request->input('amount');
        $transaction->bill_date = $request->input('bill_date');
        $transaction->added_by = auth()->user()->id;

        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->Status="Deleted";
        $transaction->save();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
    public function Balance($category, $amount)
    {
        $balance = category::findOrFail($category);
    
        // Check if the category contains the word "Goal"
        if (strpos($balance->category, 'Goal') !== false) {
            // Extract the title after "Goal :"
            $title = trim(substr($balance->category, strpos($balance->category, ':') + 1));
    
            // Find the goal based on the extracted title
            $result = DB::table('Goals')
                ->select('id')
                ->where('title', 'LIKE', '%' . $title . '%')
                ->get();
    
            if ($result->isNotEmpty()) {
                $this->Updat($amount, $result[0]->id);
            } else {
                // Handle the case when no matching goal is found
            }
        } else {
            // Handle the case when the category does not contain "Goal"
            $result = DB::table('Goals')
                ->select('*')
                ->where('title', '=', $balance->category)
                ->get();
    
            
        }


        //updating Master Goals

        if (strpos($balance->category, 'Master') !== false) {
            // Extract the title after "Goal :"
            $master = trim(substr($balance->category, strpos($balance->category, ':') + 1));
    
            // Find the goal based on the extracted title
            $results = DB::table('x_items')
                ->select('id')
                ->where('Section', 'LIKE', '%' . $master . '%')
                ->get();
                
    
            if ($results->isNotEmpty()) {
                $this->Master($amount, $results[0]->id);
            }
        }












    
        // Update the balance
        $balance->Balance = $balance->Balance + $amount;
        $balance->save();
    }
    public function Master($amount,$sections){
            $section=X_item::findorfail($sections);
        $Actual=$section->Actual+$amount;
        $section->Actual=$Actual;
        $section->save();

        $master=Master_X::findorfail($section->Master);
        $master->Actual+=$amount;
        $master->save();



    }



    
    public function Journals()
    {
        $Kido=  Transaction::where("Added_by","=",auth()->user()->id)->latest()->first();;
     

        $nature = Category::where("Added_by", "=", auth()->user()->id)->where('id', '=', $Kido->Category)->first();

        
        $Bank = Category::where("Added_by", "=", auth()->user()->id)->where('category', '=', 'Bank (Dr)')->first();
         $effect =1;

        if($Kido->Action=="Paid"){
            //Crediting bank account, and DR other account
           
            if($nature->Nature=="Current Assets" || $nature->Nature=="Non-Current Assets" || $nature->Nature=="Expenses" || $nature->Nature=="Drawings" ){





                $effect=1;
            }elseif($nature->Nature=="Non-Current Liabilities" || $nature->Nature=="Current Liabilities" || $nature->Nature=="Income" || $nature->Nature=="Capital"  ){



                $effect=-1;
            }


            
            $JR = new Journal_entry;
            $JR->Account=$Kido->Category;
            $JR->Effect="Dr";
            $JR->Amount=$Kido->Amount;
            $JR->transaction_id=$Kido->id;
            $JR->Status="Paid";
            $JR->save();

            $this->Balance($nature->id,($Kido->Amount)*$effect);

            $JR2 = new Journal_entry;
            $JR2->Account="Bank (Dr)";
            $JR2->Effect="Cr";
            $JR2->Amount=$Kido->Amount;
            $JR2->transaction_id=$Kido->id;
            $JR2->Status="Paid";
            $JR2->save();

            $this->Balance($Bank->id,($Kido->Amount)*-1);


    
    



        }else{
            $Kido=DB::table('Transactions')->where("Added_by","=",auth()->user()->id)->latest()->first();
          
            if($nature->Nature=="Current Assets" || $nature->Nature=="Non-Current Assets" || $nature->Nature=="Expenses" || $nature->Nature=="Drawings" ){
                $effect=-1;
            }elseif($nature->Nature=="Non-Current Liabilities" || $nature->Nature=="Current Liabilities" || $nature->Nature=="Income" || $nature->Nature=="Capital"  ){
              $effect=1;
            }

            $JR = new Journal_entry;
            $JR->Account=$Kido->Category;
            $JR->Effect="Cr";
            $JR->Amount=$Kido->Amount;
            $JR->transaction_id=$Kido->id;
            $JR->Status="Paid";
            $JR->save();

   

            $this->Balance($nature->id,($Kido->Amount)*$effect);

            $JR2 = new Journal_entry;
            $JR2->Account="Bank (Dr)";
            $JR2->Effect="Dr";
            $JR2->Amount=$Kido->Amount;
            $JR2->transaction_id=$Kido->id;
            $JR2->Status="Paid";
            $JR2->save();

            $this->Balance($Bank->id,$Kido->Amount);


    
    

        }

    




      
    }


    public function calculateDuration($Start, $end)
        {
            $startDate = Carbon::parse($Start);
            $endDate = Carbon::parse($end);
            $duration = $startDate->diffInMonths($endDate) + 1; // Add 1 to include the start month

            return $duration;

        }
        public function Updat($amount, $goal)
        {
           $Goals =Goals::findorFail($goal);
           if($Goals->goal_category=="Repayment"){
            $Effect=-1;

           }else{
            $Effect=1;

           }

             $current=$Goals->current_amount+($amount*$Effect);

             if($current>=$Goals->target_amount){
                $Goals->current_amount =$current;
                $Goals->Status="Completed";
           
                $Goals->save();


             }
             else{
                $Goals->current_amount =$current;
             
           
                $Goals->save();
             }
           
            $this->Milestones($goal);
        
            
        }
      
        

        public function Milestones( $goalId)
        {               
            $goal = Goals::findOrFail($goalId);

            // Calculate the total target amount and the remaining target amount
            if($goal->current_amount>=$goal->target_amount){
                $milestones = Milestone::where('goal_id', $goalId)->get();
                foreach ($milestones as $milestone) {
                    $milestone->milestone_status = 'Achieved';
                }
                $milestone->save();
                

            }else {
                $milestones = Milestone::where('goal_id', $goalId)->where('milestone_amount','<=',$goal->current_amount)->orderBy('milestone_number')->get();
                foreach ($milestones as $milestone) {
                    if ($goal->current_amount >= $milestone->milestone_amount) {
                        $milestone->milestone_status = 'Achieved';
                    } else {
                        $milestone->milestone_status = 'Pending';
                    }
                    $milestone->save();
                }
            
            }
          
            return redirect()->route('goals.index')
            ->with('success', 'Goal updated successfully.');

          
        }
        
        public function download()
        {
            $user = auth()->user(); // Get the authenticated user
            $currentMonth = Carbon::now()->format('Y-m'); // Get the current month in 'Y-m' format
        
            $transactions = Transaction::where('Added_by', $user->id)
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->get();
        
            // Return a view or generate a PDF with the $transactions data
          //  $pdf = PDF::loadView('pdf.transaction-statement', compact('transactions'));
        
          //  return $pdf->download('transaction-statement.pdf');
        }
        

}
