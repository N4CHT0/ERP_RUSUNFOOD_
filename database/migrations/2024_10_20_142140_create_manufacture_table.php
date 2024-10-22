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
        Schema::create('manufaktur', function (Blueprint $table) {
            $table->id();
            $table->string('id_produk');
            $table->string('id_bom');
            $table->integer('jumlah');
            $table->string('kode_manufaktur');
            $table->string('perusahaan');
            $table->integer('dibutuhkan');
            $table->integer('stok');
            $table->integer('terkonsumsi');
            $table->date('rencana_produksi');
            $table->date('batas_produksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacture');
    }
};
