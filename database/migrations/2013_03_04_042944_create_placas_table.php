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
        Schema::create('placas', function (Blueprint $table) {
            $table->id();
            
            $table->string('placa')->nullable()->index();
            $table->tinyInteger('estado')->default(1)->index(); // 1 en circulación , 0 de baja, 3 en tramite
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placas');
    }
};
