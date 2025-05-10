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
        Schema::create('master_x', function (Blueprint $table) {
            $table->id();
            $table->string('Name',255);
            $table->string('description',500);
            $table->date('Start_date');
            $table->date('end_date');
            $table->decimal('Actual',18,2)->default(0.00);
            $table->decimal('Budget',18,2)->default(0.00);
            $table->decimal('progress',8,2)->default(0.00);
            $table->foreignId('Added_by')->constrained('users');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_x');
    }
};
