<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->nullable();
            $table->string('judul', 255)->nullable();
            $table->longText('isi');
            $table->string('gambar', 255)->nullable();
            $table->string('status', 1)->nullable();
            $table->integer('hits')->nullable();
            $table->string('sesi', 32)->nullable();
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
        Schema::dropIfExists('materis');
    }
}
