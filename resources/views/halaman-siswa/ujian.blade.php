@extends('layouts.app')
@section('title', 'Ti-Xam - '.Auth::user()->nama)
@section('breadcrumb')
  <h1><i class="fa fa-check-square"></i> Soal Ujian</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Hi, {{ Auth::user()->nama }}</li>
  </ol>
@endsection
@section('content')
	<div class="col-md-12">
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title">Soal yang bisa dikerjakan sekarang.</h3>
	      <div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      </div>
	    </div>
	    <div class="box-body">
		    <div class="row">
		    	@if($pakets->count())
			    	@foreach($pakets as $paket_soal)
			    		<?php
			    			$check = App\Models\Jawab::where('id_soal', $paket_soal->id_soal)->where('id_user', Auth::user()->id)->first();
			    		?>
				    	<div class="col-sm-4">
				    		@if($check)
			    				<a href="{{ url('siswa/ujian/finish/'.$paket_soal->id_soal) }}">
						    		<div class="info-box bg-yellow">
					            <span class="info-box-icon"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
					            <div class="info-box-content">
					              <span class="info-box-text">{{ $paket_soal->soal->paket }}</span>
					              <div class="progress">
					                <div class="progress-bar" style="width: 100%"></div>
					              </div>
				                <span class="progress-description">{{ $paket_soal->soal->deskripsi }}</span>
				                <span>Kamu sudah menyelesaikan ujian ini.</span>
					            </div>
					          </div>
						    	</a>
				    		@else
				    			<a href="{{ url('siswa/ujian/detail/'.$paket_soal->id_soal) }}">
						    		<div class="info-box bg-green">
					            <span class="info-box-icon"><i class="fa fa-check-square-o"></i></span>
					            <div class="info-box-content">
					              <span class="info-box-text">{{ $paket_soal->soal->paket }}</span>
					              <!-- <span class="info-box-number"></span> -->
					              <div class="progress">
					                <div class="progress-bar" style="width: 100%"></div>
					              </div>
				                <span class="progress-description">{{ $paket_soal->soal->deskripsi }}</span>
					            </div>
					          </div>
						    	</a>
			    			@endif
				    	</div>
			    	@endforeach
		    	@else
						<div class="col-md-12">Belum ada soal yang bisa dikerjakan.</div>
		    	@endif
		    </div>
	    </div>
    </div>
  </div>
@endsection
@push('css')
<style>
	.bg-aqua{
		background-color: #117e98 !important;
	}
</style>
@endpush