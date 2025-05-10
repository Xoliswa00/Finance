<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    use HasFactory;
    protected $fillable = [
        'Category',
        'Description',
        'Amount',
        'bill_date',
        'Status',
        'paymentId',
        'Added_by',
        'category'
    ];
}
