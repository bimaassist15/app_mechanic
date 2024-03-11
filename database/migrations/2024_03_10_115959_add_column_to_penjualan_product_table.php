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
        Schema::table('penjualan_product', function (Blueprint $table) {
            $table->bigInteger('kategori_pembayaran_id')->unsigned();
            $table->bigInteger('sub_pembayaran_id')->unsigned();
            $table->double('bayar_pproduct');
            $table->string('dibayaroleh_pproduct')->nullable();
            $table->bigInteger('users_id')->unsigned();
            $table->double('kembalian_pproduct')->nullable();
            $table->double('hutang_pproduct')->nullable();
            $table->string('nomorkartu_pproduct')->nullable();
            $table->string('pemilikkartu_pproduct')->nullable();


            $table->foreign('kategori_pembayaran_id')->references('id')->on('kategori_pembayaran')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sub_pembayaran_id')->references('id')->on('sub_pembayaran')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_product', function (Blueprint $table) {
            $table->dropForeign(['kategori_pembayaran_id']);
            $table->dropForeign(['sub_pembayaran_id']);
            $table->dropForeign(['users_id']);

            $table->dropColumn('kategori_pembayaran_id');
            $table->dropColumn('sub_pembayaran_id');
            $table->dropColumn('bayar_pproduct');
            $table->dropColumn('dibayaroleh_pproduct');
            $table->dropColumn('users_id');
            $table->dropColumn('kembalian_pproduct');
            $table->dropColumn('hutang_pproduct');
            $table->dropColumn('nomorkartu_pproduct');
            $table->dropColumn('pemilikkartu_pproduct');
        });
    }
};
