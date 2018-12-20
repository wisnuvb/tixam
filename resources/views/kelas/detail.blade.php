@extends('layouts.app')
@section('title', 'Data kelas')
@section('breadcrumb')
  <h1>Detail Kelas</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/master/kelas') }}">Kelas</a></li>
    <li class="active">Detail</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-9">
  <div class="box box-primary">
  	<div class="box-header with-border">
      <h3 class="box-title">{{ $kelas->nama }}</h3>
      <div class="pull-right">
        <a href="{{ url('master/kelas/ubah/'.$kelas->id) }}" class="btn btn-success" id="btn-create"><i class="fa fa-edit"></i> Tambah Siswa</a>
        <a href="{{ url('master/kelas/ubah/'.$kelas->id) }}" class="btn btn-primary" id="btn-create"><i class="fa fa-edit"></i> Ubah Kelas</a>
        <button type="button" class="btn btn-danger" id="btn-siswa"><i class="fa fa-trash"></i> Kosongkan Kelas</button>
      </div>
    </div>
    <div class="box-body">
    	<table class="table table-hover table-condensed" id="table_detail_kelas">
    		<caption><i>Daftar siswa di kelas {{ $kelas->nama }}.</i></caption>
    		<thead>
    			<tr>
    				<th>Nama</th>
    				<th>NIS</th>
    				<th>NISN</th>
    				<th>Jenis kelamin</th>
    				<th style="text-align: center">Aksi</th>
    			</tr>
    		</thead>
    	</table>
    </div>
  </div>
</div>
<div class="col-md-3">
  <div class="box box-warning">
  	<div class="box-header with-border">
      <h3 class="box-title" style="color: darkorange"><i class="fa fa-info-circle"></i> Informasi</h3>
    </div>
    <div class="box-body">
	    <table class="table table-striped">
	    	<tr>
	    		<td>Nama</td>
	    		<td>{{ $kelas->nama }}</td>
	    	</tr>
	    	<tr>
	    		<td>Siswa</td>
	    		<td>{{ $jumlah.' siswa' }}</td>
	    	</tr>
	    	<tr>
	    		<td>Wali</td>
	    		<td>{{ $kelas->wali->nama }}</td>
	    	</tr>
	    </table>
    </div>
  </div>
  @if($user->status == 'G')
  <div class="box box-danger">
    <div class="box-body">
	    <p><i class="fa fa-question-circle" style="color: indianred"></i> Apabila terdapat data siswa dalam kelas <b>{{ $kelas->nama }}</b> ini tidak valid atau data nama kelas dan nama wali kelas, silahkan hubungi operator sekolah untuk melakukan perubahan pada data tersebut.</p>
    </div>
  </div>
  @endif
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
	tabel_guru = $('#table_detail_kelas').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    // ajax:'{!! route('master.detail_kelas_siswa') !!}',
    ajax: {
      url: '{!! route('master.detail_kelas_siswa') !!}',
      data: {"id_kelas": '{{$kelas->id}}'},
    },
    columns: [
      {data: 'nama', name: 'nama', orderable: true, searchable: true },
      {data: 'no_induk', name: 'no_induk', orderable: true, searchable: true },
      {data: 'nisn', name: 'nisn', orderable: true, searchable: true },
      {data: 'jk', name: 'jk', orderable: true, searchable: true },
      {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    "drawCallback": function (setting) {}
  });
});
</script>
@endpush