@extends('layouts.app')
@section('title', 'Ubah kelas')
@section('breadcrumb')
  <h1>Master Data</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Kelas</li>
  </ol>
@endsection
@section('content')
  <?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-edit" aria-hidden="true"></i> Ubah Kelas</h3>
        <div class="pull-right">
          <button type="button" class="btn btn-primary" id="btn-create"><i class="fa fa-edit"></i> Buat Kelas</button>
        </div>
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <form id="form-kelas" style="" class="form-horizontal">
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">Nama Kelas</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="{{ $kelas->id }}">
                  <input type="email" class="form-control" name="nama" id="nama" value="{{ $kelas->nama }}" placeholder="Nama Kelas">
                </div>
              </div>
              <div class="form-group">
                <label for="id_wali" class="col-sm-2 control-label">Wali Kelas</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_wali" id="id_wali" placeholder="Wali Kelas">
                    <option value="{{ $kelas->id_wali ? $kelas->id_wali : '' }}">{{ $kelas->wali ? $kelas->wali->nama : 'Pilih Wali Kelas' }}</option>
                    @forelse($gurus as $guru)
                      <option value="{{  $guru->id }}">{{  $guru->nama }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="save" class="col-sm-2 control-label">&nbsp</label>
                <div class="col-sm-10">
                  <div class="alert alert-danger" id="notif" style="display: none; margin: 0 auto 10px"></div>
                  <button type="button" class="btn btn-primary" id="save">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script>
    $(document).ready(function (){
      $('#save').click(function() {
        $('#notif').hide();
        var formData = $('#form-kelas').serialize();
        $.ajax({
          type: 'POST',
          url: "{{ url('crud/simpan-kelas') }}",
          data: formData,
          success: function(data) {
            if (data == 1) {
              window.location.href = "{{ url('master/kelas/detail/'.$kelas->id) }}";
            }else{
              $('#notif').html(data).show();
            }
          }
        })
      });
    });
  </script>
@endpush