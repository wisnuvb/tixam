<?php use Carbon\Carbon; ?>
@extends('layouts.app')
@section('title', 'TiXam - Aplikasi Ujian Berbasis Komputer')
@section('breadcrumb')
  <h1>Dashboard</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Selamat datang</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-3 col-sm-4 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-aqua"><i class="ion ion-person-stalker"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Jumlah Siswa</span>
      <span class="info-box-number">{{ number_format($siswas) }} <small>siswa</small></span>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-4 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="ion ion-person-stalker"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Jumlah Guru</span>
      <span class="info-box-number">{{ number_format($gurus) }} <small>guru</small></span>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-4 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="ion ion-ios-list-outline"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Jumlah Paket Soal</span>
      <span class="info-box-number">{{ number_format($pakets) }} <small>paket</small></span>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-4 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-red"><i class="ion ion-pie-graph"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Jumlah Materi</span>
      <span class="info-box-number">{{ number_format($materis) }} <small>materi</small></span>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="col-md-8">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Paket soal</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <table class="table table-hover table-striped" id="table_soal">
        @if (Auth::user()->status == 'G')
          <caption>Data paket soal yang Anda buat</caption>
        @else
          <caption>Data paket soal</caption>
        @endif
        <thead>
          <tr>
            <th>Nama Paket</th>
            <th>Deskripsi</th>
            <th>Jenis</th>
            <th style="text-align: center;">KKM</th>
            <th style="text-align: center; width: 70px">Waktu</th>
            <th style="text-align: center; width: 110px">Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Aktifitas Terkini</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <ul class="products-list product-list-in-box">
        @if($aktifitas->count())
        @foreach($aktifitas as $data_aktifitas)
        <li class="item">
          <div class="product-img">
            @if($data_aktifitas->dataAktifitasUser->gambar != "")
            <img src="{{ url('/assets/img/user/'.$data_aktifitas->dataAktifitasUser->gambar) }}" alt="user img">
            @else
            <img src="{{ url('/assets/img/noimage.jpg') }}" alt="user img">
            @endif
          </div>
          <div class="product-info">
            <a href="javascript:void(0)" class="product-title">{{ $data_aktifitas->dataAktifitasUser->nama }}
              <span class="label label-warning pull-right">{{ $data_aktifitas->created_at->diffForHumans() }}</span>
            </a>
            <span class="product-description">
              {{ $data_aktifitas->nama }}
            </span>
          </div>
        </li>
        @endforeach
        @endif
      </ul>
      <a href="{{ url('/activity') }}" class="btn btn-info btn-sm btn-block">Selengkapnya</a>
    </div>
  </div>
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title" style="color: coral"><i class="fa fa-info-circle"></i> Informasi</h3>
    </div>
    <div class="box-body">
      <p>Terimakasih telah menggunakan aplikasi ujian (<b>TiXam</b>) dari <a href="http://tipa.co.id" target="_blank">Tipamedia</a> ini. Terimakasih kepada almsaeedstudio yang telah mendesign tampilan yang mengesankan dan <i>free</i> ini, dan juga mr.Taylor otwell yang membuat kerangka kerja (<i>framework</i>) super keren, sehingga aplikasi ini bisa kami buat dengan lebih cepat. Serta tim penggerak <i>opensource</i> yang tidak bisa kami sebutkan satu-persatu.</p>
      <button class="btn btn-info btn-md" id="btn-wrap-info">Selengkapnya</button>
      <div id="wrap-info" style="display: none;">
        <p>Apabila terdapat pertanyaan seputar produk bisa di diskusikan di grup <a href="" target="_blank">FB</a> dan <a href="" target="_blank">Telegram</a>. Jika ingin bantuan secara lebih spesifik (pelatihan, penambahan fitur diluar yang ada) silahkan sampaikan melalui email wisnuvb@gmail.com.</p><p>Aplikasi ini dapat digunakan secara gratis dibawah lisensi dari Tipamedia. <b style="color: red">Dilarang keras memperjual belikan</b> aplikasi ini tanpa seizin dari Tipamedia.</p><p>Kami juga membuka donasi untuk mendukung pengembangan aplikasi ini melalui rek:<br>BRI KCP Loakulu<b> 728701009542531</b> an. April Liliana atau BNI Cabang Jakarta Pusat <b>0549645605</b> an. Wisnu Pramono Etwin Saputro.</p><p>Silahkan sms ke nomor: 0823 2033 7777 jika telah melakukan donasi, silahkan sebutkan Nama dan bank pengirim. Terimakasih</p>
      </div>
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
      url: '{!! route('elearning.get-soal-home') !!}',
      
    },
    columns: [
      {data: 'paket', name: 'paket', orderable: true, searchable: true },
      {data: 'deskripsi', name: 'deskripsi', orderable: true, searchable: true },
      {data: 'jenis', name: 'jenis', orderable: true, searchable: true },
      {data: 'kkm', name: 'kkm', orderable: true, searchable: true },
      {data: 'waktu', name: 'waktu', orderable: true, searchable: true },
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