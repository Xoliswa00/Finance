<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'Nature'
    ];

    public function nature()
    {
        return $this->belongsTo(Nature::class, 'Nature');
    }
}
