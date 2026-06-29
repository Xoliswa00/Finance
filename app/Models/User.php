<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Models\Activity;
use Spatie\MediaLibrary\HasMedia;




class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'Surname', 'Mobile', 'Location',
        'Role', 'last_seen', 'onboarded',
        'suspended_at', 'suspension_reason', 'login_attempts_count', 'locked_until', 'force_logout_at',
    ];

    protected $casts = [
        'email_verified_at'    => 'datetime',
        'suspended_at'         => 'datetime',
        'locked_until'         => 'datetime',
        'force_logout_at'      => 'datetime',
    ];

    public function isNewUser(): bool
    {
        return !$this->onboarded;
    }

    public function hasRole($role): bool
    {
        return $this->Role === $role;
    }

    public function isAdmin(): bool
    {
        return in_array($this->Role, ['Master', 'AdmiX']);
    }

    public function isSuspended(): bool
    {
        return $this->suspended_at !== null;
    }

    public function isLocked(): bool
    {
        return $this->locked_until !== null && $this->locked_until->isFuture();
    }

    public function notes()
    {
        return $this->hasMany(\App\Models\UserNote::class)->latest();
    }

    public function loginAttempts()
    {
        return $this->hasMany(\App\Models\LoginAttempt::class)->latest();
    }

    public function activityLogs()
    {
        return $this->hasMany(\App\Models\Activitylog::class, 'Added_by')->latest();
    }

    public function financialYears()
    {
        return $this->hasMany(\App\Models\FinancialYear::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

}
