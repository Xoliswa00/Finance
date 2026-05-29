<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'Nature',
        'Added_by',
    ];

    public function nature()
    {
        return $this->belongsTo(Nature::class, 'Nature');
    }
}
