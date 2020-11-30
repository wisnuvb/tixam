{!! $soal_essay->soal ?? "Belum ada soal!" !!}

<textarea name="jawab_essay" id="jawab_essay" class="form-control" placeholder="Tulis jawaban kamu disini!" style="margin-top: 15px; height: 100px">
{{ $soal_essay->userJawab->jawab ?? "" }}
</textarea>

<div class="alert alert-info alert-dismissible" id="notif-essay" style="display: none"></div>
<button class="btn btn-primary" id="simpan-essay" data-id="{{ $soal_essay->id }}">Simpan Jawaban</button>