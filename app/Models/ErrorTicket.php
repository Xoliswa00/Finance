<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorTicket extends Model
{
    //
    // app/Models/ErrorTicket.php
protected $fillable = [
    'error_type', 'message', 'file', 'line',
    'url', 'ip_address', 'user_agent', 'user_id', 'is_resolved'
];

}
