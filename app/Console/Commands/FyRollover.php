<?php

namespace App\Console\Commands;

use App\Models\FinancialYear;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FyRollover extends Command
{
    protected $signature = 'fy:rollover
                            {--seed : Also seed FY records for users who have none}
                            {--force : Process all users regardless of account age}
                            {--dry-run : Show what would happen without making changes}';

    protected $description = 'Roll over financial years (July-June) for eligible users. Run on 1 July annually.';

    public function handle(): int
    {
        $dryRun  = $this->option('dry-run');
        $force   = $this->option('force');
        $seed    = $this->option('seed');
        $today   = now();
        $newFy   = FinancialYear::forDate($today);

        $this->info("Financial Year Rollover — target: {$newFy['label']} ({$newFy['start_date']} → {$newFy['end_date']})");
        $dryRun && $this->warn('DRY RUN — no changes will be saved.');

        // Eligible = registered at least 1 year ago, OR --force flag
        $users = User::when(! $force, fn ($q) => $q->where('created_at', '<=', $today->copy()->subYear()))
                     ->get();

        $this->info("Processing {$users->count()} eligible user(s)...");

        $opened  = 0;
        $closed  = 0;
        $skipped = 0;

        foreach ($users as $user) {
            // Close any active FY that has ended (end_date < today)
            $expired = FinancialYear::where('user_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '<', $today->toDateString())
                ->get();

            foreach ($expired as $old) {
                $this->line("  [{$user->email}] Closing {$old->label}");
                if (! $dryRun) {
                    $old->update(['status' => 'closed']);
                }
                $closed++;
            }

            // Check if new FY already exists for this user
            $exists = FinancialYear::where('user_id', $user->id)
                ->where('label', $newFy['label'])
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            $this->line("  [{$user->email}] Opening {$newFy['label']}");
            if (! $dryRun) {
                FinancialYear::create([
                    'user_id'    => $user->id,
                    'label'      => $newFy['label'],
                    'start_date' => $newFy['start_date'],
                    'end_date'   => $newFy['end_date'],
                    'status'     => 'active',
                ]);
            }
            $opened++;
        }

        // --seed: create current FY for ALL users who have no FY record at all
        if ($seed) {
            $unseeded = User::whereDoesntHave('financialYears')->get();
            $this->info("Seeding {$unseeded->count()} user(s) with no FY records...");

            foreach ($unseeded as $user) {
                // Derive their first FY from registration date
                $regFy = FinancialYear::forDate(Carbon::parse($user->created_at));
                $this->line("  [{$user->email}] Seeding {$regFy['label']} (registration FY)");

                if (! $dryRun) {
                    // Create registration FY (may already be closed if > 1 year ago)
                    $regStatus = Carbon::parse($regFy['end_date'])->isPast() ? 'closed' : 'active';
                    FinancialYear::firstOrCreate(
                        ['user_id' => $user->id, 'label' => $regFy['label']],
                        ['start_date' => $regFy['start_date'], 'end_date' => $regFy['end_date'], 'status' => $regStatus]
                    );

                    // If reg FY is closed, also open the current FY
                    if ($regStatus === 'closed') {
                        FinancialYear::firstOrCreate(
                            ['user_id' => $user->id, 'label' => $newFy['label']],
                            ['start_date' => $newFy['start_date'], 'end_date' => $newFy['end_date'], 'status' => 'active']
                        );
                    }
                }
                $opened++;
            }
        }

        $this->newLine();
        $this->table(['Metric', 'Count'], [
            ['FY records opened', $opened],
            ['FY records closed', $closed],
            ['Already up-to-date', $skipped],
        ]);

        $dryRun
            ? $this->warn('Dry run complete — no changes were saved.')
            : $this->info('Rollover complete.');

        return self::SUCCESS;
    }
}
