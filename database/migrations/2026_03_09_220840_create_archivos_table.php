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
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('observacion_id')->nullable();

            $table->text('ruta'); // storage/app/public/...
            $table->enum('tipo_archivo',['pdf','doc','image','video'])->nullable();
            $table->string('archivo', 200)->nullable();
            
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
        Schema::dropIfExists('archivos');
    }
};
