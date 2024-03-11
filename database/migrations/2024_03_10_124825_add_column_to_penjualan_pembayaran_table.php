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
        Schema::table('penjualan_pembayaran', function (Blueprint $table) {
            $table->bigInteger('kategori_pembayaran_id')->unsigned();
            $table->bigInteger('sub_pembayaran_id')->unsigned();
            $table->double('bayar_ppembayaran');
            $table->string('dibayaroleh_ppembayaran')->nullable();
            $table->bigInteger('users_id')->unsigned();
            $table->double('kembalian_ppembayaran');
            $table->double('hutang_ppembayaran');
            $table->string('nomorkartu_ppembayaran')->nullable();
            $table->string('pemilikkartu_ppembayaran')->nullable();

            $table->foreign('kategori_pembayaran_id')->references('id')->on('kategori_pembayaran')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sub_pembayaran_id')->references('id')->on('sub_pembayaran')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_pembayaran', function (Blueprint $table) {
            $table->dropForeign(['kategori_pembayaran_id']);
            $table->dropForeign(['sub_pembayaran_id']);
            $table->dropForeign(['users_id']);

            $table->dropColumn('kategori_pembayaran_id');
            $table->dropColumn('sub_pembayaran_id');
            $table->dropColumn('bayar_ppembayaran');
            $table->dropColumn('dibayaroleh_ppembayaran');
            $table->dropColumn('users_id');
            $table->dropColumn('kembalian_ppembayaran');
            $table->dropColumn('hutang_ppembayaran');
            $table->dropColumn('nomorkartu_ppembayaran');
            $table->dropColumn('pemilikkartu_ppembayaran');
        });
    }
};
