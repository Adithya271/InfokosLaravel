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
            $table->integer('pencariId');
            $table->string('noTranskasi');
            $table->date('tglTransaksi');
            $table->string('namaPencari');
            $table->integer('kosId');
            $table->integer('pemilikId');
            $table->string('catatanPesanan');
            $table->integer('totalBayar');
            $table->text('buktiBayar');
            $table->string('atasNama');
            $table->string('namaBank');
            $table->string('noRek');
            $table->string('statusTransaksi');
            $table->timestamps();

            $table->foreign('pencariId')->references('id')->on('user_pencaris')->onDelete('cascade');
            $table->foreign('kosId')->references('id')->on('penginapans')->onDelete('cascade');
            $table->foreign('pemilikId')->references('id')->on('user_pemiliks')->onDelete('cascade');
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
