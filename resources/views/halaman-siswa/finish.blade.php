@extends('layouts.app')
@section('title', 'Ti-Xam - '.Auth::user()->nama)
@section('breadcrumb')
  <h1>Detail Soal Ujian</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/siswa/ujian') }}">Ujian</a></li>
    <li class="active">Selesai Ujian</li>
  </ol>
@endsection
@section('content')
	<div class="col-md-12">
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title">Selesai Ujian</h3>
	    </div>
	    <div class="box-body">
	    	<center>
	    		<!-- @if($soal->kkm < $nilai)
		    		<i class="fa fa-smile-o" aria-hidden="true" style="font-size: 50pt; color: #18b10f;"></i>
		    	@else
		    		<i class="fa fa-frown-o" aria-hidden="true" style="font-size: 50pt; color: #d61515;"></i>
		    	@endif -->
	    		<i class="fa fa-smile-o" aria-hidden="true" style="font-size: 50pt; color: #18b10f;"></i>
	    		<p style="color: #848383; font-size: 14pt; margin: 0">Selamat, kamu telah berhasil menyelesaikan ujian <b>{{ $soal->paket }}</b></p>
	    		<!-- <p style="color: #848383; font-size: 14pt; margin: 0"><small>Nilai yang kamu dapat:</small> <b>{{ number_format($nilai) }}</b></p> -->
	    		<p style="color: #848383; font-size: 14pt; margin: 0">
	    			Nilai kamu sudah keluar, tapi rahasia dulu ya. Dan jangan lupa selalu belajar dengan giat ya!
	    			<!-- @if($soal->kkm < $nilai)
	    				Selamat kamu lulus KKM ujian ini.
	    			@else
	    				Sepertinya nilai kamu belum cukup untuk KKM (<b>{{ number_format($soal->kkm) }}</b>) ujian ini. Belajar yang giat ya!
	    			@endif -->
	    		</p>
	    	</center>
	    </div>
	  </div>
	</div>
@endsection