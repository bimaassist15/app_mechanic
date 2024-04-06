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
        Schema::table('pembelian', function (Blueprint $table) {
            //
            $table->date('jatuhtempo_pembelian')->nullable();
            $table->text('keteranganjtempo_pembelian')->nullable();
            $table->boolean('isinfojtempo_pembelian')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembelian', function (Blueprint $table) {
            //
            $table->dropColumn('jatuhtempo_pembelian');
            $table->dropColumn('keteranganjtempo_pembelian');
            $table->dropColumn('isinfojtempo_pembelian');
        });
    }
};
