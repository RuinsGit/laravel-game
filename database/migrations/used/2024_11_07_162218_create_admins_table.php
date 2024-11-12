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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Adminin adı
            $table->string('email')->unique(); // Adminin e-posta adresi
            $table->string('password'); // Adminin şifresi
            $table->boolean('is_admin')->default(true); // Admin durumu
            $table->timestamps(); // created_at ve updated_at kolonları
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
