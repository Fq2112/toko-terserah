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
            $table->foreign('user_id')->references('id')
                ->on('users');
            $table->foreignId('keranjang_id');
            $table->foreign('keranjang_id')->references('id')
                ->on('keranjang');
            $table->foreignId('alamat_id');
            $table->foreign('alamat_id')->references('id')
                ->on('alamat');
            $table->string('uni_code');
            $table->string('ongkir');
            $table->string('berat_barang');
            $table->string('total_harga');
            $table->text('note')->nullable();
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
