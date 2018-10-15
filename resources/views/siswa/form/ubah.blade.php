@extends('layouts.app')
@section('title', 'Data siswa')
@section('breadcrumb')
  <h1>Master Data</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/home') }}">Siswa</a></li>
    <li class="active">Ubah data siswa</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-8">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Ubah Data Siswa</h3>
    </div>
    <div class="box-body">
    	<form class="form-horizontal" id="form-siswa">
        <div class="box-body">
          <div class="form-group">
            <label for="nama" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-10">
              <input type="hidden" name="id" value="{{ $siswa->id }}">
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="{{ $siswa->nama }}">
            </div>
          </div>
          <div class="form-group">
            <label for="no_induk" class="col-sm-2 control-label">NIS</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="no_induk" name="no_induk" placeholder="NIS" value="{{ $siswa->no_induk }}">
            </div>
          </div>
          <div class="form-group">
            <label for="nisn" class="col-sm-2 control-label">NISN</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nisn" name="nisn" placeholder="NISN" value="{{ $siswa->nisn }}">
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $siswa->email }}">
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
          </div>
          <div class="form-group">
            <label for="kelas" class="col-sm-2 control-label">Kelas</label>
            <div class="col-sm-10">
              <select class="form-control select2Class" id="kelas" name="kelas">
              	<option value="@if($siswa->getKelas) {{ $siswa->getKelas->id }} @else Pilih kelas @endif">@if($siswa->getKelas) {{ $siswa->getKelas->nama }} @else Pilih kelas @endif</option>
              	@if($kelas->count())
              	@foreach($kelas as $data_kelas)
              		<option value="{{ $data_kelas->id }}">{{ $data_kelas->nama }}</option>
              	@endforeach
              	@endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Jenis kelamin</label>
            <div class="col-sm-10">
              <div class="radio">
                <label>
                  <input type="radio" name="jk" id="l" value="L" @if($siswa->jk == 'L') checked @endif> Laki-laki
                </label>&nbsp;&nbsp;&nbsp;&nbsp;
                <label>
                  <input type="radio" name="jk" id="p" value="P" @if($siswa->jk == 'P') checked @endif> Perempuan
                </label>
              </div>
            </div>
          </div>
          <div class="form-group" style="margin-top: 15px">
            <label for="kelas" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
	            <div id="notif" style="display: none;"></div>
              <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading">
              <div id="wrap-btn">
	              <button type="button" class="btn btn-success" id="simpan">Simpan</button>
                <button type="button" class="btn btn-danger" onclick="self.history.back()">Kembali</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function (){
	$("#simpan").click(function() {
    $("#wrap-btn").hide();
    $("#loading").show();
    var dataString = $("#form-siswa").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/update-siswa') }}",
      data: dataString,
      success: function(data){
        $("#loading").hide();
        $("#wrap-btn").show();
        if (data == 'ok') {
          $("#notif").removeClass('alert alert-danger').addClass('alert alert-info').html("Data siswa berhasil diupdate.").show();
        }else{
          $("#notif").removeClass('alert alert-info').addClass('alert alert-danger').html(data).show();
        }
      }
    })
  });
});
</script>
@endpush