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
        Schema::create('lembagas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');  
            $table->string('alamat');  
            $table->string('telepon');  
            $table->string('email');
            $table->string('instagram');
            $table->enum('kategori', ['education', 'health', 'environment', 'social service', 'community service', 'animal']);  
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->foreignId('pengurus_id')->constrained('users')->onDelete('cascade')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembagas');
    }
};
