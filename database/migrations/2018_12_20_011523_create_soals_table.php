<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('jenis', 1)->nullable();
            $table->integer('materi')->nullable();
            $table->string('paket', 255)->nullable();
            $table->string('deskripsi', 255)->nullable();
            $table->decimal('kkm')->nullable();
            $table->string('waktu', 32)->nullable();
            $table->string('tampil', 1)->nullable();
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
        Schema::dropIfExists('soals');
    }
}
