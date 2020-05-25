@extends('layouts.app')
@section('title', 'TiXam - Aplikasi Ujian Berbasis Komputer')
@section('breadcrumb')
<h1>Dashboard</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
  <li><a href="{{ url('/elearning/soal') }}">Soal</a></li>
  <li><a href="{{ url('/elearning/soal/detail/'.$essay->id) }}">Detail Soal</a></li>
  <li class="active">Edit soal essay</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Edit Soal Essay</h3>
    </div>
    <form class="form-horizontal" action="{{ url('elearning/soal/essay/'.$essay->id) }}" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" name="soal_id" value="{{ $essay->id_soal }}">
      <div class="box-body">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Soal</label>
            <div class="col-sm-10">
              <textarea class="form-control textarea" name="soal" placeholder="Soal">{{ $essay->soal }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10">
              <div class="radio">
                <label><input type="radio" name="status" id="y" value="Y" {{ $essay->status == 'Y' ? 'checked' : '' }}> Tampil</label> &nbsp;&nbsp;&nbsp;
                <label><input type="radio" name="status" id="n" value="N" {{ $essay->status == 'N' ? 'checked' : '' }}> Tidak tampil</label>
              </div>
            </div>
          </div>
          <div class="form-group" style="margin-top: 20px">
            <div class="col-sm-offset-2 col-sm-10">
              <input class="btn btn-danger" id="batal-simpan-essay" type="button" value="Batal" />
              <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/summernote/summernote.css')}}">
@endpush

@push('scripts')
<script src="{{URL::asset('assets/plugins/summernote/summernote.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $('.textarea').summernote({
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'hr']],
        ['view', ['fullscreen', 'codeview']]
      ],
      height: 100,
      fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150']
    });
  })
</script>
@endpush