<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_maintenance')->default(false);
            $table->string('logo')->nullable();
            $table->string('fav_icon')->nullable();
            $table->string('email')->nullable();
            $table->text('tag_line')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('harga_pengiriman')->nullable();
            $table->string('min_berat')->nullable();
            $table->string('min_pembelian')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
