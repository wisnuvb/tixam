<?php

use App\Models\Jawab;
use Illuminate\Support\Facades\DB;

?>
<table>
	<tbody>
		<tr>
			<td><b>Paket Soal</b></td>
			<td colspan="8">{{ $soal->paket }}</td>
		</tr>
		<tr>
			<td><b>Kelas</b></td>
			<td colspan="8">{{ $kelas->nama }}</td>
		</tr>
	</tbody>
</table>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>NIS</th>
			<th>NISN</th>
			<th>Nama</th>
			<th style="text-align: center;">Jumlah Soal Pilihan Ganda</th>
			<th style="text-align: center;">Jawaban Pilihan Ganda Benar</th>
			<th style="text-align: center;">Jumlah Soal Essay</th>
			<th style="text-align: center;">Jawaban Essay Benar</th>
			<th style="text-align: center;">KKM</th>
			<th style="text-align: center;">Nilai</th>
		</tr>
	</thead>
	<tbody>
		@if($jawabs->count())
		@foreach($jawabs as $jawab)
		<?php
		$jumlah_jawaban_benar = Jawab::where('id_soal', $soal->id)
			->where('id_kelas', $kelas->id)
			->where('id_user', $jawab->id_user)
			->where('status', 1)
			->select(DB::raw('sum(jawabs.score) as jumlahNilai'))
			->first();
		if ($jumlah_jawaban_benar->jumlahNilai > $soal->kkm) {
			$style = 'background: #3192e4; color: #fff';
		} else {
			$style = 'background: #f52020; color: #fff';
		}
		?>
		<tr>
			<td style="text-align: left;">@if($jawab->user){{ $jawab->user->no_induk }}@endif</td>
			<td style="text-align: left;">@if($jawab->user){{ $jawab->user->nisn }}@endif</td>
			<td>@if($jawab->user){{ $jawab->user->nama }}@endif</td>
			<td style="text-align: center;">{{ $detailSoal->count() }}</td>
			<td style="text-align: center;">
				<?php
				$get_jawaban_benar = Jawab::where('id_soal', $soal->id)
					->where('id_kelas', $kelas->id)
					->where('id_user', $jawab->id_user)
					->where('score', '!=', 0)
					->where('status', 1)
					->count();
				?>
				{{ $get_jawaban_benar }}
			</td>
			<td style="text-align: center;">{{ $soal_essay->count() }}</td>
			<td style="text-align: center;">
				<?php $nilai_essay = 0; ?>
				@if($soal_essay->count())
				@foreach($soal_essay as $essay)
				<?php
					$nilai_essay = $nilai_essay + ($essay->getJawab->score ?? 0);
				?>
				@endforeach
				@endif
				{{ $nilai_essay }}
			</td>
			<td style="text-align: center;">{{ $soal->kkm }}</td>
			<td style="text-align: center; {{ $style }}">
				<b>{{ $jumlah_jawaban_benar->jumlahNilai }}</b>
			</td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>