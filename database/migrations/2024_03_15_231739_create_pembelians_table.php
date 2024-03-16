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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_pembelian');
            $table->dateTime('transaksi_pembelian');
            $table->bigInteger('supplier_id')->nullable();
            $table->enum('tipe_pembelian', ['cash', 'hutang']);
            $table->bigInteger('users_id')->unsigned();
            $table->bigInteger('cabang_id')->unsigned();
            $table->double('total_pembelian');
            $table->double('hutang_pembelian');
            $table->double('kembalian_pembelian');
            $table->double('bayar_pembelian');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pembelian');
    }
};
