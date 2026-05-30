<?php

namespace App\Http\Controllers;

use App\Http\Controllers\OnboardingController;
use App\Mail\BudgetReminderMail;
use App\Models\Budget;
use App\Models\cards;
use App\Models\category;
use App\Models\Goals;
use App\Models\Milestone;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = auth()->user()->id;

        $balance = category::select('Balance')
            ->where('category', 'Bank (Dr)')
            ->where('Added_by', $userId)
            ->get();

        $CreditB = Category::select('Balance')
            ->where('category', 'Credit Card')
            ->where('Added_by', $userId)
            ->get();

        $goals = Goals::where('Added_by', $userId)
            ->where('Status', 'In-Progress')
            ->orderBy('end_date')
            ->paginate(5);

        $cards     = cards::where('Added_by', $userId)->get();
        $main      = cards::where('Added_by', $userId)->where('Type', 'Debit Card')->first();

        $budget = DB::table('budgets')
            ->selectRaw('
                SUM(CASE WHEN categories.Nature = "Income" THEN budgets.Amount ELSE 0 END) AS income_budgeted,
                SUM(CASE WHEN categories.Nature LIKE "%Assets%" THEN budgets.Amount ELSE 0 END) AS Investment,
                SUM(CASE WHEN categories.Nature = "Expenses" OR categories.Nature = "Current Liabilities" THEN budgets.Amount ELSE 0 END) AS expense_budgeted
            ')
            ->join('categories', 'budgets.category', '=', 'categories.id')
            ->where('budgets.Status', 'Planning')
            ->where('budgets.Added_by', $userId)
            ->get();

        $actual = DB::table('budgets')
            ->selectRaw('
                SUM(CASE WHEN categories.Nature = "Income" THEN IFNULL(budgets.Limit, 0) ELSE 0 END) AS income_actual,
                SUM(CASE WHEN categories.Nature LIKE "%Assets%" THEN budgets.Amount ELSE 0 END) AS Investment,
                SUM(CASE WHEN categories.Nature = "Expenses" OR categories.Nature = "Current Liabilities" THEN IFNULL(budgets.Limit, 0) ELSE 0 END) AS expense_actual
            ')
            ->join('categories', 'budgets.category', '=', 'categories.id')
            ->where('budgets.Status', 'Planning')
            ->where('budgets.Added_by', $userId)
            ->get();

        $data = Transaction::select(
                DB::raw('SUM(CASE WHEN Action IN ("Paid", "Bought") THEN Amount ELSE 0 END) as Outgoing'),
                DB::raw('SUM(CASE WHEN Action IN ("Received", "Earned") THEN Amount ELSE 0 END) as Incoming'),
                DB::raw('DATE_FORMAT(updated_at, "%Y-%m") as Month')
            )
            ->where('Added_by', $userId)
            ->groupBy('Month')
            ->get();

        $labels   = $data->pluck('Month');
        $outgoing = $data->pluck('Outgoing');
        $incoming = $data->pluck('Incoming');

        $budgetDates = Budget::select('Description', 'due_date')
            ->where('Status', 'Planning')
            ->where('Added_by', $userId)
            ->orderBy('due_date')
            ->paginate(4);

        $now          = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        $milestonedates = Milestone::join('goals', 'goals.id', '=', 'milestones.goal_id')
            ->select('goals.title', 'milestones.due_date', 'milestone_number')
            ->where('milestones.milestone_status', 'Pending')
            ->where('goals.Status', 'In-Progress')
            ->whereBetween('milestones.due_date', [$startOfMonth, $now])
            ->where('goals.Added_by', $userId)
            ->orderBy('goals.title')
            ->get();

        $CurrentB = Budget::where('Added_by', $userId)
            ->where('Status', 'Planning')
            ->orderBy('due_date')
            ->get();

        $checklist = auth()->user()->onboarded
            ? null
            : OnboardingController::checklistProgress();

        // ── Send reminder email at most once per calendar day ──────────────────
        $this->sendDailyReminderIfNeeded($userId);

        return view('home', compact(
            'balance', 'CreditB', 'goals', 'main', 'cards',
            'budget', 'actual', 'labels', 'outgoing', 'incoming',
            'budgetDates', 'milestonedates', 'CurrentB', 'checklist'
        ));
    }

    private function sendDailyReminderIfNeeded(int $userId): void
    {
        $sessionKey = 'reminder_sent_' . $userId . '_' . today()->toDateString();

        if (session()->has($sessionKey)) {
            return;
        }

        $in7Days = now()->addDays(7);

        $upcomingBudgets = Budget::where('Added_by', $userId)
            ->where('Status', 'Planning')
            ->whereBetween('due_date', [now(), $in7Days])
            ->orderBy('due_date')
            ->get();

        $upcomingMilestones = Milestone::join('goals', 'goals.id', '=', 'milestones.goal_id')
            ->select('goals.title', 'milestones.due_date', 'milestones.milestone_number')
            ->where('milestones.milestone_status', 'Pending')
            ->where('goals.Status', 'In-Progress')
            ->where('goals.Added_by', $userId)
            ->whereBetween('milestones.due_date', [now(), $in7Days])
            ->orderBy('milestones.due_date')
            ->get();

        if ($upcomingBudgets->isEmpty() && $upcomingMilestones->isEmpty()) {
            return;
        }

        try {
            Mail::to(auth()->user()->email)
                ->send(new BudgetReminderMail(auth()->user(), $upcomingBudgets, $upcomingMilestones));
        } catch (\Throwable $e) {
            // Never crash the dashboard over a failed email
            logger()->warning('Reminder email failed for user ' . $userId . ': ' . $e->getMessage());
        }

        session()->put($sessionKey, true);
    }
}
