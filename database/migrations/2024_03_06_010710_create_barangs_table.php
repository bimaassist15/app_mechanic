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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('barcode_barang');
            $table->string('nama_barang');
            $table->bigInteger('satuan_id')->unsigned();
            $table->text('deskripsi_barang')->nullable();
            $table->enum('snornonsn_barang',['sn','non sn']);
            $table->double('stok_barang');
            $table->double('hargajual_barang');
            $table->string('lokasi_barang');
            $table->bigInteger('kategori_id')->unsigned();
            $table->enum('status_barang', ['dijual', 'khusus servis', 'dijual & untuk servis', 'tidak dijual']);
            $table->bigInteger('cabang_id')->unsigned();
            $table->timestamps();

            $table->foreign('satuan_id')->references('id')->on('satuan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('barang');
    }
};
