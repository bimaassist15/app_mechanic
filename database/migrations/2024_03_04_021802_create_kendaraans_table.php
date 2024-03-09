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
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->string('nopol_kendaraan');
            $table->string('merek_kendaraan')->nullable();
            $table->string('tipe_kendaraan')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->string('tahunbuat_kendaraan')->nullable();
            $table->string('tahunrakit_kendaraan')->nullable();
            $table->string('silinder_kendaraan')->nullable();
            $table->string('warna_kendaraan')->nullable();
            $table->string('norangka_kendaraan');
            $table->string('nomesin_kendaraan')->nullable();
            $table->string('keterangan_kendaraan')->nullable();
            $table->bigInteger('cabang_id')->unsigned();

            $table->timestamps();

            $table->foreign('cabang_id')->references('id')->on('cabang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kendaraan');
    }
};
