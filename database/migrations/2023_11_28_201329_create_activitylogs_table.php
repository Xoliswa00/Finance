<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activitylogs', function (Blueprint $table) {
            $table->id();
            $table->string('page_visited',250);
            
            $table->string('Added_by',300);
            $table->ipAddress('ip_address')->nullable();
        $table->string('user_agent')->nullable();
        $table->string('referrer')->nullable();
        $table->string('session_id')->nullable();

           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activitylogs');
    }
};
