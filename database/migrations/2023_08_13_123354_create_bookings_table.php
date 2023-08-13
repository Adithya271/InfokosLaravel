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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('namaKos');
            $table->string('alamat');
            $table->string('cerita');
            $table->boolean('disetujui');
            $table->string('fasKamar');
            $table->string('fasKamarmandi');
            $table->string('fasParkir');
            $table->string('fasUmum');
            $table->string('harga');
            $table->string('hargaPromo');
            $table->string('gambarKos');
            $table->boolean('isPromo');
            $table->string('jenis');
            $table->string('lokasi');
            $table->integer('jlhKamar');
            $table->string('kecamatan');
            $table->string('pemilikId');
            $table->string('peraturan');
            $table->string('spektipekamar');
            $table->string('tipe');
            $table->string('pencariId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
