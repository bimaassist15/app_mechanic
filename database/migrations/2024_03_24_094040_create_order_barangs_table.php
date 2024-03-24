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
        Schema::create('order_barang', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id')->unsigned();
            $table->bigInteger('barang_id')->unsigned();
            $table->bigInteger('penerimaan_servis_id')->unsigned();
            $table->double('qty_orderbarang');
            $table->enum('typediskon_orderbarang', ['fix', '%'])->nullable();
            $table->double('diskon_orderbarang')->nullable();
            $table->double('subtotal_orderbarang');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('penerimaan_servis_id')->references('id')->on('penerimaan_servis')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_barang');
    }
};
