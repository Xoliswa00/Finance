<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activitylogs', function (Blueprint $table) {
            if (!Schema::hasColumn('activitylogs', 'ip_address')) {
                $table->ipAddress('ip_address')->nullable()->after('Added_by');
            }
            if (!Schema::hasColumn('activitylogs', 'user_agent')) {
                $table->string('user_agent')->nullable()->after('ip_address');
            }
            if (!Schema::hasColumn('activitylogs', 'referrer')) {
                $table->string('referrer')->nullable()->after('user_agent');
            }
            if (!Schema::hasColumn('activitylogs', 'session_id')) {
                $table->string('session_id')->nullable()->after('referrer');
            }
        });
    }

    public function down(): void
    {
        Schema::table('activitylogs', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'user_agent', 'referrer', 'session_id']);
        });
    }
};
