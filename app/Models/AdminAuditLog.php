<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['admin_id', 'action', 'target_type', 'target_id', 'details', 'ip_address'];

    protected $casts = [
        'details'    => 'array',
        'created_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id')->withDefault(['name' => 'Unknown']);
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    public static function record(string $action, string $targetType = null, int $targetId = null, array $details = [], string $ip = null): void
    {
        static::create([
            'admin_id'    => auth()->id(),
            'action'      => $action,
            'target_type' => $targetType,
            'target_id'   => $targetId,
            'details'     => $details ?: null,
            'ip_address'  => $ip ?? request()->ip(),
        ]);
    }
}
