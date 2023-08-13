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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('pencariId');
            $table->string('noTransaksi');
            $table->date('tglTransaksi');
            $table->string('namaPencari');
            $table->string('kosId');
            $table->string('jlhKamar');
            $table->string('pemilikId');
            $table->string('catatanPesanan');
            $table->string('totalBayar');
            $table->text('buktiBayar');
            $table->string('atasNama');
            $table->string('namaBank');
            $table->string('noRek');
            $table->string('statusTransaksi');
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
        Schema::dropIfExists('transaksis');
    }
};
