<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_account');   // category id (e.g. Bank Dr)
            $table->unsignedBigInteger('to_account');     // category id (e.g. Credit Card)
            $table->decimal('amount', 10, 2);
            $table->date('transfer_date');
            $table->string('description', 500)->nullable();
            $table->string('reference', 200)->nullable();
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('from_account')->references('id')->on('categories');
            $table->foreign('to_account')->references('id')->on('categories');
            $table->foreign('added_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
