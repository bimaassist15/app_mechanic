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
        Schema::table('service_histori', function (Blueprint $table) {
            //
            $table->bigInteger('cabang_id')->unsigned();
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
        Schema::table('service_histori', function (Blueprint $table) {
            //
            $table->dropForeign(['cabang_id']);
            $table->dropColumn('cabang_id');
        });
    }
};
