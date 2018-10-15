@extends('layouts.app')
@section('title', 'Materi')
@section('breadcrumb')
  <h1>Materi</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/elearning/materi') }}">Materi</a></li>
    <li class="active">Detail</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="box box-primary">
  	<div class="box-header with-border">
      <h3 class="box-title">Ubah materi</h3>
    </div>
    <div class="box-body">
      <div class="form-horizontal">
        <div class="box-body">
          <div class="form-group">
            <label for="judul" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              @if($materi->gambar != "")
                <img src="{{ url('/assets/img/materi/'.$materi->gambar) }}" id="img_materi" class="img img-thumbnail" alt="img" style="width: 350px">
              @else
                <img src="{{ url('/assets/img/noimage.jpg') }}" id="img_materi" class="img img-thumbnail" alt="img" style="width: 350px">
              @endif
              <p>
                <input type="hidden" id="id" value="{{ $materi->id }}">
                <button type="button" class="btn btn-primary btn-sm" id="btn-ubah-gambar">Ubah gambar</button>
                <button type="button" class="btn btn-danger btn-sm hapus-gambar-materi">Hapus gambar</button>
              </p>
            </div>
          </div>
          <div class="form-group" id="wrap-gambar" style="display: none;">
            <label for="judul" class="col-sm-2 control-label">Gambar</label>
            <div class="col-sm-5">
              <form action="{{ url('/crud/simpan-gambar-materi') }}" class="dropzone">
                {{ csrf_field() }}
                <input type="hidden" name="sesi_gambar" value="{{ $materi->sesi }}">
                <div class="fallback">
                  <input name="file" type="file" multiple />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <form class="form-horizontal" id="formMateri">
        <div class="box-body">
          <div class="form-group">
            <label for="judul" class="col-sm-2 control-label">Judul</label>
            <div class="col-sm-10">
              <input type="hidden" name="sesi" value="{{ $materi->sesi }}">
              <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" value="{{ $materi->judul }}">
            </div>
          </div>
          <div class="form-group">
            <label for="isi" class="col-sm-2 control-label">Isi</label>
            <div class="col-sm-10">
              <textarea class="textarea" placeholder="Isi materi" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="isi" name="isi" placeholder="Isi">{!! $materi->isi !!}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="isi" class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10">
              <div class="radio">
                <label>
                  <input type="radio" name="status" id="Y" value="Y" <?php if($materi->status == 'Y'){echo "checked";} ?>> Tampil
                </label>&nbsp;&nbsp;&nbsp;&nbsp;
                <label>
                  <input type="radio" name="status" id="Y" value="N" <?php if($materi->status == 'N'){echo "checked";} ?>> Tidak tampil
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="judul" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
              <div id="wrap-btn">
                <button type="button" id="simpan" class="btn btn-primary btn-md">Simpan</button>
                <button type="button" class="btn btn-danger btn-md" onclick="self.history.back();">Batal</button>
              </div>
              <div id="notif" style="display: none; margin-top: 15px""></div>
            </div>
          </div>
          <div class="overlay" id="loading" style="display: none;"><i class="fa fa-refresh fa-spin"></i></div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('css')
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
<script src="{{ url('/assets/plugins/summernote/summernote.min.js') }}"></script>
<script src="{{ url('/assets/plugins/dropzone/dropzone.js') }}"></script>
<script>
$(document).ready(function() {
  $(".textarea").summernote({ height: 150 });

  $("#simpan").click(function(e) {
    // $("#wrap-btn").hide();
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
          window.location = "{{ url('/elearning/materi/detail/'.$materi->id) }}";
        }else{
          $("#loading").hide();
          $("#wrap-btn").show();
          $("#notif").removeClass('alert alert-info').addClass('alert alert-danger').html(data).fadeIn(350);
        }
      }
    })
  });
  $("#btn-ubah-gambar").click(function() {
    $("#wrap-gambar").slideToggle();
  });
  $(".hapus-gambar-materi").click(function() {
    var id = $("#id").val();
    swal({
      title: "Yakin data gambar akan dihapus?",
      text: "Data yang telah dihapus tidak bisa dikembalikan.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false,
    },
    function(){
      $.ajax({
        type: "POST",
        url: "{{ url('/crud/hapus-gambar-materi') }}",
        data: {id:id},
        success: function(data){
          $("#img_materi").hide();
          swal("Deleted!", "Data gambar berhasil dihapus.", "success");
        }
      })
    });
  });
});
</script>
@endpush