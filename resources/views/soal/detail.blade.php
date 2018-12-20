@extends('layouts.app')
@section('title', 'Detail soal')
@section('breadcrumb')
  <h1><i class="fa fa-book"></i> Data Soal</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/elearning/soal') }}">Soal</a></li>
    <li class="active">Detail soal</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-md-4">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Informasi</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <a href="{{ url('/elearning/soal/ubah/'.$id_soal) }}" class="btn btn-primary btn-md">Ubah Data</a>
        <hr style="margin: 10px 0">
      	<table class="table table-condensed">
      		<tbody>
      			<tr>
      				<td width="100px">Nama Paket</td>
      				<td width="15px">:</td>
      				<td>{{ $soal->paket }}</td>
      			</tr>
      			<tr style="font-weight: 600; color: #e61111;">
              <td>ID Paket</td>
              <td>:</td>
              <td>{{ $soal->id }}</td>
            </tr>
            <tr>
      				<td>Deskripsi</td>
      				<td>:</td>
      				<td>{{ $soal->deskripsi }}</td>
      			</tr>
      			<tr>
      				<td>Jenis Soal</td>
      				<td>:</td>
      				<td>{{ jenisSoal($soal->jenis) }}</td>
      			</tr>
      			<tr>
      				<td>KKM</td>
      				<td>:</td>
      				<td>{{ $soal->kkm }}</td>
      			</tr>
      			<tr>
      				<td>Waktu</td>
      				<td>:</td>
      				<td>{{ $soal->waktu.' menit' }}</td>
      			</tr>
      			<tr>
      				<td>Dibuat oleh</td>
      				<td>:</td>
      				<td>{{ $soal->user->nama }}</td>
      			</tr>
      		</tbody>
      	</table>
    	</div>
  	</div>
    @if($soal->jenis == 1)
    	<div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Data Kelas</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
        	<table class="table table-condensed table-bordered table-hover">
        		<thead>
        			<tr>
    	    			<th>Kelas</th>
    	    			<th width="50">Status</th>
    	    		</tr>
        		</thead>
        		<tbody>
        			<input type="hidden" id="id_soal" value="{{ $id_soal }}">
        			@if($kelas->count())
        			@foreach($kelas as $data_kelas)
        			<input type="hidden" id="id{{ $data_kelas->id }}" value="{{ $data_kelas->id }}">
        			<tr>
    	    			<td>{{ $data_kelas->nama }}</td>
    	    			<td align="center">
    	    				<div id="wrap-status-soal{{ $data_kelas->id }}">
    	    					@if($data_kelas->id_soal != "")
    		    					@if($data_kelas->id_soal == Request::segment(4))
    		    						<span data-toggle="tooltip" title="Kelas ini dapat mengerjakan soal Anda. Klik untuk merubah status soal pada kelas ini." id="terbit-soal{{ $data_kelas->id }}"><i style="color: limegreen; font-size: 16pt; cursor: pointer;" class="fa fa-check-square-o"></i></span>
    		    					@else
    		    						<span data-toggle="tooltip" title="Kelas ini tidak dapat mengerjakan soal Anda. Klik untuk merubah status soal pada kelas ini." id="terbit-soal{{ $data_kelas->id }}"><i style="color: red; font-size: 16pt; cursor: pointer;" class="fa fa-minus-square-o"></i></span>
    		    					@endif
    		    				@else
    		    					<span data-toggle="tooltip" title="Kelas ini tidak dapat mengerjakan soal Anda. Klik untuk merubah status soal pada kelas ini." id="terbit-soal{{ $data_kelas->id }}"><i style="color: red; font-size: 16pt; cursor: pointer;" class="fa fa-minus-square-o"></i></span>
    		    				@endif
    	    				</div>
    	    			</td>
    	    		</tr>
    	    		@push('scripts')
    	    		<script>
    					$(document).ready(function (){
    						$("#terbit-soal{{ $data_kelas->id }}").click(function() {
    							var id_kelas = $("#id{{ $data_kelas->id }}").val();
    							var id_soal = $("#id_soal").val();
    							$.ajax({
    								type: "POST",
    								url: "{{ url('/crud/terbit-soal') }}",
    								data: { id_kelas:id_kelas, id_soal:id_soal },
    								success: function(data) {
    									if (data == 'Y') {
    										$("#terbit-soal{{ $data_kelas->id }}").html('<i style="color: limegreen; font-size: 16pt; cursor: pointer;" class="fa fa-check-square-o"></i>');
    									}else{
    										$("#terbit-soal{{ $data_kelas->id }}").html('<i style="color: red; font-size: 16pt; cursor: pointer;" class="fa fa-minus-square-o"></i>');
    									}
    								}
    							});
    						});
    					});
    					</script>
    	    		@endpush
    	    		@endforeach
    	    		@endif
        		</tbody>
        	</table>
        	<p style="margin-top: 20px" class="text-muted"><i class="fa fa-info-circle"></i> <b>Data kelas</b> adalah daftar kelas yang akan menerima soal ini. Anda dapat menerbitkan soal ke kelas yang akan mengerjakan soal. Hanya soal dengan jenis <b>Ujian</b> yang bisa tampilkan di sini.</p>
      	</div>
    	</div>
    @else
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Data Kelas</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <p>Seluruh siswa (kelas manapun) dapat mengakses soal yang Anda terbitkan. Soal dalam format latihan bisa dikerjakan berkali-kali oleh siswa yang mengkses soal Anda.</p>
          <p>Susunlan soal untuk memantapkan pemahaman siswa akan materi terkait. Anda dapat memantau siswa yang mengakses soal latihan yang Anda buat melalui halaman <b>Laporan.</b></p>
        </div>
      </div>
    @endif
  </div>
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Detail Soal</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <button type="button" id="btn-soal" class="btn btn-primary btn-md">Tulis Soal</button>
      	<button type="button" id="btn-upload-soal" class="btn btn-success btn-md">Import via Excel</button>
        <a class="pull-right" href="{{ url('/download-file-format/soal') }}">Download format Excel</a>
      	<div style="display: none;" id="wrap-soal">
      		<form class="form-horizontal" id="form-soal">
            <div class="box-body">
              <div class="form-group">
                <label class="col-sm-2 control-label">Soal</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="N">
                  <!-- <input type="hidden" name="id_soal" value="N"> -->
                  <input type="hidden" name="jenis" value="1">
                  <input type="hidden" name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                  <textarea class="form-control textarea" name="soal" placeholder="Soal"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Pilihan A</label>
                <div class="col-sm-10">
                  <textarea class="form-control textarea" name="pila" placeholder="Pilihan A"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Pilihan B</label>
                <div class="col-sm-10">
                  <textarea class="form-control textarea" name="pilb" placeholder="Pilihan B"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Pilihan C</label>
                <div class="col-sm-10">
                  <textarea class="form-control textarea" name="pilc" placeholder="Pilihan C"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Pilihan D</label>
                <div class="col-sm-10">
                  <textarea class="form-control textarea" name="pild" placeholder="Pilihan D"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Pilihan E</label>
                <div class="col-sm-10">
                  <textarea class="form-control textarea" name="pile" placeholder="Pilihan E"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Kunci</label>
                <div class="col-sm-10">
                  <div class="radio">
                    <label><input type="radio" name="kunci" id="a" value="A"> Jawaban <b>A</b></label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="kunci" id="b" value="B"> Jawaban <b>B</b></label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="kunci" id="c" value="C"> Jawaban <b>C</b></label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="kunci" id="d" value="D"> Jawaban <b>D</b></label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="kunci" id="e" value="E"> Jawaban <b>E</b></label>
                  </div>
                </div>
              </div>
              <div class="form-group" style="margin-top: 15px">
                <label class="col-sm-2 control-label">Score</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control numOnly" name="score" placeholder="Score">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10">
                  <div class="radio">
                    <label><input type="radio" name="status" id="y" value="Y"> Tampil</label> &nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="status" id="n" value="N"> Tidak tampil</label>
                  </div>
                </div>
              </div>
              <div class="form-group" style="margin-top: 20px">
                <div class="col-sm-offset-2 col-sm-10">
                  <div id="notif-soal" style="display: none;"></div>
                  <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading-soal">
                  <div id="wrap-btn">
                    <button type="button" class="btn btn-danger" id="batal">Batal</button>
                    <button type="button" class="btn btn-success" id="simpan-soal">Simpan</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
      	</div>
        <div class="well" style="margin-top: 15px; display: none;" id="wrap-upload-soal">
          <form class="form-horizontal" action="{{ url('/crud/simpan-detail-soal-via-excel') }}" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="form-group">
                <input type="file" name="file" id="file" class="inputfile" />
                <label for="file"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Pilih file excel</label>
                <p class="help-block">Silahkan pilih file format soal dalam bentuk excel yang telah diisi dengan benar.</p>
              </div>
              <div class="box-footer">
                <input class="btn btn-danger" id="batal-upload" type="button" value="Batal" />
                <input class="btn btn-primary" name="upload" type="submit" value="Import" />
              </div>
            </div>
          </form>
        </div>
      	<hr style="margin: 10px 0">
        <table class="table table-hover table-striped" id="table_detail_soal">
          <thead>
            <tr>
              <th>Soal</th>
              <th>Pilihan A</th>
              <th>Pilihan B</th>
              <th>Pilihan C</th>
              <th>Pilihan D</th>
              <th>Pilihan E</th>
              <th style="text-align: center;">Kunci</th>
              <th style="text-align: center;">Score</th>
              <th style="text-align: center;">Status</th>
              <th style="text-align: center; width: 100px">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
