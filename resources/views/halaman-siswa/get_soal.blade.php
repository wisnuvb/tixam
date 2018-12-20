<span class="detail_soal_id" style="display: none;">{{ $soal->id }}</span>
	<div class="soal">{!! $soal->soal !!}</div>
	{!! $soal->pila ? '<div class="jawab"
		soal-id="'.$soal->id_soal.'"
		data-id="'.$soal->id.'"
		data-jawab="A/'.$soal->id.'/'.Auth::user()->id.'">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>A.</span></td>
				<td valign="top" class="pilihan">'.$soal->pila.'</td>
			</tr>
		</table>
	</div>' : '' !!}
	{!! $soal->pilb ? '<div class="jawab"
		soal-id="'.$soal->id_soal.'"
		data-id="'.$soal->id.'"
		data-jawab="B/'.$soal->id.'/'.Auth::user()->id.'">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>B.</span></td>
				<td valign="top" class="pilihan">'.$soal->pilb.'</td>
			</tr>
		</table>
	</div>' : '' !!}
	{!! $soal->pilc ? '<div class="jawab"
		soal-id="'.$soal->id_soal.'"
		data-id="'.$soal->id.'"
		data-jawab="C/'.$soal->id.'/'.Auth::user()->id.'">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>C.</span></td>
				<td valign="top" class="pilihan">'.$soal->pilc.'</td>
			</tr>
		</table>
	</div>' : '' !!}
	{!! $soal->pild ? '<div class="jawab"
		soal-id="'.$soal->id_soal.'"
		data-id="'.$soal->id.'"
		data-jawab="D/'.$soal->id.'/'.Auth::user()->id.'">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>D.</span></td>
				<td valign="top" class="pilihan">'.$soal->pild.'</td>
			</tr>
		</table>
	</div>' : '' !!}
	{!! $soal->pile ? '<div class="jawab"
		soal-id="'.$soal->id_soal.'"
		data-id="'.$soal->id.'"
		data-jawab="E/'.$soal->id.'/'.Auth::user()->id.'">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>E.</span></td>
				<td valign="top" class="pilihan">'.$soal->pile.'</td>
			</tr>
		</table>
	</div>' : '' !!}