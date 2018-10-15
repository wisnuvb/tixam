<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Datatables;
use DB;

use App\User;
use App\Models\Materi;

class MateriController extends Controller
{
  public function __controller()
  {
  	$this->middleware('auth');
  }
  public function index() {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
	  	$user = User::where('id', Auth::user()->id)->first();
	  	return view('materi.index', compact('user'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
  public function dataMateriGuru ()
  {
  	if(Auth::user()->status == 'G'){
	  	$materis = Materi::where('id_user', Auth::user()->id)->get();
	  }else{
	  	$materis = Materi::get();
	  }
	  return Datatables::of($materis)
	  										->editColumn('status', function($materis) {
	  											if ($materis->status == 'Y') {
	  												return 'Tampil';
	  											}else{
	  												return 'Tidak tampil';
	  											}
	  										})
	  										->editColumn('hits', function($materis) {
	  											return $materis->hits.' kali';
	  										})
	  										->addColumn('action', function($materis) {
	  											return '<div style="text-align:center"><a href="materi/detail/'.$materis->id.'" class="btn btn-primary btn-xs">Detail</a></div>';
	  										})->make(true);
  }
  public function detail(Request $request)
  {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
	  	$user = User::where('id', Auth::user()->id)->first();
	  	$materi = Materi::where('id', $request->id)->first();
	  	return view('materi.detail', compact('user', 'materi'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
  public function ubah(Request $request)
  {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
	  	$user = User::where('id', Auth::user()->id)->first();
	  	$materi = Materi::where('id', $request->id)->first();
	  	return view('materi.form.ubah', compact('user', 'materi'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
}
