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
        Schema::create('detalle_inspeccion', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('observacion_id')->nullable();
            $table->foreignId('revision_id')->nullable();
            
            $table->text('detalle')->nullable();
            $table->enum('severidad', ['baja','media','alta','critica'])->default('media')->index();
            $table->enum('estado', ['pendiente','levantada'])->default('pendiente')->index();
            
            $table->foreignId('user_id')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_inspeccion');
    }
};
