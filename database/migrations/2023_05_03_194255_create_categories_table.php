<?php

use App\Models\User;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category',500);
            $table->string('Nature',200);
            $table->foreign('Nature')->references('Nature')->on('Natures');
            $table->decimal('Balance',8,2)->default(0.00);
            $table->timestamps();
            $table->foreignIdFor(User::class, "Added_by");


            $table->foreign('Added_by')->references('id')->on('users');
        });

        // Categories are seeded per-user inside RegisterController::Category()
        // Do NOT seed here — adding data with Added_by = 1 would fail on a fresh DB
        // (user 1 doesn't exist yet) and would duplicate categories for the first registrant.



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
