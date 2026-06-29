<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    protected $fillable = ['user_id', 'label', 'start_date', 'end_date', 'status'];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function journalEntries()
    {
        return $this->hasMany(\App\Models\JournalEntry::class, 'financial_year_id');
    }

    /**
     * Derive the FY label and boundaries for any given date using the July-June rule.
     * FY2027 = 1 Jul 2026 – 30 Jun 2027
     */
    public static function forDate(Carbon $date): array
    {
        $fyYear = $date->month >= 7 ? $date->year + 1 : $date->year;

        return [
            'label'      => 'FY' . $fyYear,
            'start_date' => Carbon::create($fyYear - 1, 7, 1)->toDateString(),
            'end_date'   => Carbon::create($fyYear, 6, 30)->toDateString(),
            'fy_year'    => $fyYear,
        ];
    }

    /**
     * Return the active FinancialYear for a user, creating it if missing.
     */
    public static function activeFor(int $userId): self
    {
        $fy = static::forDate(now());

        return static::firstOrCreate(
            ['user_id' => $userId, 'label' => $fy['label']],
            [
                'start_date' => $fy['start_date'],
                'end_date'   => $fy['end_date'],
                'status'     => 'active',
            ]
        );
    }
}
