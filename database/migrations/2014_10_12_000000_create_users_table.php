<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('persona_id')->nullable();
            $table->foreignId('empresa_id')->nullable();
            $table->foreignId('user_id')->nullable();
            
            $table->string('name');
            
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            
            $table->string('username', 20)->unique();
            $table->string('password');
            
            $table->tinyInteger('estado')->default(1);
            $table->text('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
