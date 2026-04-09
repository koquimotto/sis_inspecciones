<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('detalle_inspeccion')) {
            return;
        }

        DB::statement("ALTER TABLE detalle_inspeccion MODIFY severidad ENUM('baja','media','alta','critica') NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('detalle_inspeccion')) {
            return;
        }

        DB::statement("ALTER TABLE detalle_inspeccion MODIFY severidad ENUM('baja','media','alta','critica') NULL DEFAULT 'media'");
    }
};

