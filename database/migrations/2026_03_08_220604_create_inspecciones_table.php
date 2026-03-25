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
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->id();
            
            $table->string('codigo', 30)->unique(); // ej: INS-2026-000001
            $table->foreignId('tipo_inspeccion_id')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_salida')->nullable();
            
            $table->foreignId('empresa_id')->nullable();
            $table->foreignId('servicio_id')->nullable();
            $table->foreignId('equipo_id')->nullable();
            
            $table->foreignId('user_id')->nullable();
            
            $table->enum('estado', [
                'borrador','en_inspeccion','observado','subsanacion','aprobado','rechazado','anulado'
            ])->default('borrador')->index();

            $table->text('observaciones')->nullable();
            
            $table->timestamps();
            
            $table->index(['empresa_id','estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecciones');
    }
};
