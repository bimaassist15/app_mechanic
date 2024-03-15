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
        Schema::create('penjualan_cicilan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_pembayaran_id')->unsigned();
            $table->bigInteger('sub_pembayaran_id')->unsigned();
            $table->double('bayar_pcicilan');
            $table->string('dibayaroleh_pcicilan')->nullable();
            $table->bigInteger('users_id')->unsigned();
            $table->double('kembalian_pcicilan');
            $table->double('hutang_pcicilan');
            $table->string('nomorkartu_pcicilan')->nullable();
            $table->string('pemilikkartu_pcicilan')->nullable();
            $table->bigInteger('penjualan_id')->unsigned();
            $table->bigInteger('cabang_id')->unsigned();
            $table->timestamps();

            $table->foreign('penjualan_id')->references('id')->on('penjualan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_cicilan');
    }
};
