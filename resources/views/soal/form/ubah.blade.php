@extends('layouts.app')
@section('title', 'Ubah soal')
@section('breadcrumb')
  <h1>Ubah Soal</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/elearning/soal') }}">Soal</a></li>
    <li class="active">Ubah Soal</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-8">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Lengkapi form dibawah ini.</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    	<div id="wrap-soal">
    		<form class="form-horizontal" id="form-soal">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Soal</label>
              <div class="col-sm-10">
                <input type="hidden" name="id" value="{{ $soal->id }}">
                <input type="hidden" name="id_soal" value="{{ $soal->id_soal }}">
                <input type="hidden" name="jenis" value="@if($soal->jenis != ''){{ $soal->jenis }}@else 1 @endif">
                <input type="hidden" name="sesi" value="@if($soal->sesi != ''){{ $soal->sesi }}@else{{ md5(rand(0000000000, mt_getrandmax())) }}@endif">
                <textarea class="form-control textarea" name="soal" placeholder="Soal">{{ $soal->soal }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan A</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pila" placeholder="Pilihan A">{{ $soal->pila }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan B</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pilb" placeholder="Pilihan B">{{ $soal->pilb }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan C</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pilc" placeholder="Pilihan C">{{ $soal->pilc }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan D</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pild" placeholder="Pilihan D">{{ $soal->pild }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan E</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pile" placeholder="Pilihan E">{{ $soal->pile }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Kunci</label>
              <div class="col-sm-10">
                <div class="radio">
                  <label><input type="radio" name="kunci" id="a" value="A" @if($soal->kunci == "A") checked @endif> Jawaban <b>A</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" id="b" value="B" @if($soal->kunci == "B") checked @endif> Jawaban <b>B</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" id="c" value="C" @if($soal->kunci == "C") checked @endif> Jawaban <b>C</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" id="d" value="D" @if($soal->kunci == "D") checked @endif> Jawaban <b>D</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" id="e" value="E" @if($soal->kunci == "E") checked @endif> Jawaban <b>E</b></label>
                </div>
              </div>
            </div>
            <div class="form-group" style="margin-top: 15px">
              <label class="col-sm-2 control-label">Score</label>
              <div class="col-sm-2">
                <input type="text" class="form-control numOnly" name="score" placeholder="Score" value="{{ $soal->score }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <div class="radio">
                  <label><input type="radio" name="status" id="y" value="Y" @if($soal->status == "Y") checked @endif> Tampil</label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="status" id="n" value="N" @if($soal->status == "N") checked @endif> Tidak tampil</label>
                </div>
              </div>
            </div>
            <div class="form-group" style="margin-top: 20px">
              <div class="col-sm-offset-2 col-sm-10">
                <div id="notif-soal" style="display: none;"></div>
                <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading-soal">
                <div id="wrap-btn">
                  <button type="button" class="btn btn-danger" onclick="self.history.back()">Kembali</button>
                  <button type="button" class="btn btn-success" id="simpan-soal">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </form>
    	</div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Informasi</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
	    <p>Di halaman ini Anda dapat melakukan revisi terhadap soal yang akan dikerjakan oleh siswa.</p>
	    <p>Silahkan koreksi soal pada form disamping, lalu simpan kembali soal tersebut sebelum Anda keluar dari halaman ini.</p>
    </div>
  </div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/summernote/summernote.css')}}">
<style type="text/css">
	.panel {
		margin-bottom: 5px !important;
	}
	.form-group {
		margin-bottom: 5px;
	}
</style>
@endpush
@push('scripts')
<script src="{{URL::asset('assets/plugins/summernote/summernote.min.js')}}"></script>
<script>
$(document).ready(function (){
	$("#btn-soal").click(function() {
		$("#wrap-soal").slideToggle();
	});
	$("#batal").click(function() {
		$("#wrap-soal").slideToggle();
	});
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
        height:100,
				fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48' , '64', '82', '150']
	});
	$("#simpan-soal").click(function() {
    $("#wrap-btn").hide();
    $("#loading-soal").show();
    var dataString = $("#form-soal").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-detail-soal') }}",
      data: dataString,
      success: function(data){
        $("#loading-soal").hide();
        $("#wrap-btn").show();
        if (data == 'ok') {
          $("#notif-soal").removeClass('alert alert-danger').addClass('alert alert-info').html("Soal berhasil disimpan.").show();
          window.location.href = "{{ url('elearning/soal/detail/data-soal/'.$soal->id) }}";
        }else{
          $("#notif-soal").removeClass('alert alert-info').addClass('alert alert-danger').html(data).show();
        }
      }
    })
  });
});
</script>
@endpush