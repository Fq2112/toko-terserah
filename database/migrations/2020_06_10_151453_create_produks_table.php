<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable()->unique();
            $table->text('gambar');
            $table->text('galeri')->nullable();
            $table->string('kode_barang');
            $table->string('nama');
            $table->string('permalink')->unique();
            $table->string('berat');
            $table->string('harga')->nullable();
            $table->string('stock');
            $table->text('deskripsi');
            $table->text('detail');
            $table->boolean('is_diskon')->default(false);
            $table->string('diskon')->nullable();
            $table->string('harga_diskon')->nullable();
            $table->boolean('isGrosir')->default(false);
            $table->string('min_qty')->nullable();
            $table->string('harga_grosir')->nullable();
            $table->boolean('isDiskonGrosir')->default(false);
            $table->string('diskonGrosir')->nullable();
            $table->string('harga_diskon_grosir')->nullable();
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
        Schema::dropIfExists('produk');
    }
}
