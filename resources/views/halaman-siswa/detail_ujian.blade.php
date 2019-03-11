@extends('layouts.app')
@section('title', 'Ti-Xam - '.Auth::user()->nama)
@section('breadcrumb')
  <h1>Detail Soal Ujian</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/siswa/ujian') }}">Ujian</a></li>
    <li class="active">Hi, {{ Auth::user()->nama }}</li>
  </ol>
@endsection
@section('content')
	<div class="col-md-12">
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title">Detail soal.</h3>
	      <div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      </div>
	    </div>
	    <div class="box-body">
		    <div class="row">
		    	<div class="col-sm-12">
		    		<h1 style="margin:  0 0 0 0; color: #292e38; font-size: 24pt;">{{ $soal->paket }}</h1>
		    		<div id="fsstatus" style="font-size: 14pt; margin: 0 0 20px 0; color: #888c8e"></div>
		    		<div style="border: dotted #0723e8; padding: 10px; margin-bottom: 15px;">
		    			<table class="table table-striped">
		    				<tr>
		    					<td style="width: 120px">Deskripsi</td>
		    					<td style="width: 15px">:</td>
		    					<td>{{ $soal->deskripsi }}</td>
		    				</tr>
		    				<tr>
		    					<td>Jumlah Soal</td>
		    					<td>:</td>
		    					<td>{{ $soal->detailSoal ? number_format($soal->detailSoal->count()) : '0' }}</td>
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
		    			</table>
		    			<button class="btn btn-primary btn-lg btn-block" id="start-exam" onclick="$('#specialstuff').fullScreen(true)">Mulai Mengerjakan Soal!</button>
		    		</div>
		    		<div style="padding:  10px; border: double #fff 15px; color: #fff; background: #b90000;">
		    			<p style="font-weight: bold;">Silahkan kerjakan soal yang telah di siapkan. Harap dipatuhi peraturan berikut!</p>
		    			<ul>
		    				<li>Jangan mereload/refresh browser (jawaban akan hilang)</li>
		    				<li>Jangan menekan tombol selesai saat mengerjakan soal, kecuali saat anda telah selesai mengerjakan seluruh soal</li>
		    				<li>Perhatikan sisa waktu ujian, sistem akan mengumpulkan jawaban saat waktu sudah selesai</li>
		    				<li>Waktu ujian akan dimulai saat tombol "<b>Mulai Mengerjakan Soal!</b>" di klik</li>
		    				<li>Dilarang bekerjasama dengan teman</li>
		    				<li>Jangan keluar dari mode fullscreen, setiap upaya keluar dari mode tersebut akan dihitung</li>
		    			</ul>
		    		</div>
		    		<!-- <div class="alert alert-success">Silahkan kerjakan soal yang telah disediakan.</div> -->
		    	</div>
		    </div>
	    </div>
    </div>
  </div>

  <!-- tampilkan soal disini -->
  <div id="specialstuff" class="row" style="display: none; overflow-y: scroll !important;">
		<div style="height: 40px; background: #0419d0; color: #fff; margin-bottom: 10px">
			<p style="padding-top: 8px; padding-left: 15px; font-weight: bold;">Ti-Xam | Tipamedia Apps for Education</p>
		</div>
  	<div class="col-sm-9">
  		<div class="box box-primary color-palette-box" style="overflow-y: scroll;">
        <div class="box-header with-border">
          <h3 class="box-title">
          	Soal No:
          	@if($soals->count())
							@foreach($soals as $key_number=>$data_number)
								@if($key_number == 0) <span id="no_soal_detail">1</span> @endif
							@endforeach
						@endif
          </h3>
          <!-- <div class="box-tools pull-right" style="width: 350px;">
          	<p style="margin: 2px;" class="pull-right">
	          	<span id="info-waktu" style="display: none; color: #f00; margin-right: 25px"></span>
          		Sisa waktu
	          	<span id="countdown" class="timer"></span>
          	</p>
          </div> -->
        </div>
        <div class="box-body">
					<div id="wrap-soal">
						@if($soals->count())
							@foreach($soals as $key=>$data)
								@if($key == 0)
									<span class="detail_soal_id" style="display: none;">{{ $data->id }}</span>
									<div class="soal">{!! $data->soal !!}</div>
									{!! $data->pila ? '<div class="jawab"
										soal-id="'.$data->id_soal.'"
										data-id="'.$data->id.'"
										data-jawab="A/'.$data->id.'/'.Auth::user()->id.'">
										<table width="100%">
											<tr>
												<td width="15px" valign="top"><span>A.</span></td>
												<td valign="top" class="pilihan">'.$data->pila.'</td>
											</tr>
										</table>
									</div>' : '' !!}
									{!! $data->pilb ? '<div class="jawab"
										soal-id="'.$data->id_soal.'"
										data-id="'.$data->id.'"
										data-jawab="B/'.$data->id.'/'.Auth::user()->id.'">
										<table width="100%">
											<tr>
												<td width="15px" valign="top"><span>B.</span></td>
												<td valign="top" class="pilihan">'.$data->pilb.'</td>
											</tr>
										</table>
									</div>' : '' !!}
									{!! $data->pilc ? '<div class="jawab"
										soal-id="'.$data->id_soal.'"
										data-id="'.$data->id.'"
										data-jawab="C/'.$data->id.'/'.Auth::user()->id.'">
										<table width="100%">
											<tr>
												<td width="15px" valign="top"><span>C.</span></td>
												<td valign="top" class="pilihan">'.$data->pilc.'</td>
											</tr>
										</table>
									</div>' : '' !!}
									{!! $data->pild ? '<div class="jawab"
										soal-id="'.$data->id_soal.'"
										data-id="'.$data->id.'"
										data-jawab="D/'.$data->id.'/'.Auth::user()->id.'">
										<table width="100%">
											<tr>
												<td width="15px" valign="top"><span>D.</span></td>
												<td valign="top" class="pilihan">'.$data->pild.'</td>
											</tr>
										</table>
									</div>' : '' !!}
									{!! $data->pile ? '<div class="jawab"
										soal-id="'.$data->id_soal.'"
										data-id="'.$data->id.'"
										data-jawab="E/'.$data->id.'/'.Auth::user()->id.'">
										<table width="100%">
											<tr>
												<td width="15px" valign="top"><span>E.</span></td>
												<td valign="top" class="pilihan">'.$data->pile.'</td>
											</tr>
										</table>
									</div>' : '' !!}
								@endif
							@endforeach
						@endif
					</div>
        </div>
        <div class="box-footer">
          <table width="100%">
          	<tr>
          		<!-- <td width="33%" align="center"><button class="btn btn-primary"><i class="fa fa-angle-double-left"></i> Soal Sebelumnya</button></td> -->
          		<!-- <td width="33%" align="center"><button class="btn btn-warning">Ragu-ragu</button></td> -->
          		<!-- <td width="33%" align="center"><button class="btn btn-primary">Soal Berikutnya <i class="fa fa-angle-double-right"></i></button></td> -->
          		<td>
          			<button type="button" class="btn pull-left" id="keluar" style="background-image: linear-gradient(to right, #f31515 , #c12704); border: none; color: #fff;" onclick="$('#specialstuff').fullScreen(false)"><i class="fa fa-times-circle" aria-hidden="true"></i> Keluar</button>
          			<button type="button" class="btn pull-right" id="kirim" style="background-image: linear-gradient(to right, #1523f3 , #0495c1); border: none; color: #fff;"><i class="fa fa-paper-plane" aria-hidden="true"></i> Kirim Hasil Ujian</button>
          		</td>
          	</tr>
          </table>
          <div id="confirm" style="display: none; margin: 15px 0; border: solid thin #aaa; padding: 10px;"></div>
        </div>
      </div>
  	</div>
  	<div class="col-sm-3">
  		<div class="box box-success color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title">Navigasi</h3>
        </div>
	      <div class="box-body">
	      	<span>Nomor Soal</span>
	      	@if($soals->count())
	      		<nav aria-label="Page navigation">
						  <ul class="pagination" style="margin-top: 5px !important;">
								@foreach($soals as $key_number=>$data_number)
									<li class="no_soal"
										id="{{ 'nav'.$data_number->id }}"
										data-id="{{ $data_number->id }}"
										data-no="{{ $key_number+1 }}"><a href="#">{{ $key_number+1 }}</a></li>
								@endforeach
							</ul>
						</nav>
					@endif
	      </div>
      </div>
  	</div>  	
	</div>
	<noscript>
	  <style type="text/css">
	    #specialstuff {display:none;}
	  </style>
	  <div class="noscriptmsg">
		  You don't have javascript enabled.  Good luck with that.
	  </div>
	</noscript>
@endsection
@push('css')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" /> -->
<style>
	.dijawab {
		background: #1980d4;
		color: #fff;
		padding: 5px 10px;
    border-radius: 3px;
	}
	.pagination>li>a, .pagination>li>span {
		width: 38px;
    text-align: center;
    margin: 3px;
	}
	.timer{
		border: solid thin #b9b2b2;
    padding: 5px 15px;
    font-size: 14pt;
    color: #fff;
    background: #291a71;
	}
	.soal{
		margin: 0 0 15px 0;
	}
	.box-footer {
    border-top: 1px solid #ebebeb !important;
	}
	.jawab{
		cursor: pointer;
		margin: 0 0 7px 0;
	}
	.pilihan p{
		margin: 0;
	}
</style>
@endpush
@push('scripts')
<script src="{{ url('js/jquery.fullscreen-min.js') }}"></script>
<!-- <script src="{{ url('js/script.js') }}"></script> -->
<script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
<script>
	// var upgradeTime = "{{ $soal->waktu*60 }}";
	// var seconds = upgradeTime;
	// function timer() {
	//   var days        = Math.floor(seconds/24/60/60);
	//   var hoursLeft   = Math.floor((seconds) - (days*86400));
	//   var hours       = Math.floor(hoursLeft/3600);
	//   var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
	//   var minutes     = Math.floor(minutesLeft/60);
	//   var remainingSeconds = seconds % 60;
	//   if (remainingSeconds < 10) {
	//       remainingSeconds = "0" + remainingSeconds; 
	//   }
	//   document.getElementById('countdown').innerHTML = hours + " : " + minutes + " : " + remainingSeconds;
	//   if (seconds == 300) {
	//   	$('#info-waktu').html('Ujian tinggal <b>5</b> menit').show();
	//   	seconds--;
	//   } else if(seconds == 0) {
	//   	clearInterval(countdownTimer);
	//   } else {
	//     seconds--;
	//   }
	// }

	$(document).bind("fullscreenchange", function(e) {
		if ($(document).fullScreen()) {
			console.log('sedang ujian!');
		}else{
			$("#specialstuff").hide();
		}
  });

	// var countdownTimer = setInterval('timer()', 1000);
	$(document).ready(function(){

		if (typeof(Storage) !== "undefined") {
	    // console.log('browser support localstorage');
		} else {
	    swal(
			  'Update Browser!',
			  'Browser tidak support untuk proses ujian ini!',
			  'warning'
			)
		}
		$('.no_soal').click(function() {
			var $this = $(this);
			$('#wrap-soal').html('<center><i class="fa fa-spinner fa-spin" style="font-size: 30pt; color: #12b9cc; margin: 15px;" aria-hidden="true"></i></center>');
			$('#no_soal_detail').html($this.attr('data-no'));
			var id_soal = $this.attr('data-id');
			$.ajax({
				type: "GET",
				url: "{{ url('siswa/ujian/get-soal') }}/"+id_soal,
				success: function(data) {
					$('#wrap-soal').html(data);
				}
			})
		});

		// ubah status jawab soal
		$('#kirim').click(function() {
			// $('#confirm').html(`
			// 	<p>Yakin jawaban kamu akan dikirimkan sekarang? Kamu masih mempunyai waktu `+Math.floor(seconds/60)+` menit. Setelah mengirimkan jawaban, kamu tidak bisa kembali memeriksa jawaban.<p>
  	// 		<button type="button" class="btn" id="batal" style="background-image: linear-gradient(to right, #f31515 , #c12704); border: none; color: #fff;"><i class="fa fa-ban" aria-hidden="true"></i> Tidak! Saya Mau Cek Lagi.</button>
  	// 		<button type="button" class="btn" id="kirim-jawaban" data-id="{{ $soal->id }}" style="background-image: linear-gradient(to right, #1523f3 , #0495c1); border: none; color: #fff;"><i class="fa fa-check-circle" aria-hidden="true"></i> Iya! Saya Kirim Jawaban Saya Sekarang.</button>
			// `).show();
			$('#confirm').html(`
				<pSetelah mengirimkan jawaban, kamu tidak bisa kembali memeriksa jawaban.<p>
  			<button type="button" class="btn" id="batal" style="background-image: linear-gradient(to right, #f31515 , #c12704); border: none; color: #fff;"><i class="fa fa-ban" aria-hidden="true"></i> Tidak! Saya Mau Cek Lagi.</button>
  			<button type="button" class="btn" id="kirim-jawaban" data-id="{{ $soal->id }}" style="background-image: linear-gradient(to right, #1523f3 , #0495c1); border: none; color: #fff;"><i class="fa fa-check-circle" aria-hidden="true"></i> Iya! Saya Kirim Jawaban Saya Sekarang.</button>
			`).show();
		});

		$(document).on('click', '#batal', function() {
			$('#confirm').hide();
		});

		$(document).on('click', '#kirim-jawaban', function() {
			var $this = $(this);
			var id_soal = $this.attr('data-id');
			$.ajax({
				type: "POST",
				url: "{{ url('siswa/ujian/kirim-jawaban') }}",
				data: {id_soal: id_soal},
				success: function(data) {
					window.location.href = "{{ url('siswa/ujian/finish/'.$soal->id) }}";
				}
			})
		});

		var jawab = [];
		var detail_soal_id = [];
		
		$("#start-exam").click(function(){
			// var countdownTimer = setInterval('timer()', 1000);
			$("#specialstuff").show();
		});

		$(document).on('click', ".jawab", function(){
			var $this = $(this);
			var get_jawab = $this.attr('data-jawab');
			var id_soal = $this.attr('data-id');
			var paket_soal = $this.attr('soal-id');
			$('#nav'+id_soal).find('a').css({"background-color": "#1980d4", "color": "#fff"});
			// console.log(id_soal);
			$(".jawab").css({"background-color": "#fff", "color": "#000", "padding": "0","border-radius": "0"});
			$this.css({"background-color": "#1980d4", "color": "#fff", "padding": "5px 10px", "border-radius": "3px"});
			
			$.ajax({
				type: "POST",
				url: "{{ url('siswa/ujian/jawab') }}",
				data: {get_jawab: get_jawab},
				success: function(data) {
					console.log(data);
				}
			})
			
		});
	});

</script>
@endpush