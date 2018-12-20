@extends('layouts.app')
@section('title', 'Data siswa')
@section('breadcrumb')
  <h1>Master Data</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Siswa</li>
  </ol>
@endsection
@section('content')
  <?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Data Siswa</h3>
        @if(Auth::user()->status == "A")
          <div class="pull-right">
            <button type="button" class="btn btn-primary" id="btn-siswa"><i class="fa fa-edit"></i> Tambah Siswa</button>
            <button type="button" class="btn btn-success" id="btn-upload"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Upload via Excel</button>
            <a href="{{ url('/download-file-format/siswa') }}" class="btn btn-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Download format Excel</a>
            <a href="{{ url('master/siswa/delete') }}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Hapus Semua Siswa</a>
          </div>
        @endif
      </div>
      <div class="box-body">
        @if(Auth::user()->status == "A")
          <div class="well" style="display: none;" id="wrap-siswa">
            <form class="form-horizontal" id="form-siswa">
              <div class="box-body">
                <div class="form-group">
                  <label for="nama" class="col-sm-3 control-label">Nama</label>
                  <div class="col-sm-9">
                    <input type="hidden" name="id" value="N">
                    <input type="hidden" name="status_sekolah" value="Y">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                  </div>
                </div>
                <div class="form-group">
                  <label for="id_kelas" class="col-sm-3 control-label">Kelas</label>
                  <div class="col-sm-9">
                    <select name="id_kelas" id="id_kelas" class="form-control select2Class" style="width: 100%">
                      <option value="">Pilih Kelas</option>
                      @forelse($kelas as $data_kelas)
                        <option value="{{ $data_kelas->id }}">{{ $data_kelas->nama }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="no_induk" class="col-sm-3 control-label">NIS</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="no_induk" name="no_induk" placeholder="NIS">
                  </div>
                </div>
                <div class="form-group">
                  <label for="nisn" class="col-sm-3 control-label">NIS</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nisn" name="nisn" placeholder="NISN">
                  </div>
                </div>
                <div class="form-group">
                  <label for="jk" class="col-sm-3 control-label">Jenis Kelamin</label>
                  <div class="col-sm-9">
                    <div class="radio">
                      <label><input type="radio" name="jk" id="l" value="L"> Laki-laki</label> &nbsp;&nbsp;&nbsp;
                      <label><input type="radio" name="jk" id="p" value="P"> Perempuan</label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                  </div>
                </div>
                <div class="form-group" style="margin-top: 20px">
                  <div class="col-sm-offset-3 col-sm-9">
                    <div id="notif" style="display: none;"></div>
                    <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading">
                    <div id="wrap-btn">
                      <button type="button" class="btn btn-success" id="simpan-siswa">Simpan</button>
                      <button type="button" class="btn btn-danger" id="batal">Batal</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <hr>
          </div>
          <div class="well" style="display: none;" id="wrap-upload-siswa">
            <form class="form-horizontal" action="{{ url('/crud/simpan-siswa-via-excel') }}" enctype="multipart/form-data" method="POST" id="form-upload-siswa">
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
            <hr>
          </div>
        @endif
  	    <table id="tabel_siswa" class="table table-hover table-condensed">
  	    	<thead>
  	    		<tr>
  	    			<th>Nama</th>
  	    			<th>NIS</th>
              <th>NISN</th>
  	    			<th>Jenis kelamin</th>
              <th>Kelas</th>
  	    			<th style="width: 130px; text-align: center;">Aksi</th>
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
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/select2/select2.min.css')}}">
  <style type="text/css">
    .select2-container--default .select2-selection--single {
      height: 33px;
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
  <script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
  <script src="{{URL::asset('assets/plugins/select2/select2.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
  <script>
  $(document).ready(function (){
    $('.select2Class').select2();

  	tabel_siswa = $('#tabel_siswa').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      lengthChange: true,
      ajax:'{!! route('master.data_siswa') !!}',
      columns: [
        {data: 'nama', name: 'nama', orderable: true, searchable: true },
        {data: 'no_induk', name: 'no_induk', orderable: true, searchable: true },
        {data: 'nisn', name: 'nisn', orderable: true, searchable: true },
        {data: 'jk', name: 'jk', orderable: false, searchable: false },
        {data: 'kelas', name: 'kelas', orderable: false, searchable: false },
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
      "drawCallback": function (setting) {
        $('.del-siswa').on('click', function() {
          var id_siswa = $(this).attr('id');
          var $this = $(this);
          swal({
            title: 'Yakin akan dihapus?',
            text: "Data yang telah dihapus tidak bisa dikembalikan.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                type: 'POST',
                url: "{{ url('crud/delete-siswa') }}",
                data: {id_siswa:id_siswa},
                success: function(data) {
                  swal(
                    'Berhasil!',
                    'Data siswa berhasil dihapus.',
                    'success'
                  )
                  $this.closest('tr').hide();
                }
              })
            }
          })
        });
      }
    });

    $("#btn-siswa").click(function(){
      $("#wrap-siswa").slideToggle();
    });
    $("#batal").click(function(){
      $("#wrap-siswa").slideToggle();
    });

    $("#btn-upload").click(function(){
      $("#wrap-upload-siswa").slideToggle();
    });
    $("#batal-upload").click(function(){
      $("#wrap-upload-siswa").slideToggle();
    });

    $('#no_induk').keyup(function(){
      $('#email').val($(this).val()+'@ayosinau.com');
    });

    $("#simpan-siswa").click(function() {
      $("#wrap-btn").hide();
      $("#loading").show();
      var dataString = $("#form-siswa").serialize();
      $.ajax({
        type: "POST",
        url: "{{ url('/crud/simpan-siswa') }}",
        data: dataString,
        success: function(data){
          $("#loading").hide();
          $("#wrap-btn").show();
          if (data == '1') {
            $("#notif").removeClass('alert alert-danger').addClass('alert alert-info').html("Siswa berhasil ditambahkan.").show();
            window.location.href = "{{ url('master/siswa') }}";
          }else{
            $("#notif").removeClass('alert alert-info').addClass('alert alert-danger').html(data).show();
          }
        }
      })
    });
  });
  </script>
@endpush