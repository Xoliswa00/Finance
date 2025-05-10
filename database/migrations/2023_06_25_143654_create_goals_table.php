<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Added_by')->constrained('users');
            $table->string('title');
            $table->text('description');
            $table->enum('goal_category', ['Saving', 'Repayment', 'Investing']);
            $table->decimal('target_amount', 18, 2);
            $table->decimal('current_amount', 18, 2)->default(0);
            $table->date('start_date');
            $table->string('Status',200)->default('In-Progress');
            $table->date('end_date');
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goals');
         
    }
};