@endsection
@push('css')
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/summernote/summernote.css')}}">
  <style type="text/css">
  	.panel {
  		margin-bottom: 5px !important;
  	}
  	.form-group {
  		margin-bottom: 5px;
  	}
    .label-success {
      background-color: #ffffff !important;
      border: solid thin #00a65a;
      color: #018833 !important;
    }
    .label-danger {
      background-color: #ffffff !important;
      border: solid thin #a70909;
      color: #da1616 !important;
    }
    .inputfile {
      width: 0.1px;
      height: 0.1px;
      opacity: 0;
      overflow: hidden;
      position: absolute;
      z-index: -1;
    }
    .inputfile + label {
      font-size: 1.25em;
      font-weight: 700;
      color: white;
      background-color: green;
      display: inline-block;
      padding: 10px;
    }
    .inputfile:focus + label,.inputfile + label:hover {
      background-color: darkgreen;
    }
    .inputfile + label {
      cursor: pointer;
    }
    .inputfile:focus + label {
      outline: 1px dotted #000;
      outline: -webkit-focus-ring-color auto 5px;
    }
    .inputfile + label * {
      pointer-events: none;
    }
  </style>
@endpush
@push('scripts')
  <script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/summernote/summernote.min.js')}}"></script>
  <script>
  $(document).ready(function (){
  	$("#btn-soal").click(function() {
  		$("#wrap-soal").slideToggle();
  	});
  	$("#batal").click(function() {
  		$("#wrap-soal").slideToggle();
  	});
    $("#btn-upload-soal").click(function() {
      $("#wrap-soal").hide();
      $("#wrap-upload-soal").slideToggle();
    })
    $("#batal-upload").click(function() {
      $("#wrap-upload-soal").slideToggle();
    })
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

  	var id = document.URL;
    var id = id.split('/');
    var id = id[id.length-1];
    table_soal = $('#table_detail_soal').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      lengthChange: true,
      ajax: {
        url: '{!! route('elearning.get-detail-soal') !!}',
        data: function(d) {
         	d.id = id;
        }
      },
      columns: [
        {data: 'soal', name: 'soal', orderable: true, searchable: true },
        {data: 'pila', name: 'pila', "visible": false, orderable: true, searchable: true },
        {data: 'pilb', name: 'pilb', "visible": false, orderable: true, searchable: true },
        {data: 'pilc', name: 'pilc', "visible": false, orderable: true, searchable: true },
        {data: 'pild', name: 'pild', "visible": false, orderable: true, searchable: true },
        {data: 'pile', name: 'pile', "visible": false, orderable: true, searchable: true },
        {data: 'kunci', name: 'kunci', orderable: true, searchable: true },
        {data: 'score', name: 'score', orderable: true, searchable: true },
        {data: 'status', name: 'status', orderable: true, searchable: true },
        {data: 'action', name: 'action', orderable: false, searchable: false, },
      ],
      "drawCallback": function (setting) {}
    });

    $("#simpan-soal").click(function() {
      $("#wrap-btn").hide();
      $("#loading-soal").show();
      var dataString = $("#form-soal").serialize();
      $.ajax({
        type: "POST",
        url: "{{ url('/crud/simpan-detail-soal') }}",
        data: dataString + "&id_soal="+id,
        success: function(data){
          $("#loading-soal").hide();
          $("#wrap-btn").show();
          if (data == 'ok') {
            $("#notif-soal").removeClass('alert alert-danger').addClass('alert alert-info').html("Soal berhasil disimpan.").show();
          }else{
            $("#notif-soal").removeClass('alert alert-info').addClass('alert alert-danger').html(data).show();
          }
        }
      })
    });
  });
  </script>
@endpush