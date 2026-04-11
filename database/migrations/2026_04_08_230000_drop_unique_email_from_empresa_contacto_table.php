<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('empresa_contacto', function (Blueprint $table) {
            $table->dropUnique('empresa_contacto_email_unique');
            $table->index('email', 'empresa_contacto_email_index');
        });
    }

    public function down(): void
    {
        Schema::table('empresa_contacto', function (Blueprint $table) {
            $table->dropIndex('empresa_contacto_email_index');
            $table->unique('email', 'empresa_contacto_email_unique');
        });
    }
};

