@extends('layouts.app')
@section('title', 'TiXam - Aplikasi Ujian Berbasis Komputer')
@section('breadcrumb')
  <h1>Dashboard</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/soal') }}">Soal</a></li>
    <li class="active">Ubah paket soal</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Ubah Paket Soal</h3>
    </div>
    <form class="form-horizontal" id="formSoal">
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{$soal->id}}">
      <div class="box-body">
        <div class="form-group">
          <label for="paket" class="col-sm-2 control-label">Jenis</label>
          <div class="col-sm-10">
            <select name="jenis" class="form-control">
            	<option value="{{ $soal->jenis }}">{{ getJenisSoal($soal->jenis) }}</option>
            	<option value="1">Soal Ujian</option>
            	<option value="2">Soal Latihan</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="materi" class="col-sm-2 control-label">Materi</label>
          <div class="col-sm-10">
            <select name="materi" class="form-control">
            	<option value="{{ $soal->materi }}">
            		@if($soal->materi != "")
            		{{ $soal->dataDateri->judul }}
            		@else
	            	-
            		@endif
            	</option>
            	@if($materis->count())
            	@foreach($materis as $materi)
            	<option value="{{ $materi->id }}">{{ $materi->judul }}</option>
            	@endforeach
            	@endif
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="paket" class="col-sm-2 control-label">Paket</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="paket" placeholder="Nama paket" value="{{ $soal->paket }}">
          </div>
        </div>
        <div class="form-group">
          <label for="paket" class="col-sm-2 control-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea name="deskripsi" class="form-control" placeholder="Deskripsi">{{ $soal->deskripsi }}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="kkm" class="col-sm-2 control-label">KKM</label>
          <div class="col-sm-2">
            <input type="text" class="form-control numOnly" data-toggle="tooltip" title="Hanya menerima inputan dalam format numerik" name="kkm" placeholder="KKM" value="{{ $soal->kkm }}">
          </div>
        </div>
        <div class="form-group">
          <label for="waktu" class="col-sm-2 control-label">Waktu</label>
          <div class="col-sm-2">
            <input type="text" class="form-control numOnly" data-toggle="tooltip" title="Masukan waktu ujian dalam satuan menit" name="waktu" placeholder="Waktu" value="{{ $soal->waktu }}">
          </div>
        </div>
        <div class="form-group">
        	<div class="col-sm-offset-2 col-sm-10">
        		<div id="wrap-btn">
	        		<button type="button" class="btn btn-danger" onclick="self.history.back()">Kembali</button>
			        <button type="button" class="btn btn-info" id="btnSimpan">Simpan</button>
			      </div>
            <div id="notif" style="display: none; margin-top: 15px""></div>
        	</div>
        </div>
        <div class="overlay" id="loading" style="display: none;"><i class="fa fa-refresh fa-spin" ></i></div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('css')
<style type="text/css">
  .panel {
    margin-bottom: 5px !important;
  }
  .form-group {
    margin-bottom: 5px;
  }
</style>
@endpush
@push('scripts')
<script>
$(document).ready(function(){
	$("#btnSimpan").click(function(){
		$("#wrap-btn").hide();
    $("#loading").show();
    var dataString = $("#formSoal").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-soal') }}",
      data: dataString,
      success: function(data){
        console.log(data);
        if (data == 'ok') {
          $("#loading").hide();
          $("#wrap-btn").show();
          $("#notif").removeClass('alert alert-danger').addClass('alert alert-info').html("<i class='fa fa-info-circle'></i> Data berhasil disimpan.").fadeIn(350);
          window.location.href = "{{ url('elearning/soal/detail/'.$soal->id) }}";
        }else{
          $("#loading").hide();
          $("#wrap-btn").show();
          $("#notif").removeClass('alert alert-info').addClass('alert alert-danger').html(data).fadeIn(350);
        }
      }
    })
	});
});
</script>
@endpush