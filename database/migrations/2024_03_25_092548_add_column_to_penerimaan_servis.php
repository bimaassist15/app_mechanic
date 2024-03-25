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
        Schema::table('penerimaan_servis', function (Blueprint $table) {
            //
            $table->date('servisberkala_pservis')->nullable();
            $table->integer('nilaigaransi_pservis')->nullable();
            $table->string('tipegaransi_pservis')->nullable();
            $table->date('servisgaransi_pservis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penerimaan_servis', function (Blueprint $table) {
            //
            $table->dropColumn('servisberkala_pservis');
            $table->dropColumn('nilaigaransi_pservis');
            $table->dropColumn('tipegaransi_pservis');
            $table->dropColumn('servisgaransi_pservis');
        });
    }
};
