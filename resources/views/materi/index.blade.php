@extends('layouts.app')
@section('title', 'Materi')
@section('breadcrumb')
  <h1>Materi <small>daftar materi yang Anda miliki</small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Materi</li>
  </ol>
@endsection
@section('content')
  <div class="col-md-8">
    <div class="box box-primary">
    	<div class="box-header with-border">
        <h3 class="box-title">Daftar materi Anda</h3>
      </div>
      <div class="box-body">
        <p class="alert alert-info"><i class="fa fa-info-circle"></i> Fitur materi masih dalam tahap pengembangan. Fitur ini sedang kami bangun integrasi dengan portal <a href="https://ayosinau.com" target="_blank">Ayosinau.com</a>. Untuk itu, selalu pantau update TiXam di akun Github TiXam ya <i class="fa fa-smile-o" aria-hidden="true"></i>.</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title" style="color: darkorange"><i class="fa fa-info-circle"></i> Informasi</h3>
      </div>
      <div class="box-body">
        <p>Tulis materi sesuai yang Anda kuasai untuk dapat diakses oleh siswa Anda. Semakin banyak materi yang di publish akan memperkaya konten dari aplikasi ini dan bermanfaat untuk siswa Anda.</p>
      </div>
    </div>
  </div>
@endsection