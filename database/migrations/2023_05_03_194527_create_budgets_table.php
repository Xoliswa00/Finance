<?php
use App\Models\category;
use App\Models\User;
use App\Models\User_Related;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('Description', 200);
            $table->decimal('Amount',18,2)->nullable(true);
            $table->decimal('Limit');
            $table->date('due_date');
            $table->enum('Recurring', ['Once-off', 'Weekly', 'Monthly', 'Yearly'])->default('Monthly');
            $table->enum('Priority', ['High', 'Moderate', 'normal'])->default('Normal');
            $table->string('Status', 200)->default('Pending');

            $table->foreignIdFor(User::class, "Added_by");
            $table->foreignIdFor(category::class, "Category");



            $table->foreign('Added_by')->references('id')->on('users');
            $table->foreign('Category')->references('id')->on('categories');









            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};