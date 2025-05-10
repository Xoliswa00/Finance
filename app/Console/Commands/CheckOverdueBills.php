<?php

namespace App\Console\Commands;

use App\Models\Budget;
use App\Notifications\BillDueNotification;
use Illuminate\Console\Command;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CheckOverdueBills extends Command
{

    use InteractsWithQueue;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:overdue-bills';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue bills and send notifications to users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    
        info('Starting check:overdue-bills command');

        $overdueBills = Budget::where('due_date', '<', now())
            ->where('status', 'Planning')
            ->get();

            foreach ($overdueBills as $bill) {
                // Assuming there's a relationship between Budget and User models, and notifications are set up correctly.
                $usersToNotify = $bill->user;
                Notification::send($usersToNotify, new BillDueNotification($bill));
            }
            info('Finished check:overdue-bills command');
            
        info('Finished check:overdue-bills command');

    }
}
