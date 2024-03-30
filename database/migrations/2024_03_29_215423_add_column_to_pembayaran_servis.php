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
        Schema::table('pembayaran_servis', function (Blueprint $table) {
            //
            $table->double('saldodeposit_pservis')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembayaran_servis', function (Blueprint $table) {
            //
            $table->dropColumn(['saldodeposit_pservis']);
        });
    }
};
