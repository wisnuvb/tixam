<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Datatables;
use DB;
use Excel;
use PDF;

use App\User;
use App\Models\Jawab;
use App\Models\Detailhasil;
use App\Models\Soal;
use App\Models\Kelas;
use App\Models\Detailsoal;

class LaporanController extends Controller
{
  public function __construct()
  {
  	$this->middleware('auth');
  }
  public function index()
  {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
	  	$user = User::where('id', Auth::user()->id)->first();
	  	$kelas = Kelas::orderBy('nama', 'ASC')->paginate(20);
	  	return view('laporan.index', compact('user', 'kelas'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
  public function detailKelas(Request $request)
  {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
    	$user = User::where('id', Auth::user()->id)->first();
    	$kelas = Kelas::where('id', $request->id)->first();
    	return view('laporan.detailKelas', compact('user', 'kelas'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
  public function data_paket_soal(Request $request)
  {
  	$hasils = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')
											->select('soals.paket', 'jawabs.*')
											->where('jawabs.id_kelas', $request->id_kelas)->groupBy('jawabs.id_soal')->get();
		return Datatables::of($hasils)
												->addColumn('action', function($hasils) {
													return '<div style="text-align:center"><a href="'.$hasils->id_kelas.'/paket-soal/'.$hasils->id_soal.'" class="btn btn-primary btn-xs">Detail</a></div>';
												})
												->make(true);
  }
  public function detailPaketSoalPerKelas(Request $request)
  {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
	  	$user = User::where('id', Auth::user()->id)->first();
	  	$kelas = Kelas::where('id', $request->id_kelas)->first();
	  	$soal = Soal::where('id', $request->id_soal)->first();
	  	return view('laporan.detailKelasPaket', compact('user', 'kelas', 'soal'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
  public function dataKelasPaketSoal(Request $request)
  {
    // return $request->id_kelas;
    /*$hasils = Jawab::join('users', 'jawabs.id_user', '=', 'users.id')
                      ->select('users.nama', 'users.no_induk as nis', 'users.nisn', 'jawabs.*', DB::raw('sum(score) as jumlah_nilai'))
                      ->where('jawabs.id_soal', $request->id_soal)->get();*/
    $jawabs = Jawab::select('jawabs.*', DB::raw('sum(score) as jumlah_nilai'))
                      ->where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->groupBy('id_user');
    return Datatables::of($jawabs)
                        ->addColumn('nama', function($jawabs) {
                          if ($jawabs->user) {
                            return $jawabs->user->nama;
                          }else{
                            return 'no name';
                          }
                        })
                        ->addColumn('nis', function($jawabs) {
                          if ($jawabs->user) {
                            return $jawabs->user->no_induk;
                          }else{
                            return 'no nis';
                          }
                        })
                        ->addColumn('nisn', function($jawabs) {
                          if ($jawabs->user) {
                            return $jawabs->user->nisn;
                          }else{
                            return 'no nisn';
                          }
                        })
                        ->addColumn('jumlah_nilai', function($jawabs) {
                          return $jawabs->jumlah_nilai;
                        })
                        ->addColumn('action', function($jawabs) {
                          return '<div style="text-align:center"><a href="../../../'.$jawabs->id_soal.'/'.$jawabs->id_user.'" class="btn btn-primary btn-xs">Detail</a></div>';
                        })
                        ->make(true);
  }
  public function detailLaporanSiswa(Request $request)
  {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
    	$user = User::where('id', Auth::user()->id)->first();
      $siswa = User::where('id', $request->id_user)->first();
      $soal = Soal::select('paket', 'id')->where('id', $request->id_soal)->first();
      $hasil_ujian = Jawab::select(DB::raw('SUM(jawabs.score) as jumlah_nilai'), 'jawabs.created_at', 'jawabs.status')
                            ->where('jawabs.id_user', $request->id_user)
                            ->where('jawabs.id_soal', $request->id_soal)
                            ->first();
      return view('laporan.detailSiswa', compact('user', 'siswa', 'hasil_ujian', 'soal'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
  public function hasilSiswa(Request $request)
  {
    $jawabs = Jawab::where('jawabs.id_user', $request->id_user);
		return Datatables::of($jawabs)
												->addColumn('empty_space', function() {
													return '&nbsp;';
												})
                        ->addColumn('dataSoal', function($jawabs) {
                          if($jawabs->detailSoal){
                            return $jawabs->detailSoal->soal;
                          }else{
                            return 'No have question';
                          }
                        })
                        ->addColumn('kunci', function($jawabs) {
                          if($jawabs->detailSoal){
                            return $jawabs->detailSoal->kunci;
                          }else{
                            return 'No have question';
                          }
                        })
												->make(true);
  }
  public function excelHasilUjianPerkelas(Request $request)
  {
    $kelas = Kelas::where('id', $request->kelas)->first();
    $soal = Soal::where('id', $request->soal)->first();
    $detailSoal = Detailsoal::where('id_soal', $request->soal)->get();
    $jawabs = Jawab::where('id_soal', $request->soal)->where('id_kelas', $request->kelas)
                      ->groupBy('id_user')->get();

    // return view('laporan.excel.excel_hasil_ujian_perkelas', compact('jawabs', 'soal', 'kelas', 'detailSoal'));

    Excel::create('Nilai Kelas '.$kelas->nama, function($excel) use ($jawabs, $soal, $kelas, $detailSoal) {
      $excel->sheet('New sheet', function($sheet) use ($jawabs, $soal, $kelas, $detailSoal) {
        $sheet->setStyle(array(
          'font' => array(
            'size' =>  12,
          )
        ));
        $sheet->loadView('laporan.excel.excel_hasil_ujian_perkelas', compact('jawabs', 'soal', 'kelas', 'detailSoal'));
      });
    })->download('xlsx');
  }
  public function pdfHasilUjianPersiswa(Request $request)
  {
    $siswa = User::where('id', $request->siswa)->first();
    $jumlah_soal = Detailsoal::where('id_soal', $request->soal)->count();
    $soals = Detailsoal::where('id_soal', $request->soal)->where('status', 1)->get();
    $jawabs = Jawab::where('id_soal', $request->soal)->where('id_user', $request->siswa)->where('status', 1)->get();
    $jawabBenar = Jawab::where('id_soal', $request->soal)->where('id_user', $request->siswa)->where('status', 1)->where('score', '!=', '0')->get();
    $jawab_first = Jawab::where('id_soal', $request->soal)
                                  ->where('id_user', $request->siswa)
                                  ->where('status', 1)->first();
    $jumlah_jawaban_benar = Jawab::where('id_soal', $request->soal)
                                  ->where('id_user', $request->siswa)
                                  ->where('status', 1)
                                  ->select(DB::raw('sum(jawabs.score) as jumlahNilai'))
                                  ->first();
    $pdf = PDF::loadView('laporan.pdf.hasil_ujian', compact('jawabs', 'siswa', 'soals', 'jawabBenar', 'jumlah_jawaban_benar', 'jawab_first', 'jumlah_soal'));
    return $pdf->setPaper('legal')->stream('hasil ujian.pdf');
  }
}
