<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Goals extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'goal_category',
        'target_amount',
        'current_amount',
        'start_date',
        'end_date',
        'Added_by',
        "Status"
    ];
}
