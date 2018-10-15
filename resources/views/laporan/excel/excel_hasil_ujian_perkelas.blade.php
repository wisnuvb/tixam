<?php
	use App\Models\Jawab;
?>
<table>
	<tbody>
		<tr>
			<td><b>Paket Soal</b></td>
			<td colspan="4">{{ $soal->paket }}</td>
		</tr>
		<tr>
			<td><b>Kelas</b></td>
			<td colspan="4">{{ $kelas->nama }}</td>
		</tr>
	</tbody>
</table>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>NIS</th>
			<th>Nama</th>
			<th style="text-align: center;">Jumlah Soal</th>
			<th style="text-align: center;">Jawaban Benar</th>
			<th style="text-align: center;">Nilai</th>
		</tr>
	</thead>
	<tbody>
		@if($jawabs->count())
		@foreach($jawabs as $jawab)
		<tr>
			<td>@if($jawab->user){{ $jawab->user->no_induk }}@endif</td>
			<td>@if($jawab->user){{ $jawab->user->nama }}@endif</td>
			<td style="text-align: center;">{{ $detailSoal->count() }}</td>
			<td style="text-align: center;">
				<?php
					$get_jawaban_benar = Jawab::where('id_soal', $soal->id)->where('id_kelas', $kelas->id)->where('id_user', $jawab->id_user)->where('score', '!=', 0)->where('status', 'Y')->get();
				?>
				{{ $get_jawaban_benar->count() }}
			</td>
			<td style="text-align: center;">
				<?php
					$jumlah_jawaban_benar = Jawab::where('id_soal', $soal->id)
																					->where('id_kelas', $kelas->id)
																					->where('id_user', $jawab->id_user)
																					->where('status', 'Y')
																					->select(DB::raw('sum(jawabs.score) as jumlahNilai'))
																					->first();
				?>
				{{ $jumlah_jawaban_benar->jumlahNilai }}
			</td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>