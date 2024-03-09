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
        Schema::create('harga_servis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_hargaservis');
            $table->string('nama_hargaservis');
            $table->double('jasa_hargaservis');
            $table->text('deskripsi_hargaservis')->nullable();
            $table->double('profit_hargaservis');
            $table->double('total_hargaservis');
            $table->boolean('status_hargaservis')->default(true);
            $table->bigInteger('kategori_servis_id')->unsigned();
            $table->bigInteger('cabang_id')->unsigned();
            $table->timestamps();

            $table->foreign('kategori_servis_id')->references('id')->on('kategori_servis')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('harga_servis');
    }
};
