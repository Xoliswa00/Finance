<?php

use App\Models\payment_type;
use Illuminate\Support\Facades\DB;
use illuminate\Database\Query;

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
        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('Method',200)->unique();
            $table->timestamps(); 
        });



        DB::table('payment_types')->insert([

            ['Method'=>'Cash'],
            ['Method'=>'Debit Card'],
            ['Method'=>'Credit Card']
        ]
         );
    }
   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_types');
    }
};
