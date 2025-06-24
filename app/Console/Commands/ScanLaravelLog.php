<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\Activitylog;
use App\Models\ErrorTicket;



class ScanLaravelLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-laravel-log';

    protected $logPath;
    protected $lastLineFile;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan laravel.log and save new errors to logs_main';

    /**
     * Execute the console command.
     */
   public function __construct()
    {
        parent::__construct();

        $this->logPath = storage_path('logs/laravel.log');
        $this->lastLineFile = storage_path('logs/.last_log_line'); // store last read position
    }

    public function handle()
    {
        if (!File::exists($this->logPath)) {
            $this->error('Log file not found.');
            return;
        }

        $lines = File::lines($this->logPath)->toArray();
        $lastLine = File::exists($this->lastLineFile) ? (int)File::get($this->lastLineFile) : 0;
        $newLines = array_slice($lines, $lastLine);

        foreach ($newLines as $index => $line) {
            if (str_contains($line, 'dev.ERROR') || str_contains($line, 'production.ERROR') || str_contains($line, '.ERROR')) {
                // Simple parse, could be enhanced with regex
                ErrorTicket::create([
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'level' => 'error',
                    'message' => $line,
                    'trace' => null,
                    'url' => null,
                    'method' => null,
                    'ip' => null,
                ]);
            }
        }

        // Save current position
        File::put($this->lastLineFile, count($lines));

        $this->info(count($newLines) . ' new log lines scanned.');
    }
}
