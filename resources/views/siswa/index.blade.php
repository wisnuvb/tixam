@extends('layouts.app')
@section('title', 'Data siswa')
@section('breadcrumb')
  <h1>Master Data</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Siswa</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Siswa</h3>
    </div>
    <div class="box-body">
	    <table id="tabel_guru" class="table table-hover table-condensed">
	    	<thead>
	    		<tr>
	    			<th>Nama</th>
	    			<th>NIS</th>
            <th>NISN</th>
	    			<th>Jenis kelamin</th>
            <th>Kelas</th>
	    			<th style="width: 130px; text-align: center;">Aksi</th>
	    		</tr>
	    	</thead>
	    </table>
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
    ajax:'{!! route('master.data_siswa') !!}',
    columns: [
      {data: 'nama', name: 'nama', orderable: true, searchable: true },
      {data: 'no_induk', name: 'no_induk', orderable: true, searchable: true },
      {data: 'nisn', name: 'nisn', orderable: true, searchable: true },
      {data: 'jk', name: 'jk', orderable: false, searchable: false },
      {data: 'kelas', name: 'kelas', orderable: false, searchable: false },
      {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    "drawCallback": function (setting) {}
  });
});
</script>
@endpush