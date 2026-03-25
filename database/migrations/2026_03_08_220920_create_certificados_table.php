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
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('tipo_certificado_id')->nullable();
            
            $table->foreignId('inspeccion_id')
                ->constrained('inspecciones')
                ->cascadeOnDelete();

            $table->string('numero', 40)->unique(); // ej: CERT-2026-000001
            $table->date('fecha_emision')->index();
            $table->date('fecha_vencimiento')->nullable()->index();

            $table->enum('estado', ['vigente','anulado','vencido'])->default('vigente')->index();

            $table->text('pdf_ruta')->nullable(); // storage path al PDF generado/subido
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
