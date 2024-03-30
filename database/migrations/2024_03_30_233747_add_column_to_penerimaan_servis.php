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
            $table->text('garansi_pservis')->nullable();
            $table->bigInteger('users_id_garansi')->nullable();
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
            $table->dropColumn(array('garansi_pservis', 'users_id_garansi'));
        });
    }
};
