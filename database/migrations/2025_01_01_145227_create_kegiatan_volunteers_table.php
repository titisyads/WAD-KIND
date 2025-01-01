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
        Schema::create('kegiatan_volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lembaga')->constrained('lembagas')->onDelete('cascade');  
            $table->string('nama_kegiatan');
            $table->string('lokasi');  
            $table->text('deskripsi');  
            $table->date('tanggal');  
            $table->enum('kategori', ['education', 'health', 'environment', 'social service', 'community service', 'animal']);
            $table->integer('kuota');
            $table->enum('jenis', ['berbayar', 'gratis']);  
            $table->integer('harga')->nullable();
            $table->string('banner')->nullable();
            $table->foreignId('id_pengurus')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_volunteers');
    }
};
