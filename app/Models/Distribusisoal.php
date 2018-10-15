<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribusisoal extends Model
{
  public function soal()
  {
  	return $this->belongsTo('App\Models\Soal', 'id_soal');
  }
  public function kelas()
  {
  	return $this->belongsTo('App\Models\Kelas', 'id_kelas');
  }
}
