<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
  protected $table = "aktifitas";

  public function dataAktifitasUser()
  {
  	return $this->belongsTo('App\User', 'id_user');
  	// return $this->belongsTo('App\Models\Materi', 'materi');
  }
}
