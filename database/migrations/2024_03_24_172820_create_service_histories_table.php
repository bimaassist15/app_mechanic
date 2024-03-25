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
        Schema::create('service_histori', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penerimaan_servis_id')->unsigned();
            $table->string('status_histori');
            $table->timestamps();

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
        Schema::dropIfExists('service_histori');
    }
};
