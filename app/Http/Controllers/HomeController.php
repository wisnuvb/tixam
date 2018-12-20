<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\User;
use App\Models\Soal;
use App\Models\Materi;
use App\Models\Aktifitas;
use App\Models\Detailsoal;
use App\Models\School;

class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $siswas = User::where('status', 'S')->count();
    $gurus = User::where('status', 'G')->count();
    $pakets = Soal::where('jenis', 1)->count();
    $soals = Detailsoal::count();
    $materis = Materi::where('status', 'Y')->count();
    $aktifitas = Aktifitas::orderBy('id', 'DESC')->paginate(5);
    return view('home', compact('siswas', 'gurus', 'pakets', 'materis', 'aktifitas', 'soals'));
    // if (Auth::user()->status == 'A' || Auth::user()->status == 'S') {
    // }else{
    //   return view('home', compact('siswas', 'gurus', 'pakets', 'materis', 'aktifitas'));
    // }
  }

  public function pengaturan()
  {
    $user = User::findorfail(Auth::user()->id);
    $sekolah = School::first();
    return view('pengaturan.index', compact('user', 'sekolah'));
  }

  public function activity()
  {
    return view('errors.404');
  }
}
