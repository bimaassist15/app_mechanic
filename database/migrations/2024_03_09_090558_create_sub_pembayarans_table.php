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
        Schema::create('sub_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_spembayaran');
            $table->boolean('status_spembayaran')->default(true);
            $table->bigInteger('kategori_pembayaran_id')->unsigned();
            $table->bigInteger('cabang_id')->unsigned();
            $table->timestamps();

            $table->foreign('cabang_id')->references('id')->on('cabang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kategori_pembayaran_id')->references('id')->on('kategori_pembayaran')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_pembayaran');
    }
};
