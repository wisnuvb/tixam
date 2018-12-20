<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailsoals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_soal');
            $table->string('jenis', 5);
            $table->longText('soal');
            $table->string('audio', 255)->nullable();
            $table->longText('pila');
            $table->longText('pilb');
            $table->longText('pilc');
            $table->longText('pild')->nullable();
            $table->longText('pile')->nullable();
            $table->string('kunci', 1);
            $table->decimal('score', 5)->nullable();
            $table->integer('id_user');
            $table->string('status', 1);
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
        Schema::dropIfExists('detailsoals');
    }
}
