<?php
use App\Models\category;
use App\Models\User;
use App\Models\payment_type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('Action',['Bought','Paid','Received','Earned']);
            $table->foreignIdFor(category::class, "Category");

            $table->string('Description', 200);
            $table->decimal('Amount',10,2);
            $table->String('Method',200)->default('Cash');

            $table->date('bill_date');
            
            $table->string('Status', 500)->default('Paid');
            $table->string('Invoice_slip',1000)->nullable();
             $table->foreignIdFor(User::class,"Added_by");

            $table->foreign('Method')->references('Method')->on('payment_types');
            $table->foreign('Added_by')->references('id')->on('users');
            $table->foreign('Category')->references('id')->on('categories');
            $table->integer('FY');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};