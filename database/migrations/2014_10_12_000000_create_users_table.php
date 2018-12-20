<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_kelas', 25)->nullable();
            $table->string('nama', 50);
            $table->string('no_induk', 25)->nullable();
            $table->string('nisn', 25)->nullable();
            $table->string('jk', 5)->nullable();
            $table->string('status', 5);
            $table->string('gambar', 200)->nullable();
            $table->string('status_sekolah', 5)->nullable();
            $table->string('sekolah_asal', 100)->nullable();
            $table->string('email', 150)->unique();
            $table->string('password', 200);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
