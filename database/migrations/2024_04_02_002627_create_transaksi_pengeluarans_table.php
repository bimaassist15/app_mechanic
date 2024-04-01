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
        Schema::create('transaksi_pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_pengeluaran_id')->unsigned();
            $table->double('jumlah_tpengeluaran');
            $table->timestamps();

            $table->foreign('kategori_pengeluaran_id')->references('id')->on('kategori_pengeluaran')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_pengeluaran');
    }
};
