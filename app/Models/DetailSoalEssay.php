<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSoalEssay extends Model
{
  protected $table = 'detail_soal_esays';

  public function getJawab()
  {
    return $this->hasOne(JawabEsay::class, 'id_detail_soal_esay', 'id');
  }

  public function userJawab()
  {
    return $this->hasOne(JawabEsay::class, 'id_detail_soal_esay', 'id')->where('id_user', auth()->user()->id);
  }

  public function saveEssay($request)
  {
    $save = new DetailSoalEssay;
    $save->id_soal = $request->soal_id;
    $save->soal = $request->soal;
    $save->status = $request->status;
    $save->save();
  }

  public function updateEssay($request, $essay)
  {
    $essay->soal = $request->soal;
    $essay->status = $request->status;
    $essay->save();
  }
}
