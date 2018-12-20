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
      $gurus = User::whereIn('status', ['G', 'A'])->get();
    	return view('kelas.index', compact('user', 'gurus'));
    }else{
      return redirect()->route('home.index');
    }
  }
  public function dataKelas()
  {
  	$kelas = Kelas::with('siswa')->get();
  	if(Auth::user()->status == 'G'){
	    return Datatables::of($kelas)
    										->addColumn('empty_str', function($kelas) {
    											return '';
    										})
					              ->addColumn('action', function ($kelas) {
					                return '<div style="text-align:center"><a href="kelas/detail/'.$kelas->id.'" class="btn btn-xs btn-success">Detail</a></div>';
					              })
                        ->addColumn('siswa', function ($kelas) {
                          if ($kelas) {
                            $siswa = User::where('status', 'S')->where('id_kelas', $kelas->id)->count();
                            return '<center>'.$siswa.' siswa</center>';
                          }else{
                            return '<center>kelas kosong</center>';
                          }
                        })
                        ->addColumn('wali', function ($kelas) {
                          if ($kelas->wali) {
                            return '<center>'.$kelas->wali->nama.'</center>';
                          }else{
                            return '<center><label class="label label-danger">tidak ada</label></center>';
                          }
                        })
                        ->rawColumns(['action', 'siswa', 'wali'])
					              ->make(true);
		}else{
			return Datatables::of($kelas)
    										->addColumn('empty_str', function($kelas) {
    											return '';
    										})
					              ->addColumn('action', function ($kelas) {
					                return '<div style="text-align:center">
                            <a href="kelas/ubah/'.$kelas->id.'" class="btn btn-xs btn-primary">Ubah</a>
                            <button type="button" class="btn btn-xs btn-danger del-kelas" id='.$kelas->id.'>Hapus</button>
                            <a href="kelas/detail/'.$kelas->id.'" class="btn btn-xs btn-success">Detail</a>
                          </div>';
					              })
                        ->addColumn('siswa', function ($kelas) {
                          if ($kelas) {
                            $siswa = User::where('status', 'S')->where('id_kelas', $kelas->id)->count();
                            return '<center>'.$siswa.' siswa</center>';
                          }else{
                            return '<center>kelas kosong</center>';
                          }
                        })
                        ->addColumn('wali', function ($kelas) {
                          if ($kelas->wali) {
                            return '<center>'.$kelas->wali->nama.'</center>';
                          }else{
                            return '<center><label class="label label-danger">tidak ada</label></center>';
                          }
                        })
                        ->rawColumns(['action', 'siswa', 'wali'])
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
  public function ubahKelas($id)
  {
    if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
      $user = User::where('id', Auth::user()->id)->first();
      $kelas = Kelas::where('id', $id)->first();
      $gurus = User::whereIn('status', ['G', 'A'])->get();
      return view('kelas.form.ubah', compact('user', 'kelas', 'gurus'));
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
