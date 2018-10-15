<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Soal;
use App\Models\Materi;
use App\Models\Aktifitas;

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
    $materis = Materi::where('status', 'Y')->count();
    $aktifitas = Aktifitas::orderBy('id', 'DESC')->paginate(5);
    return view('home', compact('siswas', 'gurus', 'pakets', 'materis', 'aktifitas'));
  }
}
