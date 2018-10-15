<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Datatables;
use DB;

use App\User;
use App\Models\Kelas;
use App\Models\Aktifitas;

class KelasController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

  public function index()
  {
    if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
    	$user = User::where('id', Auth::user()->id)->first();
    	return view('kelas.index', compact('user'));
    }else{
      return redirect()->route('home.index');
    }
  }
  public function dataKelas()
  {
  	$kelas = Kelas::get();
  	if(Auth::user()->status == 'G'){
	    return Datatables::of($kelas)
    										->addColumn('empty_str', function($kelas) {
    											return '';
    										})
					              ->addColumn('action', function ($kelas) {
					                return '<div style="text-align:center"><a href="kelas/detail/'.$kelas->id.'" class="btn btn-xs btn-success">Detail</a></div>';
					              })
					              ->make(true);
		}else{
			return Datatables::of($kelas)
    										->addColumn('empty_str', function($kelas) {
    											return '';
    										})
					              ->addColumn('action', function ($kelas) {
					                return '<div style="text-align:center"><a href="" class="btn btn-xs btn-primary">Ubah</a> <a href="" class="btn btn-xs btn-danger">Hapus</a> <a href="kelas/detail/'.$kelas->id.'" class="btn btn-xs btn-success">Detail</a></div>';
					              })
					              ->make(true);
		}
  }
  public function detailKelas(Request $request)
  {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
      $user = User::where('id', Auth::user()->id)->first();
      $kelas = Kelas::where('id', $request->id)->first();
      $jumlah = User::select('id')->where('status_sekolah', 'Y')->where('id_kelas', $request->id)->count();
      return view('kelas.detail', compact('user', 'kelas', 'jumlah'));
    }else{
      return redirect()->route('home.index');
    }
  }
  public function detailKelasSiswa(Request $request)
  {
  	$siswas = User::where('status', 'S')->where('status_sekolah', 'Y')->where('id_kelas', $request->id_kelas)->get();
  	return Datatables::of($siswas)
  											->editColumn('jk', function($siswas) {
  												if($siswas->jk == 'L'){
  													return 'Laki-laki';
  												}else{
  													return 'Perempuan';
  												}
  											})
  											->addColumn('action', function($siswas) {
  												return '<div style="text-align:center"><a href="../../siswa/detail/'.$siswas->id.'" class="btn btn-xs btn-success">Detail</a></div>';
  											})
  											->make(true);
  }
}
