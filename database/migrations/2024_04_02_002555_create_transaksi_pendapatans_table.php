<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pendapatan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_pendapatan_id')->unsigned();
            $table->double('jumlah_tpendapatan');
            $table->timestamps();

            $table->foreign('kategori_pendapatan_id')->references('id')->on('kategori_pendapatan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_pendapatan');
    }
};
