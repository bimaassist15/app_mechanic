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
        Schema::table('saldo_detail', function (Blueprint $table) {
            //
            $table->renameColumn('pembayaran_servis_id', 'penerimaan_servis_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saldo_detail', function (Blueprint $table) {
            //
            $table->renameColumn('penerimaan_servis_id', 'pembayaran_servis_id');
        });
    }
};
