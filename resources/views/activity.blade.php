@extends('layouts.app')
@section('title', 'Aktifitas')
@section('breadcrumb')
  <h1>Aktifitas</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Aktifitas</li>
  </ol>
@endsection
@section('content')
<div class="col-md-8">
  <div class="box box-default">
    <div class="box-body">
    	<div class="active tab-pane" id="activity">
        @if($aktifitas->count())
        @foreach($aktifitas as $data_aktifitas)
        <div class="post">
          <div class="user-block">
            @if($data_aktifitas->dataAktifitasUser->gambar != "")
            <img class="img-circle img-bordered-sm" src="{{ url('/assets/img/user/'.$data_aktifitas->dataAktifitasUser->gambar) }}" alt="user img">
            @else
            <img class="img-circle img-bordered-sm" src="{{ url('/assets/img/noimage.jpg') }}" alt="user img">
            @endif
            <span class="username">
              <a href="#">{{ $data_aktifitas->dataAktifitasUser->nama }}</a>
            </span>
            <span class="description">{{ $data_aktifitas->created_at->diffForHumans() }}</span>
          </div>
          <p>{{ $data_aktifitas->nama }}</p>
        </div>
        @endforeach
        @endif
      </div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Informasi</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="box-body">
	    <p>Aktifitas terkini yang dilakukan oleh pengguna aplikasi Ti-xam.</p>
    </div>
  </div>
</div>
@endsection