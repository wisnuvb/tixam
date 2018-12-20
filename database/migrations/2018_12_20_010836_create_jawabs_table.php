<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJawabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawabs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_soal_id', 15);
            $table->integer('id_soal');
            $table->integer('id_user');
            $table->integer('id_kelas')->nullable();
            $table->string('nama', 255)->nullable();
            $table->string('pilihan', 1);
            $table->decimal('score');
            $table->string('status', 1);
            $table->integer('revisi')->nullable();
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
        Schema::dropIfExists('jawabs');
    }
}
