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
        Schema::table('pembelian_product', function (Blueprint $table) {
            //
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cabang_id')->references('id')->on('cabang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pembelian_id')->references('id')->on('pembelian')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembelian_product', function (Blueprint $table) {
            //
            $table->dropForeign(['barang_id']);
            $table->dropForeign(['cabang_id']);
            $table->dropForeign(['pembelian_id']);
        });
    }
};
