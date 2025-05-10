<?php

use App\Models\Nature;
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

        DB::table('categories')->insert([

            ['category'=>'Loan ABC Company','Nature'=>'Non-Current Liabilities','Added_by'=>'1'],
            ['category'=>'Loan XXX Company','Nature'=>'Non-Current Liabilities','Added_by'=>'1'],
            ['category'=>'Mortage bond','Nature'=>'Non-Current Liabilities','Added_by'=>'1'],
            ['category'=>'Credit Card','Nature'=>'Current Liabilities','Added_by'=>'1'],
            ['category'=>'Bank (Dr)','Nature'=>'Current Assets','Added_by'=>'1'],
     
            ['category'=>'Accrued Expenses','Nature'=>'Current Liabilities','Added_by'=>'1'],
            ['category'=>'Income Recived in-advance','Nature'=>'Current Liabilities','Added_by'=>'1'],
            ['category'=>'Other Income','Nature'=>'Income','Added_by'=>'1'],
            ['category'=>'Sales','Nature'=>'Income','Added_by'=>'1'],
            ['category'=>'Rent Income','Nature'=>'Income','Added_by'=>'1'],
            ['category'=>'Interest Income','Nature'=>'Income','Added_by'=>'1'],
            ['category'=>'Profit on Asset Desposal','Nature'=>'Income','Added_by'=>'1'],
            ['category'=>'Salary Earned','Nature'=>'Income','Added_by'=>'1'],
            ['category'=>'Gift Income','Nature'=>'Income','Added_by'=>'1'],
            ['category'=>'Allowance Income','Nature'=>'Income','Added_by'=>'1'],
            ['category'=>'Rent Apartment','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Salary and Wages','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Stationery','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Fuel','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Groceries','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Repairs','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Telephone and Connection','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Water and Electricity','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Entertainment','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Sundry Expenses','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Transport','Nature'=>'Expenses','Added_by'=>'1'],
            ['category'=>'Business: Cash drawings ','Nature'=>'Drawings','Added_by'=>'1'],
            ['category'=>'Business: Stock drawings ','Nature'=>'Drawings','Added_by'=>'1'],
            ['category'=>'Business: Cash Capital ','Nature'=>'Capital','Added_by'=>'1'],
            ['category'=>'Equipment','Nature' =>'Non-Current Assets','Added_by'=>'1'],
            ['category'=>'Vehicle','Nature' =>'Non-Current Assets','Added_by'=>'1'],
            ['category'=>'Land and Buildings','Nature' =>'Non-Current Assets','Added_by'=>'1'],
            ['category'=>'Debtor Control','Nature' =>'Current Assets','Added_by'=>'1'],
            ['category'=>'Prepared Expenses','Nature' =>'Current Assets','Added_by'=>'1'],


            
        ]   );



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
