<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transfers = Transfer::with(['fromCategory', 'toCategory'])
            ->where('added_by', Auth::id())
            ->orderByDesc('transfer_date')
            ->paginate(20);

        return view('Transfers.index', compact('transfers'));
    }

    public function create()
    {
        // Only balance-sheet accounts make sense as transfer endpoints
        $accounts = Category::where('Added_by', Auth::id())
            ->whereNotIn('Nature', ['Expenses', 'Income', 'Drawings'])
            ->orderBy('Nature')
            ->orderBy('category')
            ->get();

        return view('Transfers.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_account'  => 'required|integer|different:to_account',
            'to_account'    => 'required|integer',
            'amount'        => 'required|numeric|min:0.01',
            'transfer_date' => 'required|date',
            'description'   => 'nullable|string|max:500',
            'reference'     => 'nullable|string|max:200',
        ]);

        $userId = Auth::id();

        $from = Category::where('id', $request->from_account)->where('Added_by', $userId)->firstOrFail();
        $to   = Category::where('id', $request->to_account)->where('Added_by', $userId)->firstOrFail();
        $amt  = (float) $request->amount;

        DB::transaction(function () use ($request, $from, $to, $amt, $userId) {

            // Record the transfer
            Transfer::create([
                'from_account'  => $from->id,
                'to_account'    => $to->id,
                'amount'        => $amt,
                'transfer_date' => $request->transfer_date,
                'description'   => $request->description,
                'reference'     => $request->reference,
                'added_by'      => $userId,
            ]);

            // Update balances:
            // Source account loses money (Cr for asset accounts, Dr for liability accounts)
            // Destination account gains money
            $this->adjustBalance($from, -$amt);  // money leaves source
            $this->adjustBalance($to,   +$amt);  // money arrives at destination
        });

        return redirect()->route('transfers.index')
            ->with('success', "Transfer of R " . number_format($amt, 2) . " from {$from->category} to {$to->category} recorded.");
    }

    public function destroy(Transfer $transfer)
    {
        if ($transfer->added_by !== Auth::id()) {
            abort(403);
        }

        DB::transaction(function () use ($transfer) {
            // Reverse the balance changes
            $from = Category::findOrFail($transfer->from_account);
            $to   = Category::findOrFail($transfer->to_account);

            $this->adjustBalance($from, +$transfer->amount);
            $this->adjustBalance($to,   -$transfer->amount);

            $transfer->delete();
        });

        return redirect()->route('transfers.index')->with('success', 'Transfer reversed and deleted.');
    }

    // Adjusts category Balance — positive delta adds, negative subtracts
    private function adjustBalance(Category $category, float $delta): void
    {
        $category->Balance = ($category->Balance ?? 0) + $delta;
        $category->save();
    }
}
