<?php

use App\Models\Budget;
use App\Models\category;
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
        Schema::create('budget_subitems', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Budget::class);
            $table->string('Description',200);
            $table->decimal('Amount',18,2)->nullable(true);
            $table->decimal('Limit',18,2);
            $table->date('due_date');
            $table->enum('Recurring',['Daily','Weekly','Monthly','Yearly'])->default('Monthly');
            $table->enum('Priority',['High','Modarate','normal'])->default('Normal');
            $table->string('Status',200)->default('Pending');
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->foreignIdFor(category::class, "Category");
            $table->foreign('category')->references('id')->on('categories');




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_subitems');
    }
};
