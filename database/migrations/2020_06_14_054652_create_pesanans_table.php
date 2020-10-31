<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->text('keranjang_ids');
            $table->foreignId('pengiriman_id');
            $table->foreign('pengiriman_id')->references('id')->on('alamat')
                ->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('penagihan_id');
            $table->foreign('penagihan_id')->references('id')->on('alamat')
                ->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('uni_code')->unique();
            $table->string('ongkir')->nullable();
            $table->string('durasi_pengiriman')->nullable();
            $table->string('berat_barang')->nullable();
            $table->string('total_harga');
            $table->text('note')->nullable();
            $table->string('promo_code')->nullable();
            $table->boolean('is_discount')->default(false);
            $table->string('discount')->nullable();
            $table->boolean('isLunas')->default(false);
            $table->string('kode_kurir')->nullable();
            $table->string('nama_kurir')->nullable();
            $table->string('layanan_kurir')->nullable();
            $table->string('resi')->nullable()->unique();
            $table->dateTime('tgl_pengiriman')->nullable();
            $table->dateTime('tgl_diterima')->nullable();
            $table->boolean('isAmbil')->default(false);
            $table->boolean('is_kurir_terserah')->default(false);
            $table->boolean('is_reviewed')->default(false);
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
        Schema::dropIfExists('pesanans');
    }
}
