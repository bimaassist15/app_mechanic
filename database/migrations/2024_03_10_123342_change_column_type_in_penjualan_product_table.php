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
        Schema::table('penjualan_product', function (Blueprint $table) {
            $table->string('typediskon_penjualanproduct')->nullable()->change();
            $table->double('diskon_penjualanproduct')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_product', function (Blueprint $table) {
            $table->string('typediskon_penjualanproduct')->nullable(false)->change();
            $table->double('diskon_penjualanproduct')->nullable(false)->change();
        });
    }
};
