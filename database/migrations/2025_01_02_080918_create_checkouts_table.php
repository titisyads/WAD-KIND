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
        Schema::create('checkouts', function (Blueprint $table) {  
            $table->id();  
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');  
            $table->foreignId('id_kegiatan')->constrained('kegiatan_volunteers')->onDelete('cascade');  
            $table->enum('status', ['pending', 'success', 'failed', 'expired', 'canceled']);  
            $table->integer('jumlah_bayar'); 
            $table->string('metode_pembayaran')->nullable();  
            $table->date('tanggal_checkout');   
            $table->timestamps();  
        });  

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};