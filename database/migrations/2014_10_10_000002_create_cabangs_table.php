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
        Schema::create('cabang', function (Blueprint $table) {
            $table->id();
            $table->string('bengkel_cabang');
            $table->string('nama_cabang');
            $table->string('nowa_cabang');
            $table->string('kota_cabang');
            $table->string('email_cabang')->nullable();
            $table->text('alamat_cabang')->nullable();
            $table->boolean('status_cabang')->default(true);
            $table->string('notelpon_cabang')->nullable();
            $table->enum('tipeprint_cabang', ['thermal', 'biasa']);
            $table->enum('printservis_cabang', ['thermal', 'biasa']);
            $table->double('lebarprint_cabang');
            $table->double('lebarprintservis_cabang');
            $table->string('domain_cabang')->nullable();
            $table->text('teksnotamasuk_cabang')->nullable();
            $table->text('teksnotaambil_cabang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cabang');
    }
};
