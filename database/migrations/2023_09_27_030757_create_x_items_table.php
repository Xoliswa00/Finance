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
        Schema::create('x_items', function (Blueprint $table) {
            $table->id();
            $table->string('Section',250);
            $table->string('Description',500);
            $table->string('Nature',200);
            $table->foreign('Nature')->references('Nature')->on('Natures');
            $table->decimal('Budget',18,2)->default(0.00);;
            $table->decimal('Actual',18,2)->default(0.00);;
            $table->date('Start_date');
            $table->date('end_date');
            $table->enum('Status', ['Not Started', 'Delayed', 'In-progress','Completed','Deleted']);
            $table->integer('Progress')->default(0.00);;
            $table->foreignId('Master')->constrained('master_x');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('x_items');
    }
};
