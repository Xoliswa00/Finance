<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('suspended_at')->nullable()->after('last_seen');
            $table->string('suspension_reason', 500)->nullable()->after('suspended_at');
            $table->unsignedTinyInteger('login_attempts_count')->default(0)->after('suspension_reason');
            $table->timestamp('locked_until')->nullable()->after('login_attempts_count');
            $table->timestamp('force_logout_at')->nullable()->after('locked_until');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['suspended_at', 'suspension_reason', 'login_attempts_count', 'locked_until', 'force_logout_at']);
        });
    }
};
