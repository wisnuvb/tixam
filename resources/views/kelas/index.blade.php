@extends('layouts.app')
@section('title', 'Data kelas')
@section('breadcrumb')
  <h1>Master Data</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Kelas</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-8">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Kelas</h3>
    </div>
    <div class="box-body">
	    <table id="tabel_guru" class="table table-hover table-condensed">
	    	<thead>
	    		<tr>
	    			<th>Nama kelas</th>
	    			<th style="width: 130px; text-align: center;">Aksi</th>
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
      <p>Daftarkan seluruh kelas malalui halaman ini. Data kelas diperlukan untuk mengelompokan siswa dan untuk mendistribusian paket soal.</p>
      <p>Jika terdapat data kelas yang belum valid atau kelas yang belum terdaftar, hubungi operator sekolah untuk merubah atau mendaftarkan kelas tersebut.</p>
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
	tabel_guru = $('#tabel_guru').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    ajax:'{!! route('master.data_kelas') !!}',
    columns: [
      {data: 'nama', name: 'nama', orderable: true, searchable: true },
      {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    "drawCallback": function (setting) {}
  });
});
</script>
@endpush