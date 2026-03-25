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
        Schema::create('empresa_contacto', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('persona_id')->nullable()->index();
            $table->foreignId('empresa_id')->nullable()->index();
            
            $table->string('email', 150)->nullable()->unique();
            $table->string('telefono', 30)->nullable();
            $table->tinyInteger('estado')->default(1)->index();
            
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_contacto');
    }
};
