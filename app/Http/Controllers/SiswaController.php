<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Datatables;
use DB;
use Hash;

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
      $kelas = Kelas::get();
    	return view('siswa.index', compact('user', 'kelas'));
    }else{
      return redirect()->route('home.index');
    }
  }
  public function editSiswa(Request $request)
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
                            return '<div style="text-align:center">
                              <a href="siswa/edit/'.$siswas->id.'" class="btn btn-xs btn-primary">Ubah</a>
                              <button type="button" class="btn btn-xs btn-danger del-siswa" id="'.$siswas->id.'">Hapus</button>
                              <a href="siswa/detail/'.$siswas->id.'" class="btn btn-xs btn-success">Detail</a>
                            </div>';
                          })
                          ->rawColumns(['action'])
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
  public function getSoal($id)
  {
    $soal = Detailsoal::find($id);
    return view('halaman-siswa.get_soal', compact('soal'));
  }
  public function jawab(Request $request)
  {
    $get_jawab = explode('/', $request->get_jawab);
    $pilihan = $get_jawab[0];
    $id_detail_soal = $get_jawab[1];
    $id_siswa = $get_jawab[2];
    $detail_soal = Detailsoal::find($id_detail_soal);

    $jawab = Jawab::where('no_soal_id', $id_detail_soal)->where('id_user', Auth::user()->id)->first();
    if (!$jawab) {
      $jawab = new Jawab;
      $jawab->revisi = 0;
    }else{
      $jawab->revisi = $jawab->revisi + 1;
    }
    
    $jawab->no_soal_id = $id_detail_soal;
    $jawab->id_soal = $detail_soal->id_soal;
    $jawab->id_user = Auth::user()->id;
    $jawab->id_kelas = Auth::user()->id_kelas;
    $jawab->nama = Auth::user()->nama;
    $jawab->pilihan = $pilihan;

    $check_jawaban = Detailsoal::where('id', $id_detail_soal)->where('kunci', $pilihan)->first();
    if ($check_jawaban) {
      $jawab->score = $detail_soal->score;
    }else{
      $jawab->score = 0;
    }
    $jawab->status = 0;
    $jawab->save();
    return 1;
  }

  public function kirimJawaban(Request $request)
  {
    Jawab::where('id_soal', $request->id_soal)->where('id_user', Auth::user()->id)->update(['status' => 1]);
  }

  public function finishUjian($id)
  {
    $soal = Soal::find($id);
    $nilai = Jawab::where('id_soal', $id)->where('id_user', Auth::user()->id)->sum('score');
    return view('halaman-siswa.finish', compact('soal', 'nilai'));
  }

  public function delete()
  {
    return view('siswa.delete');
  }

  public function getBtnDelete($password)
  {
    $validate_admin = User::where('email', Auth::user()->email)->first();
    if ($validate_admin && Hash::check($password, $validate_admin->password)) {
      $cocok = 'Y';
    }else{
      $cocok = 'N';
    }
    return view('siswa.tombol_hapus', compact('cocok'));
  }

  public function deleteAll()
  {
    $users = User::where('status', 'S')->get();
    foreach ($users as $key => $value) {
      $jawab = Jawab::where('id_user', $value->id)->first();
      if ($jawab) {
        $jawab->delete();
      }
    }
    User::where('status', 'S')->delete();
  }
}
