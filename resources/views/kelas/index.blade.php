@extends('layouts.app')
@section('title', 'Data kelas')
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
        <h3 class="box-title aaaa"><i class="fa fa-address-card" aria-hidden="true"></i> Data Kelas</h3>
        <div class="pull-right">
          <button type="button" class="btn btn-primary" id="btn-create"><i class="fa fa-edit"></i> Buat Kelas</button>
        </div>
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <form id="form-kelas" style="display: none; margin: 0 auto 20px;" class="form-horizontal well">
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">Nama Kelas</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="N">
                  <input type="email" class="form-control" name="nama" id="nama" placeholder="Nama Kelas">
                </div>
              </div>
              <div class="form-group">
                <label for="id_wali" class="col-sm-2 control-label">Wali Kelas</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_wali" id="id_wali" placeholder="Wali Kelas">
                    <option>Pilih Wali Kelas</option>
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
        <div class="clearfix"></div>
  	    <table id="tabel_kelas" class="table table-hover table-condensed">
  	    	<thead>
  	    		<tr>
              <th>ID Kelas</th>
  	    			<th>Nama kelas</th>
              <th style="text-align: center;">Jumlah Siswa</th>
              <th style="text-align: center;">Wali Kelas</th>
  	    			<th style="width: 130px; text-align: center;">Aksi</th>
  	    		</tr>
  	    	</thead>
  	    </table>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title" style="color: darkorange"><i class="fa fa-info-circle"></i> Informasi</h3>
      </div>
      <div class="box-body">
        <p>Daftarkan seluruh kelas malalui halaman ini. Data kelas diperlukan untuk mengelompokan siswa dan untuk mendistribusian paket soal.</p>
        <p>Jika terdapat data kelas yang belum valid atau kelas yang belum terdaftar, hubungi operator sekolah untuk merubah atau mendaftarkan kelas tersebut.</p>
      </div>
    </div>
  </div>
@endsection
@push('css')
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush
@push('scripts')
  <script src="{{URL::asset('assets/dist/js/offline.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
  <script>
    $(document).ready(function (){
      function checkconnection() {
        var status = navigator.onLine;
        if (status) {
          // alert("online");
        } else {
          // alert("offline");
        }
      }

    	tabel_kelas = $('#tabel_kelas').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthChange: true,
        ajax:'{!! route('master.data_kelas') !!}',
        columns: [
          {data: 'id', name: 'id', orderable: true, searchable: true },
          {data: 'nama', name: 'nama', orderable: true, searchable: true },
          {data: 'siswa', name: 'siswa', orderable: false, searchable: false },
          {data: 'wali', name: 'wali', orderable: false, searchable: false },
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "drawCallback": function (setting) {
          $('.del-kelas').on('click', function() {
            var id_kelas = $(this).attr('id');
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
                  url: "{{ url('crud/delete-kelas') }}",
                  data: {id_kelas:id_kelas},
                  success: function(data) {
                    swal(
                      'Berhasil!',
                      'Data guru berhasil dihapus.',
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

      $('#btn-create').click(function() {
        $('#form-kelas').slideToggle();
      });

      $('#save').click(function() {
        $('#notif').hide();
        var formData = $('#form-kelas').serialize();
        $.ajax({
          type: 'POST',
          url: "{{ url('crud/simpan-kelas') }}",
          data: formData,
          success: function(data) {
            if (data == 1) {
              window.location.href = "{{ url('master/kelas') }}";
            }else{
              $('#notif').html(data).show();
            }
          }
        })
      });
    });
  </script>
@endpush