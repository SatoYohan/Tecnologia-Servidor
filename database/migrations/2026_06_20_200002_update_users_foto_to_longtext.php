<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Altera foto_url de varchar para longText para suportar imagens em Base64 (RNF10/RNF11)
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->longText('foto_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto_url')->nullable()->change();
        });
    }
};
