@extends('layouts.app')
@section('title', 'Detail materi')
@section('breadcrumb')
  <h1>Detail Materi</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/siswa/materi') }}">Materi</a></li>
    <li class="active">{{ $materi->judul }}</li>
  </ol>
@endsection
@section('content')
	<?php include(app_path().'/functions/myconf.php'); ?>
	<div class="col-md-8">
	  <div class="box box-primary">
	  	<div class="box-header with-border">
	      <h3 class="box-title">{{ $materi->judul }}</h3>
	    </div>
	    <div class="box-body">
	    @if($materi->gambar != "")
	      <img src="{{ url('/assets/img/materi/'.$materi->gambar) }}" class="img img-thumbnail" alt="img">
	    @else
	      <img src="{{ url('/assets/img/noimage.jpg') }}" class="img img-thumbnail" alt="img">
	    @endif
	    <p style="margin-top: 20px">
	      {!! $materi->isi !!}
	    </p>
	    <button class="btn btn-warning btn-md" onclick="self.history.back()"><i class="fa fa-reply" aria-hidden="true"></i> Kembali</button>
	    @if($latihan)
		    <a href="{{ url('/siswa/materi/soal/'.$materi->id) }}" class="btn btn-primary btn-md">Latihan</a>
	    @endif
	    </div>
	  </div>
  </div>
  <div class="col-md-4">
	  <div class="box box-warning">
	    <div class="box-header with-border">
	      <h3 class="box-title" style="color: darkorange"><i class="fa fa-info-circle"></i> Informasi</h3>
	    </div>
	    <div class="box-body">
	      <table class="table table-condensed table-striped">
	        <tr>
	          <td>Ditulis oleh</td>
	          <td>:</td>
	          <td>{{ $materi->getUser->nama }}</td>
	        </tr>
	        <tr>
	          <td>Tanggal terbit</td>
	          <td>:</td>
	          <td>{{ timeStampIndo($materi->created_at) }}</td>
	        </tr>
	        <tr>
	          <td>Terakhir diupdate</td>
	          <td>:</td>
	          <td>{{ timeStampIndo($materi->updated_at) }}</td>
	        </tr>
	        <tr>
	          <td>Dibaca</td>
	          <td>:</td>
	          <td>{{ number_format($materi->hits,0,'.','.') }} <small>kali</small></td>
	        </tr>
	      </table>
	    </div>
	  </div>
	</div>
@endsection