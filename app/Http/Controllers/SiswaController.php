<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Datatables;
use DB;

use App\User;
use App\Models\Soal;
use App\Models\Aktifitas;
use App\Models\Jawab;
use App\Models\Materi;
use App\Models\Kelas;
use App\Models\Distribusisoal;
use App\Models\Detailsoal;

class SiswaController extends Controller
{
  public function __construct()
  {
	$this->middleware('auth');
  }

  public function index()
  {
    if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
    	$user = User::where('id', Auth::user()->id)->first();
    	return view('siswa.index', compact('user'));
    }else{
      return redirect()->route('home.index');
    }
  }
  public function ubahSiswa(Request $request)
  {
    if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
      $user = User::where('id', Auth::user()->id)->first();
      $siswa = User::where('id', $request->id)->first();
      $kelas = Kelas::select('id', 'nama')->get();
      return view('siswa.form.ubah', compact('user', 'siswa', 'kelas'));
    }else{
      return redirect()->route('home.index');
    }
  }
  public function dataSiswa()
  {
  	/*$siswas = User::join('kelas', 'users.id_kelas', '=', 'kelas.id')
                    ->select('kelas.nama as nama_kelas', 'users.*')
                    ->where('status', 'S')->get();*/
    $siswas = User::where('status', 'S');
    if(Auth::user()->status == 'G') {
      return Datatables::of($siswas)
      										->addColumn('kelas', function($siswas) {
      											return 'ini kelas';
      										})
                          ->editColumn('jk', function($siswas) {
                            if($siswas->jk == 'L'){
                              return 'Laki-laki';
                            }else{
                              return 'Perempuan';
                            }
                          })
                          ->addColumn('kelas', function($siswas) {
                            if($siswas->getKelas){
                              return $siswas->getKelas->nama;
                            }else{
                              return "-";
                            }
                          })
  					              ->addColumn('action', function ($siswas) {
  					                return '<div style="text-align:center"><a href="siswa/detail/'.$siswas->id.'" class="btn btn-xs btn-success">Detail</a></div>';
  					              })
  					              ->make(true);
    }elseif(Auth::user()->status == 'A') {
      return Datatables::of($siswas)
                          ->addColumn('kelas', function($siswas) {
                            return 'ini kelas';
                          })
                          ->editColumn('jk', function($siswas) {
                            if($siswas->jk == 'L'){
                              return 'Laki-laki';
                            }else{
                              return 'Perempuan';
                            }
                          })
                          ->addColumn('kelas', function($siswas) {
                            if($siswas->getKelas){
                              return $siswas->getKelas->nama;
                            }else{
                              return "-";
                            }
                          })
                          ->addColumn('action', function ($siswas) {
                            return '<div style="text-align:center"><a href="" class="btn btn-xs btn-primary">Ubah</a> <a href="" class="btn btn-xs btn-danger">Hapus</a> <a href="siswa/detail/'.$siswas->id.'" class="btn btn-xs btn-success">Detail</a></div>';
                          })
                          ->make(true);
    }
  }
  public function detailSiswa(Request $request)
  {
    if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
      $user = User::where('id', Auth::user()->id)->first();
      $siswa = User::where('id', $request->id)->first();
      $hasil_ujians = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')
                              ->select('soals.paket', 'jawabs.*', DB::raw('SUM(jawabs.score) as jumlah_nilai'))
                              ->where('jawabs.id_user', $siswa->id)->where('soals.id_user', Auth::user()->id)
                              ->orderBy('jawabs.id', 'DESC')->groupBy('jawabs.id_soal')->paginate(15);
      return view('siswa.detail', compact('user', 'siswa', 'hasil_ujians'));
    }else{
      return redirect()->route('home.index');
    }
  }
  public function dataMateri(Request $request)
  {
    $materis = Materi::select("*")->where('status', 'Y');
    return Datatables::of($materis)
                        ->addColumn('action', function ($materis) {
                          if (request()->segment(1) == "siswa") {
                            return '<div style="text-align:center"><a href="materi/detail/'.$materis->id.'" class="btn btn-xs btn-success">Detail</a></div>';
                          }else{
                            return '<div style="text-align:center"><a href="siswa/materi/detail/'.$materis->id.'" class="btn btn-xs btn-success">Detail</a></div>';
                          }
                        })
                        ->addColumn('dibuat', function($materis) {
                          if ($materis->getUser) {
                            if ($materis->getUser->jk == 'L') {
                              $sapa = "Pak ";
                            }else{
                              $sapa = 'Ibu ';
                            }
                            return $sapa.$materis->getUser->nama;
                          }else{
                            return '-';
                          }
                        })
                        ->make(true);
  }
  public function detailMateri($id)
  {
    $user = User::where('id', Auth::user()->id)->first();
    $materi = Materi::where('id', $id)->where('status', 'Y')->first();
    $materi->hits = $materi->hits + 1;
    $materi->save();
    $latihan = Soal::where('materi', $materi->id)->first();
    return view('halaman-siswa.detail_materi', compact('user', 'materi', 'latihan'));
  }
  public function materi()
  {
    $user = User::where('id', Auth::user()->id)->first();
    return view('halaman-siswa.materi', compact('user'));
  }
  public function ujian()
  {
    $user = User::where('id', Auth::user()->id)->first();
    $pakets = Distribusisoal::where('id_kelas', Auth::user()->id_kelas)->get();
    return view('halaman-siswa.ujian', compact('user', 'pakets'));
  }
  public function detailUjian($id)
  {
    $check_soal = Distribusisoal::where('id_soal', $id)->where('id_kelas', Auth::user()->id_kelas)->first();
    if ($check_soal) {
      $soal = Soal::where('id', $id)->first();
      $soals = Detailsoal::where('id_soal', $id)->where('status', 'Y')->inRandomOrder()->get();
      return view('halaman-siswa.detail_ujian', compact('soal', 'soals'));
    }else{
      return redirect()->route('home.index');
    }
  }
}
