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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            // unidad_minera | service
            $table->enum('tipo', ['unidad_minera', 'empresa'])->index();

            // si es service, apunta a su unidad minera
            $table->foreignId('unidad_minera_id')->nullable()->constrained('empresas');

            $table->string('ruc', 11)->nullable()->index();
            $table->string('razon_social', 200);
            $table->string('nombre_comercial', 200)->nullable();

            $table->string('email', 150)->nullable();
            $table->string('telefono', 30)->nullable();
            
            $table->foreignId('pais_id')->nullable();
            $table->foreignId('region_id')->nullable();
            $table->string('ciudad', 200)->nullable();
            $table->string('direccion', 250)->nullable();

            $table->tinyInteger('estado')->default(1)->index(); // 1/0
            
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
            
            $table->softDeletes();

            $table->index(['tipo', 'unidad_minera_id','ruc','razon_social']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
