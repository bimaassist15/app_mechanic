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
        Schema::create('saldo_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('saldo_customer_id')->unsigned();
            $table->bigInteger('pembayaran_servis_id')->nullable();
            $table->timestamps();

            $table->foreign('saldo_customer_id')->references('id')->on('saldo_customer')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saldo_detail');
    }
};
