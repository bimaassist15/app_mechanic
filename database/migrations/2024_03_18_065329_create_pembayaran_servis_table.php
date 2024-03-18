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
        Schema::create('pembayaran_servis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_pembayaran_id')->unsigned();
            $table->bigInteger('sub_pembayaran_id')->unsigned();
            $table->double('bayar_pservis');
            $table->string('dibayaroleh_pservis');
            $table->bigInteger('users_id')->unsigned();
            $table->double('kembalian_pservis');
            $table->double('hutang_pservis');
            $table->string('nomorkartu_pservis')->nullable();
            $table->string('pemilikkartu_pservis')->nullable();
            $table->bigInteger('penerimaan_servis_id')->unsigned();
            $table->bigInteger('cabang_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_servis');
    }
};
