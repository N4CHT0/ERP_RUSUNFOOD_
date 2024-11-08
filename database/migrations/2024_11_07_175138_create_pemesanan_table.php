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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('id_vendor');
            $table->string('id_bahan_baku');
            $table->string('kode_pemesanan');
            $table->string('deskripsi');
            $table->string('nama_pemesan');
            $table->integer('jumlah');
            $table->float('pajak');
            $table->date('tanggal_pemesanan');
            $table->float('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
