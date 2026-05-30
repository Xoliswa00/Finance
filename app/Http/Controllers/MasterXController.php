<?php

namespace App\Http\Controllers;

use App\Models\Master_X;
use App\Models\X_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterXController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        // Each Master_X row with totals aggregated from its x_items
        $masters = DB::table('Master_X as mx')
            ->select(
                'mx.id',
                'mx.Name',
                'mx.description',
                'mx.start_date',
                'mx.end_date',
                DB::raw('COALESCE(SUM(xi.budget), 0) as total_budget'),
                DB::raw('COALESCE(SUM(xi.actual), 0)  as total_actual')
            )
            ->leftJoin('x_items as xi', function ($join) {
                $join->on('xi.Master', '=', 'mx.id')
                     ->where('xi.status', '<>', 'Deleted');
            })
            ->where('mx.Added_by', $userId)
            ->groupBy('mx.id', 'mx.Name', 'mx.description', 'mx.start_date', 'mx.end_date')
            ->get();

        // All active sections (x_items), filtered to this user via the Master_X join
        $Section = X_item::select('x_items.*')
            ->join('Master_X', 'Master_X.id', '=', 'x_items.Master')
            ->where('Master_X.Added_by', $userId)
            ->where('x_items.status', '<>', 'Deleted')
            ->get();

        return view('Master.index', compact('masters', 'Section'));
    }

    public function create()
    {
        return view('Master.MasterCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name'        => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'Start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:Start_date',
            'Budget'      => 'required|numeric|min:0',
            'progress'    => 'required|numeric|min:0|max:100',
        ]);

        Master_X::create([
            'Name'        => $request->Name,
            'description' => $request->description,
            'Start_date'  => $request->Start_date,
            'end_date'    => $request->end_date,
            'budget'      => $request->Budget,
            'progress'    => $request->progress,
            'Added_by'    => Auth::id(),
        ]);

        return redirect()->route('section')->with('success', 'Master goal created successfully.');
    }

    public function show($id)
    {
        $transactions = DB::table('transactions')
            ->select('transactions.*', 'x_items.section', 'x_items.id as item_id', 'x_items.Master')
            ->join('categories', 'transactions.Category', '=', 'categories.id')
            ->join('x_items', function ($join) {
                $join->on('categories.category', 'like', DB::raw("CONCAT('Master : ', x_items.section)"));
            })
            ->where('x_items.id', $id)
            ->get();

        $holding = DB::table('holdings')
            ->select('holdings.*')
            ->join('categories', 'holdings.Category', '=', 'categories.id')
            ->join('x_items', function ($join) {
                $join->on('categories.category', 'like', DB::raw("CONCAT('Master : ', x_items.section)"));
            })
            ->where('x_items.id', $id)
            ->get();

        $sum = DB::table('holdings')
            ->select(DB::raw('SUM(holdings.Amount) as total'))
            ->join('categories', 'holdings.Category', '=', 'categories.id')
            ->join('x_items', function ($join) {
                $join->on('categories.category', 'like', DB::raw("CONCAT('Master : ', x_items.section)"));
            })
            ->where('x_items.id', $id)
            ->where('holdings.Status', 'Holding')
            ->get();

        $Section = X_item::where('id', $id)->get();

        return view('Master.Sections', compact('transactions', 'holding', 'Section', 'sum'));
    }

    public function edit(Master_X $master_X)
    {
        //
    }

    public function update(Request $request, Master_X $master_X)
    {
        //
    }

    public function destroy(Master_X $master_X)
    {
        //
    }
}
