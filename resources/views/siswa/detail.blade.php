@extends('layouts.app')
@section('title', $siswa->nama)
@section('breadcrumb')
  <h1>Detail Siswa</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/master/siswa') }}">Siswa</a></li>
    <li class="active">Detail</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-4">
  <div class="box box-primary">
    <div class="box-body box-profile">
      @if($siswa->gambar != '')
        <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/user/'.$siswa->gambar) }}" alt="User profile picture" style="width: 75%">
      @else
        <img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/siswa.png') }}" alt="User profile picture">
      @endif
      <p class="text-muted text-center">
        @if($siswa->status == 'G')
          Guru
        @elseif($siswa->status == 'A')
          Admin
        @endif
      </p>

      <table class="table table-condensed table-hover">
        <tr>
          <td width="75px">Nama</td>
          <td width="10px">:</td>
          <td>{{ $siswa->nama }}</td>
        </tr>
        <tr>
          <td>NIS</td>
          <td>:</td>
          <td>{{ $siswa->no_induk }}</td>
        </tr>
        <tr>
          <td>NISN</td>
          <td>:</td>
          <td>{{ $siswa->nisn }}</td>
        </tr>
        <tr>
          <td>Kelas</td>
          <td>:</td>
          <td>{{ $siswa->getKelas->nama }}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>:</td>
          <td>{{ $siswa->email }}</td>
        </tr>
        <tr>
          <td>Jenis kel</td>
          <td>:</td>
          <td>
            @if($siswa->jk == 'L')
              Laki-laki
            @else
              Perempuan
            @endif
          </td>
        </tr>
      </table>
      <hr>
      <a href="{{ url('/master/siswa/edit/'.$siswa->id) }}" class="btn btn-primary btn-block"><b><i class="fa fa-edit"></i> Ubah</b></a>
    </div>
    <!-- /.box-body -->
  </div>
</div>
<div class="col-md-8">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Ujian & Latihan</h3>
    </div>
    <div class="box-body">
      <table class="table table-hover table-condensed">
        <caption><i>Daftar ujian & latihan <b>{{ $siswa->nama }}</b>.</i></caption>
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Paket Soal</th>
            <th style="width: 70px; text-align: center;">Nilai</th>
            <th style="width: 100px; text-align: center;">Tanggal</th>
            <th style="width: 160px; text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>

          @if($hasil_ujians->count())
            <?php $no = $hasil_ujians->firstItem(); ?>
            @foreach($hasil_ujians as $hasil_ujian)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $hasil_ujian->paket }}</td>
              <td style="text-align: center;">{{ $hasil_ujian->jumlah_nilai }}</td>
              <td style="text-align: center;">
              <?php
                $exp_date = explode(" ", $hasil_ujian->created_at);
                $exp_date = explode("-", $exp_date[0]);
                echo $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
              ?>
              </td>
              <td style="text-align: center;">
                <a href="{{ url('/elearning/laporan/'.$hasil_ujian->id_soal.'/'.$hasil_ujian->id_user) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Lihat rincian soal dan jawaban siswa.">Detail</a>
                <button type="button" id="btn-reset" data-id="{{ $hasil_ujian->id }}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Reset supaya siswa dapat melakukan ujian ulang dengan soal yang sama.">Reset</button>
              </td>
            </tr>
            @endforeach
          @else
            <tr><td colspan="5" class="alert alert-danger">Belum ada soal Anda yang dikerjakan.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
@push('scripts')
  <script type="text/javascript" src="{{ url('node_modules/moment/moment.js') }}"></script>
  <script>
    $(document).ready(function() {
      $('#btn-reset').on('click', function() {
        var id_ujian = $(this).attr('data-id');
        var $this = $(this);
        swal({
          title: 'Yakin akan direset?',
          text: "Data yang telah direset tidak bisa dikembalikan.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, reset!'
        }).then(function () {
          $.ajax({
            type: 'POST',
            url: "{{ url('crud/reset-ujian') }}",
            data: {id_ujian:id_ujian},
            success: function(data) {
              console.log(data);
              swal(
                'Berhasil!',
                'Data ujian berhasil direset.',
                'success'
              )
            }
          })
        })
      });
    });
  </script>
@endpush