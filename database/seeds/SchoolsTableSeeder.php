<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SchoolsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
  	$faker = Faker::create('App\Models\School');
  	for ($i=0; $i < 1; $i++) {
  		DB::table('schools')->insert([
  			'id'			=> 1,
  			'nama' 		=> 'Sekolah Bangsa',
  			'alamat' 	=> 'Jalan Agung Raya I No.26D'
  		]);
  	}
  }
}
