@extends('layouts.app')
@section('title', 'Data guru')
@section('breadcrumb')
  <h1>Detail Profile</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/master/guru') }}">Guru</a></li>
    <li class="active">Detail</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-4">
  <div class="box box-primary">
    <div class="box-body box-profile">
      @if($guru->gambar)
        <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/user/'.$guru->gambar) }}" alt="User profile picture">
      @else
        <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/noimage.jpg') }}" alt="User profile picture">
      @endif
      <p class="text-muted text-center">
        @if($guru->status == 'G')
          Guru
        @elseif($guru->status == 'A')
          Admin
        @endif
      </p>

      <table class="table table-condensed">
        <tr>
          <td width="75px">Nama</td>
          <td width="10px">:</td>
          <td>{{ $guru->nama }}</td>
        </tr>
        <tr>
          <td>NIP</td>
          <td>:</td>
          <td>{{ $guru->no_induk }}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>:</td>
          <td>{{ $guru->email }}</td>
        </tr>
        <tr>
          <td>Jenis kel</td>
          <td>:</td>
          <td>
            @if($guru->jk == 'L')
            Laki-laki
            @else
            Perempuan
            @endif
          </td>
        </tr>
      </table>
      <hr>
      @if($guru->status == 'A' || $guru->id == Auth::user()->id)
        <a href="{{ url('/master/guru/ubah/'.$guru->id) }}" class="btn btn-primary btn-block"><b><i class="fa fa-edit"></i> Ubah</b></a>
      @endif
    </div>
    <!-- /.box-body -->
  </div>
</div>
<div class="col-md-8">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#activity" data-toggle="tab">Aktifitas hari ini</a></li>
    </ul>
    <div class="tab-content">
      <div class="active tab-pane" id="activity">
        @if($grup_aktifitas->count())
        <ul class="timeline timeline-inverse">
          <li class="time-label">
            <span class="bg-red">{{ $tanggal }}
            </span>
          </li>
          @foreach($grup_aktifitas as $aktifitas)
          <?php
            $exp_date = explode(" ", $aktifitas->created_at);
          ?>
          <li>
            <i class="fa fa-check" aria-hidden="true"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> {{ $exp_date[1] }}</span>
              <div class="timeline-body">{{ $aktifitas->nama }}</div>
            </div>
          </li>
          @endforeach
        </ul>
        @else
        <div class="alert alert-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> Belum ada aktifitas hari ini.</div>
        @endif
        {!! $grup_aktifitas->render() !!}
      </div>
    </div>
  </div>
</div>
@endsection