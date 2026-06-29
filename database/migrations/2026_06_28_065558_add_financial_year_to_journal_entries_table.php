<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->unsignedSmallInteger('FY')->nullable()->after('Status');
            $table->foreignId('financial_year_id')->nullable()->after('FY')
                  ->constrained('financial_years')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropForeign(['financial_year_id']);
            $table->dropColumn(['FY', 'financial_year_id']);
        });
    }
};
