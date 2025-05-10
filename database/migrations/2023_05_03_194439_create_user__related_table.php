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
        Schema::create('user__related', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            
            $table->string('Relation');
            $table->foreignIdFor(User::class,"id_user");
             $table->foreignIdFor(User::class,"Added_by");
            $table->foreign('Added_by')->references('id')->on('users');
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user__related');
    }
};
