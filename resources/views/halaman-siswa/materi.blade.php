@extends('layouts.app')
@section('title', 'Ti-Xam - '.Auth::user()->nama)
@section('breadcrumb')
  <h1>Materi</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Materi TiXam</li>
  </ol>
@endsection
@section('content')
	<div class="col-md-8">
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title">Materi terbaru</h3>
	      <div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      </div>
	    </div>
	    <div class="box-body">
        <div id="wrap-materi"></div>
        <div class="hidden">
          <table class="table table-hover table-striped" id="table_soal">
          <caption>Data materi yang bisa dipelajari</caption>
          <thead>
            <tr>
              <th>Judul materi</th>
              <th>Dibuat</th>
              <th style="text-align: center; width: 110px">Aksi</th>
            </tr>
          </thead>
        </table>
        </div>
      </div>
      <div class="box-footer" style="margin: 0; padding: 0 10px">
        <p class="text-muted">Materi disiapkan oleh <a href="https://ayosinau.com" target="_blank">Ayosinau.com</a></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
  	<div class="box box-warning">
	    <div class="box-header with-border">
	      <h3 class="box-title" style="color: coral"><i class="fa fa-info-circle"></i> Informasi</h3>
	    </div>
	    <div class="box-body">
	      <p>Silahkan kamu pelajari materi yang tersedia.</p>
        <p>Kamu juga bisa akses langsung ke <a href="https://ayosinau.com" target="_blank">Ayosinau.com</a> untuk mendapatkan informasi lebih lanjut.</p>
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
      function checkconnection() {
        var status = navigator.onLine;
        if (status) {
          // alert("online");
          $('#wrap-materi').html('Untuk sementara materi belum bisa diakses.');
        } else {
          // alert("offline");
          $('#wrap-materi').html(`
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Tidak Terhubung ke Internet</h4>
              Untuk dapat mengakses halaman ini, kamu diminta untuk menghubungkan perangkat dengan internet.
            </div>
          `);
        }
      }

      checkconnection();

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
          {data: 'dibuat', name: 'dibuat', orderable: true, searchable: true },
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