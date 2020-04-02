@extends('layouts.app')
@section('title', 'Upload siswa')
@section('breadcrumb')
<h1>Upload Soal</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
	<li class="active">Soal</li>
</ol>
@endsection
@section('content')
<div class="col-md-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Upload siswa</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<p>Data berhasil di import!</p>
			<p><a href="{{ url('/master/siswa') }}" class="btn btn-primary">Data Siswa</a></p>
		</div>
	</div>
</div>
@endsection