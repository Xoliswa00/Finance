<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Budget;
use App\Models\Goals;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Already onboarded — go to dashboard
        if (auth()->user()->onboarded) {
            return redirect()->route('home');
        }

        return view('onboarding.wizard');
    }

    public function complete(Request $request)
    {
        auth()->user()->update(['onboarded' => true]);

        return redirect()->route('home')->with('success', 'Welcome to Bright Finance! Your account is all set up.');
    }

    /**
     * Returns the "getting started" checklist progress for the current user.
     * Used by the dashboard widget.
     */
    public static function checklistProgress(): array
    {
        $userId = auth()->id();

        $hasTransaction = Transaction::where('Added_by', $userId)->exists();
        $hasBudget      = Budget::where('Added_by', $userId)->exists();
        $hasGoal        = Goals::where('Added_by', $userId)->exists();

        $steps = [
            [
                'key'       => 'account',
                'label'     => 'Create your account',
                'done'      => true,
                'route'     => null,
                'icon'      => 'person_add',
            ],
            [
                'key'       => 'transaction',
                'label'     => 'Record your first transaction',
                'done'      => $hasTransaction,
                'route'     => 'transactions.create',
                'icon'      => 'swap_horiz',
                'action'    => 'Add Transaction',
            ],
            [
                'key'       => 'budget',
                'label'     => 'Create your first budget',
                'done'      => $hasBudget,
                'route'     => 'budgets.create',
                'icon'      => 'account_balance_wallet',
                'action'    => 'Create Budget',
            ],
            [
                'key'       => 'goal',
                'label'     => 'Set a savings goal',
                'done'      => $hasGoal,
                'route'     => 'goals.create',
                'icon'      => 'flag',
                'action'    => 'Set a Goal',
            ],
        ];

        $completed = collect($steps)->filter(fn($s) => $s['done'])->count();

        return [
            'steps'    => $steps,
            'total'    => count($steps),
            'done'     => $completed,
            'pct'      => round(($completed / count($steps)) * 100),
            'complete' => $completed === count($steps),
        ];
    }
}
