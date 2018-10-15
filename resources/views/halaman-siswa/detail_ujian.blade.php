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
		    			<button class="btn btn-primary btn-lg btn-block" id="start-exam">Mulai Mengerjakan Soal!</button>
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


  <div id="specialstuff" class="row" style="height: 100%; width: 100%; display: none;">
		<div style="height: 40px; background: #0419d0; color: #fff; margin-bottom: 10px">
			<p style="padding-top: 8px; padding-left: 15px; font-weight: bold;">Ti-Xam | Tipamedia Apps for Education</p>
		</div>
  	<div class="col-sm-8">
  		<div class="box box-primary color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title">
          	Soal No:
          	@if($soals->count())
						@foreach($soals as $key_number=>$data_number)
							@if($key_number == 0) 1 @endif
						@endforeach
						@endif
          </h3>
          <div class="box-tools pull-right" style="width: 250px;">
          	<p style="margin: 2px;" class="pull-right">
          		Sisa waktu
	          	<span id="countdown" class="timer"></span>
          	</p>
          </div>
        </div>
        <div class="box-body">
					<div id="wrap-soal">
						@if($soals->count())
						@foreach($soals as $key=>$data)
							@if($key == 0)
								<span class="detail_soal_id" style="display: none;">{{ $data->id }}</span>
								<div class="soal">{!! $data->soal !!}</div>
								{!! $data->pila ? '<div class="jawab" id="A/'.$data->id.'/'.$data->id_soal.'/'.Auth::user()->id.'">
									<table width="100%">
										<tr>
											<td width="15px" valign="top"><span>A.</span></td>
											<td valign="top" class="pilihan">'.$data->pila.'</td>
										</tr>
									</table>
								</div>' : '' !!}
								{!! $data->pilb ? '<div class="jawab" id="B/'.$data->id.'/'.$data->id_soal.'/'.Auth::user()->id.'">
									<table width="100%">
										<tr>
											<td width="15px" valign="top"><span>B.</span></td>
											<td valign="top" class="pilihan">'.$data->pilb.'</td>
										</tr>
									</table>
								</div>' : '' !!}
								{!! $data->pilc ? '<div class="jawab" id="C/'.$data->id.'/'.$data->id_soal.'/'.Auth::user()->id.'">
									<table width="100%">
										<tr>
											<td width="15px" valign="top"><span>C.</span></td>
											<td valign="top" class="pilihan">'.$data->pilc.'</td>
										</tr>
									</table>
								</div>' : '' !!}
								{!! $data->pild ? '<div class="jawab" id="D/'.$data->id.'/'.$data->id_soal.'/'.Auth::user()->id.'">
									<table width="100%">
										<tr>
											<td width="15px" valign="top"><span>D.</span></td>
											<td valign="top" class="pilihan">'.$data->pild.'</td>
										</tr>
									</table>
								</div>' : '' !!}
								{!! $data->pile ? '<div class="jawab" id="E/'.$data->id.'/'.$data->id_soal.'/'.Auth::user()->id.'">
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
          		<td width="33%" align="center"><button class="btn btn-primary"><i class="fa fa-angle-double-left"></i> Soal Sebelumnya</button></td>
          		<td width="33%" align="center"><button class="btn btn-warning">Ragu-ragu</button></td>
          		<td width="33%" align="center"><button class="btn btn-primary">Soal Berikutnya <i class="fa fa-angle-double-right"></i></button></td>
          	</tr>
          </table>
        </div>
      </div>
  	</div>
  	<div class="col-sm-4">
  		<div id="test"></div>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> -->
<script src="{{ url('js/script.js') }}"></script>
<script>
	var upgradeTime = {{ $soal->waktu*60 }};
	var seconds = upgradeTime;
	function timer() {
	  var days        = Math.floor(seconds/24/60/60);
	  var hoursLeft   = Math.floor((seconds) - (days*86400));
	  var hours       = Math.floor(hoursLeft/3600);
	  var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
	  var minutes     = Math.floor(minutesLeft/60);
	  var remainingSeconds = seconds % 60;
	  if (remainingSeconds < 10) {
	      remainingSeconds = "0" + remainingSeconds; 
	  }
	  document.getElementById('countdown').innerHTML = hours + " : " + minutes + " : " + remainingSeconds;
	  if (seconds == 300) {
	    clearInterval(countdownTimer);
	    document.getElementById('countdown').innerHTML = "Ujian tinggal 5 menit";
	  } else if(seconds == 0) {
	  	clearInterval(countdownTimer);
	  	// document.getElementById('countdown').innerHTML = "Completed";
	  } else {
	    seconds--;
	  }
	}
	// var countdownTimer = setInterval('timer()', 1000);
	$(document).ready(function(){
		var jawab = [];
		var detail_soal_id = [];
		$("#start-exam").click(function(){
			var countdownTimer = setInterval('timer()', 1000);
			$("#specialstuff").show();
		});
		$(".jawab").click(function(){
			var get_jawab = $(this).attr('id');
			var get_detail_soal_id = $(".detail_soal_id").html();
			Array.prototype.unique = function() {
		    var a = [];
		    var l = this.length;
		    for(var i=0; i<l; i++) {
		      for(var j=i+1; j<l; j++) {
		        if (this[i] === this[j])
		          j = ++i;
		      }
		      a.push(this[i]);
		    }
		    return a;
		  };

			// jawab.push(get_detail_soal_id:get_jawab);

			var myArray = {get_detail_soal_id: get_jawab, id2: 200, "tag with spaces": 300};
			myArray.id3 = 400;
			myArray["id4"] = 500;
			
			thelist = jawab.unique()
			console.log(myArray);
			// $("#test").html(jawab);
		});
	});

</script>
@endpush