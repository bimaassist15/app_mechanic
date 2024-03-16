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
        Schema::create('pembelian_cicilan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_pembayaran_id')->unsigned();
            $table->bigInteger('sub_pembayaran_id')->unsigned();
            $table->double('bayar_pbcicilan');
            $table->string('dibayaroleh_pbcicilan')->nullable();
            $table->bigInteger('users_id')->unsigned();
            $table->double('kembalian_pbcicilan');
            $table->double('hutang_pbcicilan');
            $table->string('nomorkartu_pbcicilan')->nullable();
            $table->string('pemilikkartu_pbcicilan')->nullable();
            $table->bigInteger('pembelian_id')->unsigned();
            $table->bigInteger('cabang_id')->unsigned();
            $table->timestamps();

            $table->foreign('kategori_pembayaran_id')->references('id')->on('kategori_pembayaran')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sub_pembayaran_id')->references('id')->on('sub_pembayaran')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pembelian_id')->references('id')->on('pembelian')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cabang_id')->references('id')->on('cabang')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_cicilan');
    }
};
