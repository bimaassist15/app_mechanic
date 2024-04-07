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
        Schema::create('transfer_stock', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tstock');
            $table->bigInteger('cabang_id_awal')->unsigned();
            $table->bigInteger('cabang_id_penerima')->unsigned();
            $table->bigInteger('cabang_id')->unsigned();
            $table->bigInteger('users_id')->unsigned();
            $table->text('keterangan_tstock')->nullable();
            $table->enum('status_tstock', ['proses kirim', 'diterima', 'ditolak']);
            $table->timestamps();


            $table->foreign('cabang_id_awal')->references('id')->on('cabang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cabang_id_penerima')->references('id')->on('cabang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cabang_id')->references('id')->on('cabang')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('transfer_stock');
    }
};
