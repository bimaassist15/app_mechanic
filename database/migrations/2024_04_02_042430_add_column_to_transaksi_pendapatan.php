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
        Schema::table('transaksi_pendapatan', function (Blueprint $table) {
            //
            $table->date('tanggal_tpendapatan');
            $table->bigInteger('cabang_id')->unsigned();
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
        Schema::table('transaksi_pendapatan', function (Blueprint $table) {
            //
            $table->dropColumn('tanggal_tpendapatan');
            $table->dropColumn('cabang_id');
            $table->dropForeign('cabang_id');
        });
    }
};
