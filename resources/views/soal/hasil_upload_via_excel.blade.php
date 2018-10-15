@extends('layouts.app')
@section('title', 'Upload soal')
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
      <h3 class="box-title">Upload soal</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
			<table class="table table-responsive table-striped">
				<tr>
					<td style="width: 150px">Jumlah soal</td>
					<td style="width: 15px">:</td>
					<td>{{ number_format($jumlah,0,'.','.') }}</td>
				</tr>
				<tr>
					<td>Berhasil upload</td>
					<td>:</td>
					<td>{{ number_format($sukses,0,'.','.') }}</td>
				</tr>
				<tr>
					<td>Gagal upload</td>
					<td>:</td>
					<td>{{ number_format($gagal,0,'.','.') }}</td>
				</tr>
			</table>
			<p>{!! $kesalahan !!}</p>
    </div>
  </div>
</div>
@endsection