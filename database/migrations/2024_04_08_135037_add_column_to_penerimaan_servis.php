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
            $table->date('estimasi_pservis')->nullable();
            $table->boolean('isrememberestimasi_pservis')->default(false);
            $table->boolean('isestimasi_pservis')->default(false);
            $table->text('keteranganestimasi_pservis')->nullable();
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
            $table->dropColumn('estimasi_pservis');
            $table->dropColumn('isrememberestimasi_pservis');
            $table->dropColumn('keteranganestimasi_pservis');
            $table->dropColumn('isestimasi_pservis');
        });
    }
};
