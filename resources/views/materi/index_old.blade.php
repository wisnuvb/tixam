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
<?php $sesi = md5(rand(0000000000, mt_getrandmax())); ?>
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-8">
  <div class="box box-primary">
  	<div class="box-header with-border">
      <h3 class="box-title">Daftar materi Anda</h3>
    </div>
    <div class="box-body">
      <button type="button" id="btn-materi" class="btn btn-primary btn-md"><i class="fa fa-pencil-square-o"></i> &nbsp;Tulis Materi</button>
      <div class="well" style="margin-top: 15px; display: none;" id="wrap-materi">
        <form class="form-horizontal" id="formMateri">
          <div class="box-body">
            <div class="form-group">
              <label for="judul" class="col-sm-2 control-label">Judul</label>
              <div class="col-sm-10">
                <input type="hidden" name="id" value="N">
                <input type="hidden" name="sesi" value="{{ $sesi }}">
                <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul">
              </div>
            </div>
            <div class="form-group">
              <label for="isi" class="col-sm-2 control-label">Isi</label>
              <div class="col-sm-10">
                <textarea class="textarea" placeholder="Isi materi" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="isi" name="isi" placeholder="Isi"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="isi" class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <div class="radio">
                  <label>
                    <input type="radio" name="status" id="Y" value="Y"> Tampil
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <label>
                    <input type="radio" name="status" id="Y" value="N"> Tidak tampil
                  </label>
                </div>
              </div>
            </div>
            <div class="overlay" id="loading" style="display: none;"><i class="fa fa-refresh fa-spin"></i></div>
          </div>
        </form>
        <div class="form-horizontal">
          <div class="box-body">
            <div class="form-group">
              <label for="judul" class="col-sm-2 control-label">Gambar</label>
              <div class="col-sm-10">
                <form action="{{ url('/crud/simpan-gambar-materi') }}" class="dropzone">
                  {{ csrf_field() }}
                  <input type="hidden" name="sesi_gambar" value="{{ $sesi }}">
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                </form>
              </div>
            </div>
            <div class="form-group">
              <label for="judul" class="col-sm-2 control-label">&nbsp;</label>
              <div class="col-sm-10">
                <div id="wrap-btn">
                  <button type="button" id="simpan" class="btn btn-primary btn-md">Simpan</button>
                  <button type="button" class="btn btn-danger btn-md" id="batal">Batal</button>
                </div>
                <div id="notif" style="display: none; margin-top: 15px"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr style="margin: 10px 0 15px 0">
      <table class="table table-condensed table-hover" id="table_materi">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Status</th>
            <th>Dibaca</th>
            <th style="text-align: center;">Aksi</th>
          </tr>
        </thead>
      </table>
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
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<link rel="stylesheet" href="{{ url('/assets/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" href="{{ url('/assets/plugins/dropzone/dropzone.css') }}">
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
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script src="{{ url('/assets/plugins/summernote/summernote.min.js') }}"></script>
<script src="{{ url('/assets/plugins/dropzone/dropzone.js') }}"></script>
<script>
$(document).ready(function (){
  table_materi = $('#table_materi').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    ajax: {
      url: '{!! route('elearning.dataMateriGuru') !!}',
      
    },
    columns: [
      {data: 'judul', name: 'judul', orderable: true, searchable: true },
      {data: 'status', name: 'status', orderable: true, searchable: true },
      {data: 'hits', name: 'hits', orderable: true, searchable: true },
      {data: 'action', name: 'action', orderable: false, searchable: false, },
    ],
    "drawCallback": function (setting) {}
  });
  $(".textarea").summernote({ height: 150 });
  $("#btn-materi").click(function() {
    $("#wrap-materi").slideToggle();
  });
  $("#batal").click(function() {
    $("#wrap-materi").slideToggle();
  });
  $("#simpan").click(function(e) {
    $("#loading").show();
    var dataString = $("#formMateri").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-materi') }}",
      data: dataString,
      success: function(data){
        console.log(data);
        if (data == 'ok') {
          $("#loading").hide();
          $("#wrap-btn").show();
          $("#notif").removeClass('alert alert-danger').addClass('alert alert-info').html("<i class='fa fa-info-circle'></i> Data berhasil disimpan.").fadeIn(350);
          window.location = "{{ url('/elearning/materi') }}";
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