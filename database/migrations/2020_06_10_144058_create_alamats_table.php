<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlamatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alamat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('kota_id');
            $table->foreign('kota_id')->references('id')->on('kota')
                ->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string('nama');
            $table->string('telp');
            $table->string('alamat');
            $table->text('lat')->nullable();
            $table->text('long')->nullable();
            $table->string('kode_pos');
            $table->boolean('isUtama')->default(false);

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
        Schema::dropIfExists('alamat');
    }
}
