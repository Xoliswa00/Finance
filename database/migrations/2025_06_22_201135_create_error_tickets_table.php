<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('error_tickets', function (Blueprint $table) {
        $table->id();
        $table->string('error_type')->nullable();
        $table->text('message');
        $table->string('file')->nullable();
        $table->integer('line')->nullable();
        $table->string('url')->nullable();
        $table->ipAddress('ip_address')->nullable();
        $table->text('user_agent')->nullable();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->boolean('is_resolved')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_tickets');
    }
};
