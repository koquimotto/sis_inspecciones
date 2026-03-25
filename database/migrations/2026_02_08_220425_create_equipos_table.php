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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            
            // $table->foreignId('empresa_id')
            //     ->constrained('empresas')
            //     ->cascadeOnUpdate()
            //     ->restrictOnDelete();

            $table->foreignId('tipo_id')->nullable();
            $table->foreignId('categoria_id')->nullable();        // ej: MINIBUS, VOLQUETE
            $table->foreignId('marca_id')->nullable();
            $table->foreignId('modelo_id')->nullable();
            
            $table->string('serie', 80)->nullable();
            
            $table->foreignId('placa_id')->nullable()->index();    // si aplica
            
            $table->year('anio')->nullable();
            
            $table->text('observaciones')->nullable();
            
            $table->tinyInteger('estado')->default(1)->index();

            $table->foreignId('user_id')->nullable();
            $table->timestamps();

            $table->index(['tipo_id','categoria_id','marca_id','modelo_id','placa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
