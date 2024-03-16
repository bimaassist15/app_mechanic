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
        Schema::create('pembelian_product', function (Blueprint $table) {
            $table->id();
            $table->dateTime('transaksi_pembelianproduct');
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('barang_id')->unsigned();
            $table->double('jumlah_pembelianproduct');
            $table->string('typediskon_pembelianproduct')->nullable();
            $table->double('diskon_pembelianproduct')->nullable();
            $table->double('subtotal_pembelianproduct');
            $table->bigInteger('cabang_id')->unsigned();
            $table->bigInteger('pembelian_id')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_product');
    }
};
