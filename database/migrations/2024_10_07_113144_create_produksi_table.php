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
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->string('id_produk');
            $table->string('id_bahan_baku');
            $table->integer('jumlah_produksi');
            $table->string('kode_produksi');
            $table->integer('total');
            $table->string('mata_uang');
            $table->date('tanggal_produksi');
            $table->date('tanggal_kadaluarsa');
            $table->date('tanggal_selesai_produksi');
            $table->date('berat_bersih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
