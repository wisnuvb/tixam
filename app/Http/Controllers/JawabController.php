<?php

namespace App\Http\Controllers;

use App\Models\JawabEsay;
use Illuminate\Http\Request;

class JawabController extends Controller
{
  public function simpanScore(Request $request)
  {
    $check_nilai = JawabEsay::where('id_detail_soal_esay', $request->essay_id)->where('id_user', $request->id_user)->first();
    if ($check_nilai) {
      $check_nilai->score = $request->score;
      $check_nilai->save();
    }
  }
}
