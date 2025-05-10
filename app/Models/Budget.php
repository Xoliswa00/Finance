<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;


class Budget extends Model
{
    use HasFactory;
    protected $fillable = [
        'Category',
        'Description',
        'Amount',
        'Limit',
        'due_date',
        'Recurring',
        'SubItems',
        'Priority',
        'Status',
        'Added_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Added_by');
    }

    public function subitems()
    {
        return $this->hasMany(BudgetSubitem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
