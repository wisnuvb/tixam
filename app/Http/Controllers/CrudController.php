<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Auth;
use Image;

use App\User;
use App\Models\Materi;
use App\Models\Distribusisoal;
use App\Models\School;

class CrudController extends Controller
{
  public function __construct()
  {
  	$this->middleware('auth');
  }

  public function updateProfil(Request $request)
  {
  	if($request->nama == ""){
  		return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Nama tidak boleh kosong.";
  	}elseif ($request->jk == "") {
  		return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Jenis kelamin tidak boleh kosong.";
  	}elseif ($request->email == "") {
  		return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak boleh kosong.";
  	}elseif(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
  		return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak valid.";
  	}else{
      $cek_email = User::where('id', '!=', Auth::user()->id)->where('email', $request->email)->first();
      if ($cek_email != "") {
        return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email sudah terdaftar, silahkan ganti dengan yang lain.";
      }else{
    		$query = User::where('id', $request->id)->first();
    		if ($query != "") {
    			$query->nama = $request->nama;
    			$query->no_induk = $request->no_induk;
    			$query->jk = $request->jk;
  	  		$cek_email = User::where('email', $request->email)->where('id', '!=', $request->id)->first();
  	  		if ($cek_email == "") {
  	  			$query->email = $request->email;
  	  		}
  	  		if ($request->password != "") {
  	  			$query->password = bcrypt($request->password);
  	  		}
  	  		$query->save();
  	  	}
  	  	return 'ok';
      }
  	}
  }
  public function simpanMateri(Request $request)
  {
    // return $request->judul;
    if($request->judul == ""){
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Judul tidak boleh kosong.";
    }elseif($request->isi == ""){
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Isi materi tidak boleh kosong.";
    }elseif($request->status == ""){
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Status tampil materi tidak boleh kosong.";
    }else{
      $cek = Materi::where('sesi', $request->sesi)->first();
      if($cek == ""){
        $query = new Materi;
        $query->id_user = Auth::user()->id;
        $query->sesi = $request->sesi;
        $query->hits = 0;
      }else{
        $query = Materi::where('sesi', $request->sesi)->first();
      }
      $query->judul = $request->judul;
      $query->isi = $request->isi;
      $query->status = $request->status;
      $query->save();
      return 'ok';
    }
  }
  public function simpanGambarMateri(Request $request)
  {
    $sesi = $request->sesi_gambar;
    $uniqname = date('ymdhis').rand(00000,99999);
    $filename = trim(addslashes($_FILES['file']['name']));
    $filenamehapusspasi = str_replace(' ', '_', $filename);
    $savename = md5(round(microtime(true))) . '_' . $filenamehapusspasi;
    $img = Image::make($_FILES['file']['tmp_name']);
    $img->resize(720, null, function ($constraint) {
      $constraint->aspectRatio();
    });
    $img->save('assets/img/materi/'.$savename);
    $thumnews = Image::make($_FILES['file']['tmp_name']);
    $thumnews->resize(150, null, function ($constraint) {
      $constraint->aspectRatio();
    });
    $thumnews->save('assets/img/materi/thumb/'.$savename);

    $cek = Materi::where('sesi', $sesi)->first();
    if ($cek == "") {
      $query = new Materi;
      $query->id_user = Auth::user()->id;
      $query->sesi = $sesi;
      $query->status = 'N';
      $query->hits = 0;
    }else{
      if ($cek->gambar != "") {
        unlink('assets/img/materi/'.$cek->gambar);
        unlink('assets/img/materi/thumb/'.$cek->gambar);
      }
      $query = Materi::where('sesi', $sesi)->first();
    }
    $query->gambar = $savename;
    $query->save();
    return "ok";
  }
  public function terbitSoal(Request $request)
  {
    $cek = Distribusisoal::where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->first();
    if ($cek != "") {
      Distribusisoal::where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->delete();
      return 'N';
    }else{
      $query = new Distribusisoal;
      $query->id_soal = $request->id_soal;
      $query->id_kelas = $request->id_kelas;
      $query->save();
      return 'Y';
    }
  }
  public function hapusGambarMateri(Request $request)
  {
    $cek = Materi::where('id', $request->id)->first();
    if ($cek != "") {
      unlink('assets/img/materi/'.$cek->gambar);
      unlink('assets/img/materi/thumb/'.$cek->gambar);
      $cek->gambar = '';
      $cek->save();
    }
  }
  public function simpanGambarUser(Request $request)
  {
    $id = $request->id_user_gambar;
    $uniqname = date('ymdhis').rand(00000,99999);
    $filename = trim(addslashes($_FILES['file']['name']));
    $filenamehapusspasi = str_replace(' ', '_', $filename);
    $savename = md5(round(microtime(true))) . '_' . $filenamehapusspasi;
    $img = Image::make($_FILES['file']['tmp_name']);
    $img->resize(350, null, function ($constraint) {
      $constraint->aspectRatio();
    });
    $img->save('assets/img/user/'.$savename);
    $cek = User::where('id', $id)->first();
    if ($cek != "") {
      if ($cek->gambar != "") {
        unlink('assets/img/user/'.$cek->gambar);
      }
      $query = User::where('id', $id)->first();
    }
    $query->gambar = $savename;
    $query->save();
    return "ok";
  }
  public function updateProfilSekolah(Request $request)
  {
    $jenis = $request->jenisInfo;
    $query = School::first();
    $query->nama = $request->nama;
    $query->alamat = $request->alamat;
    $query->motto = $request->motto;
    $query->kab_kot = $request->kab_kot;
    $query->nama_kepsek = $request->nama_kepsek;
    $query->nip_kepsek = $request->nip_kepsek;
    $query->save();
    if ($jenis == 'nama') {
      return $request->nama;
    }elseif ($jenis == 'alamat') {
      return $request->alamat;
    }elseif ($jenis == 'motto') {
      return $request->motto;
    }elseif ($jenis == 'kab_kot') {
      return $request->kab_kot;
    }elseif ($jenis == 'nama_kepsek') {
      return $request->nama_kepsek;
    }elseif ($jenis == 'nip_kepsek') {
      return $request->nip_kepsek;
    }else{
      return 'Something hes error.';
    }
  }
  public function simpanGuru(Request $request)
  {
    if($request->nama == ""){
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Nama tidak boleh kosong.";
    }elseif ($request->email == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak boleh kosong.";
    }elseif(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak valid.";
    }elseif ($request->jk == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Jenis kelamin tidak boleh kosong.";
    }else{
      $cek_email = User::where('id', '!=', $request->id)->where('email', $request->email)->first();
      if ($cek_email != "") {
        return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email sudah terdaftar, silahkan ganti dengan yang lain.";
      }else{
        if ($request->id == 'N') {
          $query = new User;
          $query->password = bcrypt(123456);
          if ($request->no_induk == "") {
            $query->no_induk = '-';
          }else{
            $query->no_induk = $request->no_induk;
          }
        }else{
          $query = User::where('id', $request->id)->first();
          if ($request->password != "") {
            $query->password = bcrypt($request->password);
          }
          $query->no_induk = $request->no_induk;
        }
        $query->nama = $request->nama;
        $query->email = $request->email;
        $query->jk = $request->jk;
        $query->status = "G";
        $query->save();
        return 'ok';
      }
    }
  }
  public function updateSiswa(Request $request)
  {
    // dd($request->all());
    if ($request->id == 'N') {
      $query = new User;
      $query->password = bcrypt(123456);
    }else{
      $query = User::where('id', $request->id)->first();
      if ($request->password != '') {
        $query->password = bcrypt($request->password);
      }
    }
    $query->id_kelas = $request->kelas;
    $query->nama = $request->nama;
    $query->no_induk = $request->no_induk;
    $query->nisn = $request->nisn;
    $query->jk = $request->jk;
    $query->email = $request->email;
    $query->save();
    return 'ok';
  }
  public function updateGuru(Request $request)
  {
    // dd($request->all());
    if ($request->id == 'N') {
      $query = new User;
      $query->password = bcrypt(123456);
    }else{
      $query = User::where('id', $request->id)->first();
      if ($request->password != '') {
        $query->password = bcrypt($request->password);
      }
    }
    $query->nama = $request->nama;
    $query->no_induk = $request->no_induk;
    $query->jk = $request->jk;
    $query->email = $request->email;
    $query->save();
    return 'ok';
  }
}
