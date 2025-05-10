<?php

namespace App\Http\Controllers;

use App\Models\Activitylog;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $threshold = now()->subMinutes(5); // Adjust the threshold as needed

        $onlineUsers = DB::table('users')
        ->where('last_seen', '>=', $threshold)
        ->pluck('name');
        // Daily user activity
        $activityCounts = Activitylog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->get();




        //Get users by the day of the week
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
    FROM
        users
    GROUP BY
        day_of_week
    ORDER BY
        DAYOFWEEK(created_at)
");
        // Get the total new users this week
        $newUsersThisWeek = DB::table('users')
            ->select(DB::raw('COUNT(*) as new_users'))
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->first()
            ->new_users;

        // Get the total new users last week
        $newUsersLastWeek = DB::table('users')
            ->select(DB::raw('COUNT(*) as new_users'))
            ->whereBetween('created_at', [now()->startOfWeek()->subWeek(), now()->endOfWeek()->subWeek()])
            ->first()
            ->new_users;

        // Calculate the week percentage change
        $weekChange = 0;
        if ($newUsersLastWeek !== 0) {
            $weekChange = (($newUsersThisWeek - $newUsersLastWeek) / $newUsersLastWeek) * 100;
        }




        // Get the number of new users each day
        $newUsersPerDay = DB::table('users')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as new_users'))
            ->groupBy('date')
            ->get();



        // Check if there are records
        if ($newUsersPerDay->count() > 1) {
            // Get the total number of new users for the most recent day
            $latestDayUsers = $newUsersPerDay->last()->new_users;

            // Get the number of new users for the previous day
            $previousDayUsers = $newUsersPerDay[count($newUsersPerDay) - 2]->new_users;

            // Calculate the percentage change
            if ($previousDayUsers !== 0) {
                $percentageChange = (($latestDayUsers - $previousDayUsers) / $previousDayUsers) * 100;
               
            } else {
                // Handle the case where the previous day had 0 users (to avoid division by zero)
               
            }
        } else {
            // If there's not enough data, indicate that the percentage change is not applicable
    
        }


        //count users
        $userCount = User::count();
        return view('Admin.Dashboard',compact('userCount','percentageChange','newUsersThisWeek','weekChange','userStatsByDay','activityCounts'));
    }
    public function Users()
    {

      


        //retrive all users that are friends
       // TODO make sure other sensistive information is not displayed
        $friends= User::where('Role','friend')->get();

        if(auth()->user()->Role !="friend"){
            $admins= User::wherenot('Role','friend')->get();

        }
       
   

        return view('Admin.Users.Users',compact('friends','admins'));
    }

    public function Onlineusers()
    {
        // Logic to fetch and return online users data as JSON
         //get users that are online
         $threshold = now()->subMinutes(5); // Adjust the threshold as needed
        $onlineUsers = DB::table('users')
        ->where('last_seen', '>=', $threshold)
        ->pluck('name');
        return response()->json(['online_users' => $onlineUsers]);
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
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
    public function updateLastSeen()
    {
        $user = new User();

        $user->last_seen=Now();
        $user->save();
    }
}
