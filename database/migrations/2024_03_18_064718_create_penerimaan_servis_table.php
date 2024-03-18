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
        Schema::create('penerimaan_servis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kendaraan_id')->unsigned();
            $table->bigInteger('kategori_servis_id')->unsigned();
            $table->string('kerusakan_pservis');
            $table->text('keluhan_pservis');
            $table->string('kondisi_pservis');
            $table->string('kmsekarang_pservis')->nullable();
            $table->string('tipe_pservis');
            $table->boolean('isdp_pservis')->default(false);
            $table->double('total_dppservis')->default(0);
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
        Schema::dropIfExists('penerimaan_servis');
    }
};
