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
        Schema::create('kategori_pendapatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kpendapatan');
            $table->boolean('status_kpendapatan')->default(false);
            $table->bigInteger('cabang_id')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('kategori_pendapatan');
    }
};
