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
        Schema::create('transfer_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transfer_stock_id')->unsigned();
            $table->bigInteger('barang_id')->unsigned();
            $table->double('qty_tdetail');
            $table->bigInteger('cabang_id')->unsigned();
            $table->timestamps();

            $table->foreign('transfer_stock_id')->references('id')->on('transfer_stock')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('transfer_detail');
    }
};
