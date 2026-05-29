<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_account',
        'to_account',
        'amount',
        'transfer_date',
        'description',
        'reference',
        'added_by',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'amount'        => 'decimal:2',
    ];

    public function fromCategory()
    {
        return $this->belongsTo(Category::class, 'from_account');
    }

    public function toCategory()
    {
        return $this->belongsTo(Category::class, 'to_account');
    }
}
