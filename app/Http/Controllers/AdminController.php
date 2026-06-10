<?php

namespace App\Http\Controllers;

use App\Models\Activitylog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $threshold = now()->subMinutes(5);

        $onlineCount = Schema::hasColumn('users', 'last_seen')
            ? DB::table('users')->where('last_seen', '>=', $threshold)->count()
            : 0;

        // Daily activity (last 30 days)
        $activityCounts = Activitylog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Users registered by day of week
        $userStatsByDay = DB::select("
            SELECT
                CASE
                    WHEN DAYOFWEEK(created_at) = 1 THEN 'Sunday'
                    WHEN DAYOFWEEK(created_at) = 2 THEN 'Monday'
                    WHEN DAYOFWEEK(created_at) = 3 THEN 'Tuesday'
                    WHEN DAYOFWEEK(created_at) = 4 THEN 'Wednesday'
                    WHEN DAYOFWEEK(created_at) = 5 THEN 'Thursday'
                    WHEN DAYOFWEEK(created_at) = 6 THEN 'Friday'
                    WHEN DAYOFWEEK(created_at) = 7 THEN 'Saturday'
                END AS day_of_week,
                COUNT(*) AS user_count
            FROM users
            GROUP BY day_of_week
            ORDER BY DAYOFWEEK(created_at)
        ");

        $newUsersThisWeek = DB::table('users')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $newUsersLastWeek = DB::table('users')
            ->whereBetween('created_at', [now()->startOfWeek()->subWeek(), now()->endOfWeek()->subWeek()])
            ->count();

        $weekChange = $newUsersLastWeek > 0
            ? round((($newUsersThisWeek - $newUsersLastWeek) / $newUsersLastWeek) * 100, 1)
            : 0;

        $newUsersPerDay = DB::table('users')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as new_users')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $percentageChange = 0;
        if ($newUsersPerDay->count() > 1) {
            $latest   = $newUsersPerDay->last()->new_users;
            $previous = $newUsersPerDay[$newUsersPerDay->count() - 2]->new_users;
            $percentageChange = $previous > 0
                ? round((($latest - $previous) / $previous) * 100, 1)
                : 0;
        }

        $userCount = User::count();

        // Feature usage stats
        $featureStats = $this->featureStats();

        // Recent login attempts (last 10 failed)
        $recentFailedLogins = Schema::hasTable('login_attempts')
            ? DB::table('login_attempts')->where('succeeded', false)->orderByDesc('created_at')->limit(10)->get()
            : collect();

        return view('Admin.Dashboard', compact(
            'userCount', 'percentageChange', 'newUsersThisWeek', 'weekChange',
            'userStatsByDay', 'activityCounts', 'onlineCount', 'featureStats',
            'recentFailedLogins'
        ));
    }

    public function Users()
    {
        $friends = User::where('Role', 'friend')->withCount('activityLogs')->latest()->get();
        $admins  = collect();

        if (auth()->user()->Role !== 'friend') {
            $admins = User::whereNotIn('Role', ['friend'])->withCount('activityLogs')->latest()->get();
        }

        return view('Admin.Users.Users', compact('friends', 'admins'));
    }

    public function activityLog(Request $request)
    {
        $query = Activitylog::with('user')
            ->orderByDesc('created_at');

        if ($request->filled('user_id')) {
            $query->where('Added_by', $request->user_id);
        }

        if ($request->filled('page_filter')) {
            $query->where('page_visited', 'like', '%' . $request->page_filter . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs     = $query->paginate(50)->withQueryString();
        $users    = User::orderBy('name')->get(['id', 'name', 'Surname', 'email']);
        $topPages = Activitylog::selectRaw('page_visited, COUNT(*) as hits')
            ->groupBy('page_visited')
            ->orderByDesc('hits')
            ->limit(10)
            ->get();

        return view('Admin.ActivityLog', compact('logs', 'users', 'topPages'));
    }

    public function Onlineusers()
    {
        $threshold   = now()->subMinutes(5);
        $onlineUsers = DB::table('users')
            ->where('last_seen', '>=', $threshold)
            ->pluck('name');

        return response()->json(['online_users' => $onlineUsers]);
    }

    private function featureStats(): array
    {
        return [
            'total_users'         => User::count(),
            'active_30d'          => User::where('last_seen', '>=', now()->subDays(30))->count(),
            'onboarded'           => Schema::hasColumn('users', 'onboarded') ? User::where('onboarded', true)->count() : 0,
            'suspended'           => Schema::hasColumn('users', 'suspended_at') ? User::whereNotNull('suspended_at')->count() : 0,
            'total_transactions'  => DB::table('journal_entries')->count(),
            'total_budgets'       => DB::table('budgets')->count(),
            'used_transfers'      => \Illuminate\Support\Facades\Schema::hasTable('transfers')
                                        ? DB::table('transfers')->distinct('added_by')->count('added_by')
                                        : 0,
            'used_imports'        => 0,
            'page_views_today'    => Activitylog::whereDate('created_at', today())->count(),
            'page_views_week'     => Activitylog::where('created_at', '>=', now()->startOfWeek())->count(),
        ];
    }
}
