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
        Schema::table('penjualan_cicilan', function (Blueprint $table) {
            //
            $table->foreign('kategori_pembayaran_id')->references('id')->on('kategori_pembayaran')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('sub_pembayaran_id')->references('id')->on('sub_pembayaran')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::table('penjualan_cicilan', function (Blueprint $table) {
            //
            $table->dropForeign(['kategori_pembayaran_id']);
            $table->dropForeign(['sub_pembayaran_id']);
            $table->dropForeign(['users_id']);
            $table->dropForeign(['cabang_id']);
        });
    }
};
