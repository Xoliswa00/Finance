<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'milestone_number',
        'milestone_amount',
        'milestone_status',
        'due_date', // Ensure that due_date is fillable
    ];
    protected $casts = [
        'due_date' => 'date', // Tell Eloquent to treat 'due_date' as a date field
    ];
}
