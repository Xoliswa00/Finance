<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cards extends Model
{
    use HasFactory;
    protected $fillable = [
        'Type',
        'CardNumber',
        'ExpiryDate',
        'CVC',
        'Cardholder',
        'Status',
        'Added_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Added_by');
    }
}
