<?php


use illuminate\Database\Query;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('Surname');
            $table->string('Mobile',20);
            $table->string('Location',500);
            $table->enum('Role',['Master','AdmiX','friend'])->default('Friend');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->dateTime('last_seen')->timestamps();
        });


        DB::table('users')->insert([
            'name'=>'System',
            'Mobile'=>'0606861764',
            'Location'=>'South Africa',
            'Surname'=>'Admin',
            'email'=>'admin@BF.co.za',
            'password'=>Hash::make('admin234'),
            'last_seen'=>Now()
        ]);
     
     

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
