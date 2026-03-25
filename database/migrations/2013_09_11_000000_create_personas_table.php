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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_documento', ['DNI', 'CE', 'PAS'])->default('DNI');
            $table->string('numero_documento', 20)->unique();

            $table->string('nombres', 120);
            $table->string('apellido_paterno', 120);
            $table->string('apellido_materno', 120);

            $table->date('fecha_nacimiento')->nullable();
            $table->string('ubigeo', 20)->nullable();
            
            $table->string('email', 150)->nullable()->unique();
            $table->string('telefono', 30)->nullable();
            
            $table->enum('sexo',['m','f'])->nullable();
            
            $table->string('foto', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['apellido_paterno','apellido_materno', 'nombres']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
