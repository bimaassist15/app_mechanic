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
        Schema::table('penjualan', function (Blueprint $table) {
            //
            $table->date('jatuhtempo_penjualan')->nullable();
            $table->text('keteranganjtempo_penjualan')->nullable();
            $table->boolean('isinfojtempo_penjualan')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            //
            $table->dropColumn('jatuhtempo_penjualan');
            $table->dropColumn('keteranganjtempo_penjualan');
            $table->dropColumn('isinfojtempo_penjualan');
        });
    }
};
