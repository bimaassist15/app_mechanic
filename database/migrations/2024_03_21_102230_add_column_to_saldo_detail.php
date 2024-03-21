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
            $table->double('kembaliansaldo_detail')->default(0);
            $table->double('hutangsaldo_detail')->default(0);
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
            $table->dropColumn('kembaliansaldo_detail');
            $table->dropColumn('hutangsaldo_detail');
        });
    }
};
