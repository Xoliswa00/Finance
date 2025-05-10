<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class X_item extends Model
{
    use HasFactory;



    protected $fillable = [
        'section', 'description', 'nature', 'budget', 'actual', 'start_date', 'end_date', 'status', 'progress', 'Master'
    ];

    protected $table='x_items';
}
