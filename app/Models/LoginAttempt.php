<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'email', 'ip_address', 'succeeded'];

    protected $casts = [
        'succeeded'  => 'boolean',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Unknown']);
    }
}
