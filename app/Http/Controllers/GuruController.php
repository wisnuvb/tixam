<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Datatables;
use Carbon\Carbon;
use DB;

use App\User;
use App\Models\Soal;
use App\Models\Aktifitas;

class GuruController extends Controller
{
  public function __construct()
  {
	$this->middleware('auth');
  }

  public function index()
  {
    if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
    	$user = User::where('id', Auth::user()->id)->first();
    	return view('guru.index', compact('user'));
    }else{
      return redirect()->route('home.index');
    }
  }
  public function dataGuru()
  {
  	$gurus = User::where('status', 'G')->get();
    return Datatables::of($gurus)
    										->addColumn('empty_str', function($gurus) {
    											return '';
    										})
                        ->editColumn('jk', function($gurus){
                          if($gurus->jk == 'L'){
                            return "Laki-laki";
                          }else{
                            return "Perempuan";
                          }
                        })
					              ->addColumn('action', function ($gurus) {
                          if(Auth::user()->status == 'G'){
  					                return '<div style="text-align:center"><a href="guru/detail/'.$gurus->id.'" class="btn btn-xs btn-success">Detail</a></div>';
                          }else{
                            return '<div style="text-align:center">
                              <a href="guru/ubah/'.$gurus->id.'" class="btn btn-xs btn-primary">Ubah</a>
                              <button type="button" class="btn btn-xs btn-danger del-guru" id='.$gurus->id.'>Hapus</button>
                              <a href="guru/detail/'.$gurus->id.'" class="btn btn-xs btn-success">Detail</a></div>';
                          }
					              })
					              ->make(true);
  }
  public function detailGuru(Request $request)
  {
    $tanggal = date('d-m-Y');
    // $tanggal = new Carbon;
    if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
      $user = User::where('id', Auth::user()->id)->first();
      $guru = User::where('id', $request->id)->first();
      $grup_aktifitas = Aktifitas::where('id_user', $request->id)->whereDate('created_at', DB::raw('CURDATE()'))->paginate(5);
      return view('guru.detail', compact('user', 'guru', 'grup_aktifitas', 'tanggal'));
    }else{
      return redirect()->route('home.index');
    }
  }
  public function ubahGuru(Request $request)
  {
    if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
      $user = User::where('id', Auth::user()->id)->first();
      $guru = User::where('id', $request->id)->first();
      return view('guru.form.ubah', compact('user', 'guru'));
    }else{
      return redirect()->route('home.index');
    }
  }
}
