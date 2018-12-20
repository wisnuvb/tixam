<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
	input[type="radio"] {
		margin-top: 3px;
	}
	table {
		border-collapse: collapse;
	}
	.garis {
		border: solid thin #333;
		padding: 6px;
	}
	.well {
		background: #f2f6fc;
		padding: 15px;
		border: solid thin #d7dee8;
		color: #3a4149;
	}
	.benar {
		background: #e5f9e9;
		color: #1d231e;
	}
	.salah {
		background: #f9f1ed;
		color: #1d231e;
	}
</style>
<title>Hasil Ujian {{ $siswa->nama }}</title>
<?php require app_path().'/functions/myconf.php'; ?>
<table width="100%">
	<tr>
		<td style="width: 75px">Nama</td>
		<td style="width: 15px">:</td>
		<td>{{ $siswa->nama }} </td>
	</tr>
	<tr>
		<td style="width: 75px">NIS</td>
		<td style="width: 15px">:</td>
		<td>{{ $siswa->no_induk }} </td>
	</tr>
	<tr>
		<td style="width: 75px">Kelas</td>
		<td style="width: 15px">:</td>
		<td>{{ $siswa->getKelas->nama }} </td>
	</tr>
	<tr>
		<td style="width: 75px">Tanggal</td>
		<td style="width: 15px">:</td>
		<td>{{ timeStampIndoOnly($jawab_first->created_at) }} </td>
	</tr>
</table>
<hr>
<div class="well">Data soal dibawah ini adalah soal yang telah dikerjakan oleh <b>{{ $siswa->nama }}</b>. Soal yang tidak dikerjakan tidak ditampilkan pada file ini.</div><br>
<table width="100%">
	@if($jawabs->count())
	<?php $no = 1; ?>
	@foreach($jawabs as $jawab)
	<tr>
		<td style="width: 25px">{{ $no++ }}</td>
		<td>{{ $jawab->detailSoal->soal }}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td @if($jawab->detailSoal->kunci == 'A') class='benar' @endif><input type="radio" name="" @if($jawab->pilihan == 'A') checked @endif> {!! $jawab->detailSoal->pila !!}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td @if($jawab->detailSoal->kunci == 'B') class='benar' @endif><input type="radio" name="" @if($jawab->pilihan == 'B') checked @endif> {!! $jawab->detailSoal->pilb !!}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td @if($jawab->detailSoal->kunci == 'C') class='benar' @endif><input type="radio" name="" @if($jawab->pilihan == 'C') checked @endif> {!! $jawab->detailSoal->pilc !!}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td @if($jawab->detailSoal->kunci == 'D') class='benar' @endif><input type="radio" name="" @if($jawab->pilihan == 'D') checked @endif> {!! $jawab->detailSoal->pild !!}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td @if($jawab->detailSoal->kunci == 'E') class='benar' @endif><input type="radio" name="" @if($jawab->pilihan == 'E') checked @endif> {!! $jawab->detailSoal->pile !!}</td>
	</tr>
	@endforeach
	@endif
</table>
<br>
<hr style="margin-bottom: 4px">
<div style="height: 5px"></div>
<table>
	<tr>
		<td class="garis" style="width: 150px">Jumlah Soal</td>
		<td class="garis" style="width: 250px">{{ $jumlah_soal }} soal</td>
	</tr>
	<tr>
		<td class="garis">Soal Dijawab</td>
		<td class="garis">{{ $jawabs->count() }} soal</td>
	</tr>
	<tr>
		<td class="garis">Jawaban Benar</td>
		<td class="garis">{{ $jawabBenar->count() }} soal</td>
	</tr>
	<tr>
		<td class="garis">Nilai</td>
		<td class="garis">{{ $jumlah_jawaban_benar->jumlahNilai }}</td>
	</tr>
</table>