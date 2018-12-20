@extends('layouts.app')
@section('title', 'Detail soal')
@section('breadcrumb')
  <h1>Detail Soal</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/elearning/soal') }}">Soal</a></li>
    <li class="active">Detail Soal</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-8">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Review Soal</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <p>
        {!! $soal->soal !!}
      </p>
      <p><input type="radio" name="pilihan" id="pil_a">
        <label for="pil_a">
          <?php $pila = str_replace("<p>", "", $soal->pila); $pila = str_replace("</p>", "", $pila); echo $pila; ?>
        </label>
      </p>
      <p><input type="radio" name="pilihan" id="pil_b">
        <label for="pil_b">
          <?php $pilb = str_replace("<p>", "", $soal->pilb); $pilb = str_replace("</p>", "", $pilb); echo $pilb; ?>
        </label>
      </p>
      <p><input type="radio" name="pilihan" id="pil_c">
        <label for="pil_c">
          <?php $pilc = str_replace("<p>", "", $soal->pilc); $pilc = str_replace("</p>", "", $pilc); echo $pilc; ?>
        </label>
      </p>
      <p><input type="radio" name="pilihan" id="pil_d">
        <label for="pil_d">
          <?php $pild = str_replace("<p>", "", $soal->pild); $pild = str_replace("</p>", "", $pild); echo $pild; ?>
        </label>
      </p>
      <p><input type="radio" name="pilihan" id="pil_e">
        <label for="pil_e">
          <?php $pile = str_replace("<p>", "", $soal->pile); $pile = str_replace("</p>", "", $pile); echo $pile; ?>
        </label>
      </p>
      <?php
        if ($soal->status == 'Y') {
          $status_soal = '<span class="label label-success">Tampil<span>';
        }else{
          $status_soal = '<span class="label label-danger">Tidak tampil</span>';
        }
      ?>
      <p>Status soal {!! $status_soal !!}</p>
      <hr>
      <a href="{{ url('elearning/soal/detail/'.$soal->id_soal) }}" class="btn btn-primary">Paket Soal</a>
      <button type="button" class="btn btn-danger" onclick="self.history.back()">Kembali</button>
      <a href="{{ url('/elearning/soal/detail/ubah/'.$soal->id) }}" class="btn btn-success">Ubah</a>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Informasi</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <p>Di halaman ini Anda dapat melihat tampilan soal yang akan dikerjakan oleh siswa.</p>
      <p>Silahkan koreksi jika soal yang tampil disamping kurang sesuai dengan yang diharapkan, Anda dapat melakukan perubahan terhadap soal tersebut.</p>
    </div>
  </div>
</div>
@endsection