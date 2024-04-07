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
        Schema::table('transfer_stock', function (Blueprint $table) {
            //
            $table->dateTime('tanggalkirim_tstock')->nullable();
            $table->dateTime('tanggalditerima_tstock')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfer_stock', function (Blueprint $table) {
            //
            $table->dropColumn('tanggalkirim_tstock');
            $table->dropColumn('tanggalditerima_tstock');
        });
    }
};
