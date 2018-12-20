<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('schools', function (Blueprint $table) {
      $table->increments('id');
      $table->string('nama', 150)->nullable();
      $table->string('alamat', 250)->nullable();
      $table->string('logo', 150)->nullable();
      $table->string('header', 150)->nullable();
      $table->string('motto', 250)->nullable();
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
    Schema::dropIfExists('schools');
  }
}
