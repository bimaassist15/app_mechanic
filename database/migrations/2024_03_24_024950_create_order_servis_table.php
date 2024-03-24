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
        Schema::create('order_servis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id')->unsigned();
            $table->bigInteger('harga_servis_id')->unsigned();
            $table->bigInteger('penerimaan_servis_id')->unsigned();
            $table->bigInteger('users_id_mekanik')->nullable();
            $table->double('harga_orderservis');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('harga_servis_id')->references('id')->on('harga_servis')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('penerimaan_servis_id')->references('id')->on('penerimaan_servis')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_servis');
    }
};
