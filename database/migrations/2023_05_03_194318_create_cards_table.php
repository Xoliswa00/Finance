<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            
            $table->enum('Type',['Debit Card','Credit Card']);
            $table->bigInteger('CardNumber')->unique();
            $table->string('ExpiryDate',10);
            $table->integer('CVC');
            $table->string('Cardholder',200);
            $table->enum('Status',['Active','Disable'])->default('Active');
            
            $table->foreignIdFor(User::class,"Added_by");
            $table->foreign('Added_by')->references('id')->on('users');


            $table->timestamps();
        });

        DB::table('cards')->insert([
            'CardNumber'=>'1234567890123456',
            'Type'=>'Debit Card',
            'ExpiryDate'=>'08-28',
          'CVC'=>'123',
            'Cardholder'=>'System Admin',
            'Status'=>'Active',
            'Added_by'=>'1'



        ]);
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
