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
            $table->string('kondisiservis_pservis')->nullable();
            $table->integer('nilaiberkala_pservis')->nullable();
            $table->string('tipeberkala_pservis')->nullable();
            $table->text('pesanwa_pservis')->nullable();
            $table->text('catatanteknisi_pservis')->nullable();
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
            $table->dropColumn('kondisiservis_pservis');
            $table->dropColumn('nilaiberkala_pservis');
            $table->dropColumn('tipeberkala_pservis');
            $table->dropColumn('pesanwa_pservis');
            $table->dropColumn('catatanteknisi_pservis');
        });
    }
};
