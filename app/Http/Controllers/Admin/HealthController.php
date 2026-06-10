<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HealthController extends Controller
{
    public function index()
    {
        $checks = $this->runChecks();
        $tables = $this->tableSizes();
        $logLines = $this->readErrorLog(100);

        return view('Admin.Health', compact('checks', 'tables', 'logLines'));
    }

    private function runChecks(): array
    {
        $checks = [];

        // PHP Version
        $checks['php_version'] = [
            'label'  => 'PHP Version',
            'value'  => PHP_VERSION,
            'status' => version_compare(PHP_VERSION, '8.2.0', '>=') ? 'ok' : 'warn',
        ];

        // Laravel version
        $checks['laravel_version'] = [
            'label'  => 'Laravel Version',
            'value'  => app()->version(),
            'status' => 'ok',
        ];

        // App environment
        $env = app()->environment();
        $checks['environment'] = [
            'label'  => 'Environment',
            'value'  => $env,
            'status' => $env === 'production' ? 'ok' : 'warn',
        ];

        // Debug mode
        $debug = config('app.debug');
        $checks['debug_mode'] = [
            'label'  => 'Debug Mode',
            'value'  => $debug ? 'ON' : 'OFF',
            'status' => ($debug && $env === 'production') ? 'fail' : 'ok',
        ];

        // Database connection
        try {
            DB::connection()->getPdo();
            $driver = DB::connection()->getDriverName();
            $checks['database'] = [
                'label'  => 'Database',
                'value'  => "Connected ({$driver})",
                'status' => 'ok',
            ];
        } catch (\Exception $e) {
            $checks['database'] = [
                'label'  => 'Database',
                'value'  => 'Connection failed: ' . $e->getMessage(),
                'status' => 'fail',
            ];
        }

        // Storage writable
        $storageOk = is_writable(storage_path());
        $checks['storage'] = [
            'label'  => 'Storage Writable',
            'value'  => $storageOk ? 'Yes' : 'No',
            'status' => $storageOk ? 'ok' : 'fail',
        ];

        // Cache driver
        $checks['cache'] = [
            'label'  => 'Cache Driver',
            'value'  => config('cache.default'),
            'status' => 'ok',
        ];

        // Mail driver
        $mailer = config('mail.default');
        $checks['mail'] = [
            'label'  => 'Mail Driver',
            'value'  => $mailer,
            'status' => $mailer === 'log' ? 'warn' : 'ok',
            'note'   => $mailer === 'log' ? 'Emails are only written to log. Set MAIL_MAILER=smtp for real delivery.' : '',
        ];

        // Queue driver
        $checks['queue'] = [
            'label'  => 'Queue Driver',
            'value'  => config('queue.default'),
            'status' => 'ok',
        ];

        // Log file size
        $logPath = storage_path('logs/laravel.log');
        $logSize = file_exists($logPath) ? round(filesize($logPath) / 1024, 1) . ' KB' : 'No log file';
        $checks['log_file'] = [
            'label'  => 'Log File Size',
            'value'  => $logSize,
            'status' => 'ok',
        ];

        // Online users
        $online = DB::table('users')->where('last_seen', '>=', now()->subMinutes(5))->count();
        $checks['online_users'] = [
            'label'  => 'Users Online (5 min)',
            'value'  => $online,
            'status' => 'ok',
        ];

        return $checks;
    }

    private function tableSizes(): array
    {
        $tables = ['users', 'journal_entries', 'budgets', 'categories', 'activitylogs',
                   'login_attempts', 'admin_audit_logs', 'transfers', 'announcements'];

        $sizes = [];
        foreach ($tables as $table) {
            try {
                if (Schema::hasTable($table)) {
                    $sizes[$table] = DB::table($table)->count();
                }
            } catch (\Exception $e) {
                $sizes[$table] = '—';
            }
        }

        return $sizes;
    }

    public function readErrorLog(int $lines = 200): array
    {
        $path = storage_path('logs/laravel.log');

        if (!file_exists($path)) {
            return [];
        }

        $all = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!$all) {
            return [];
        }

        // Return last N lines, newest first
        return array_reverse(array_slice($all, -$lines));
    }
}
