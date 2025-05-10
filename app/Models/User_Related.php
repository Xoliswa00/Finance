<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Related extends Model
{
    use HasFactory;
    protected $table = 'user_related';
    protected $fillable = ['name', 'relation', 'id_user', 'added_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
