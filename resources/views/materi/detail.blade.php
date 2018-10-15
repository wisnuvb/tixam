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
    <a href="{{ url('/elearning/materi/ubah/'.$materi->id) }}" class="btn btn-primary btn-md">Ubah</a>
    <button id="hapus-materi" class="btn btn-danger btn-md">Hapus</button>
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
          <td>{{ $materi->hits }} <small>kali</small></td>
        </tr>
      </table>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  $(document).ready(function() {
    $("#hapus-materi").click(function() {
      swal({
        title: "Yakin data akan dihapus?",
        text: "Data yang telah dihapus tidak bisa dikembalikan.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false,
      },
      function(){
        swal("Deleted!", "Data berhasil dihapus.", "success");
      });
    });
  });
</script>
@endpush