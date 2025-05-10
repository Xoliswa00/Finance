<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('natures', function (Blueprint $table) {
            $table->id();
            $table->string('Classification',220);
            $table->string('Nature',220)->unique();
            $table->timestamps();
            $table->foreignIdFor(User::class, "Added_by")->nullable();


            $table->foreign('Added_by')->references('id')->on('users');
        });


        DB::table('natures')->insert([
            ['Classification' => 'Liability', 'Nature' => 'Non-Current Liabilities','Added_by' =>'1'],
            ['Classification' => 'Liability', 'Nature' =>'Current Liabilities','Added_by' =>'1'],
            ['Classification' => 'Assets', 'Nature' => 'Non-Current Assets','Added_by' =>'1'],
            ['Classification' => 'Assets', 'Nature' =>'Current Assets','Added_by' =>'1'],
            ['Classification' => 'Owners Equity', 'Nature' => 'Income','Added_by' =>'1'],
            ['Classification' => 'Owners Equity', 'Nature' =>'Expenses','Added_by' =>'1'],
            ['Classification' => 'Owners Equity', 'Nature' =>'Drawings','Added_by' =>'1'],
            ['Classification' => 'Owners Equity', 'Nature' =>'Capital','Added_by' =>'1'],
        ]);

      


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('natures');
    }
};
