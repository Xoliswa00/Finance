<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_X extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name', 'description', 'Start_date', 'end_date', 'Actual', 'Budget', 'progress', 'Added_by'
    ];
    protected $table = 'Master_X';
}
