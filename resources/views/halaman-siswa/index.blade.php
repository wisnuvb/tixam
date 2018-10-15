@extends('layouts.app')
@section('title', 'Ti-Xam - '.Auth::user()->nama)
@section('breadcrumb')
  <h1>Home</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Hi, {{ Auth::user()->nama }}</li>
  </ol>
@endsection
@section('content')
	<div class="col-sm-12">
		<div class="alert alert-info"><i class="fa fa-info-circle"></i> Hai <b>{{ Auth::user()->nama }}</b>, yuk gabung dengan komunitas pelajar sesama pengguna aplikasi Ti-Xam. Berlajar dan bertemu teman baru dari seluruh penjuru Tanah Air. Kamu bisa kunjungi laman <a href="http://ayosinau.com/siswa">ayosinau.com</a> diluar jam sekolah ya.</div>
	</div>
	<div class="col-md-8">
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title">Materi terbaru</h3>
	      <div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      </div>
	    </div>
	    <div class="box-body">
	    	<table class="table table-hover table-striped" id="table_soal">
	    	<caption>Data materi yang bisa dipelajari</caption>
        <thead>
          <tr>
            <th>Judul materi</th>
            <th style="text-align: center; width: 110px">Aksi</th>
          </tr>
        </thead>
      </table>
	    </div>
    </div>
  </div>
  <div class="col-md-4">
  	<div class="box box-warning">
	    <div class="box-header with-border">
	      <h3 class="box-title" style="color: coral"><i class="fa fa-info-circle"></i> Informasi</h3>
	    </div>
	    <div class="box-body">
	      <p>Hai <b>{{ Auth::user()->nama }}</b>, selamat datang di Ti-Xam. Sekolah kamu telah menggadopsi teknologi teknologi untuk proses kegiatan belajar mengajar. Ini hal yang sangat bagus.</p>
	      <p>Ayo bergabung dengan ribuan teman kamu dari seluruh sekolah pengguna <a href="http://ayosinau.com/siswa" target="_blank">Ti-Xam</a> untuk berbagi pengalaman dan cerita. Belajar dan bertemu teman baru pasti seru.</p>
	      <p>Kamu bisa akses halaman <a href="http://ayosinau.com/siswa" target="_blank">Ti-Xam</a> diluar jam sekolah ya, dan temukan keseruan belajar sambil berinteraksi dengan teman baru.</p>
	    </div>
	  </div>
  </div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush
@push('scripts')
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script>
$(document).ready(function (){
  table_soal = $('#table_soal').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    ajax: {
      url: '{!! route('siswa.materi') !!}',
      
    },
    columns: [
      {data: 'judul', name: 'judul', orderable: true, searchable: true },
      {data: 'action', name: 'action', orderable: false, searchable: false, },
    ],
    "drawCallback": function (setting) {}
  });
  $("#btn-wrap-info").click(function() {
    $(this).hide();
    $("#wrap-info").show();
  });
});
</script>
@endpush