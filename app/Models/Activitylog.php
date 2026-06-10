<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activitylog extends Model
{
    use HasFactory;

    protected $fillable = ['Added_by', 'page_visited', 'ip_address', 'user_agent', 'referrer', 'session_id'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'Added_by');
    }
}
