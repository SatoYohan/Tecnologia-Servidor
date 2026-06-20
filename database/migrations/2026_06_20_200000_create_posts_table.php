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
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // INT auto-increment (RNF05)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->longText('imagem'); // Base64 da imagem (RNF10/RNF11)
            $table->string('legenda', 200)->default(''); // 0-200 chars (RNF06)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
