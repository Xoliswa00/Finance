<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget_subitems extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'description',
        'amount',
        'limit',
        'due_date',
        'recurring',
        'subitems',
        'priority',
        'status',
        'budget_id'
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
