@extends('layouts.master')

@section('title')
  <title>Data Pegawai Per Periode Penggajian</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Daftar Pegawai Periode Penggajian Per Tanggal {{$getperiode->tanggal}}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('periodegaji.index')}}"> Kelola Periode Gaji</a></li>
    <li class="active">Detail Pegawai Per Periode</li>
  </ol>
@stop

@section('content')
  <script>
    window.setTimeout(function() {
      $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 2000);
  </script>

  {{-- -- MODAL DELETE -- --}}
  <div class="modal modal-default fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Pegawai Dari Periode Gaji</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus pegawai dari periode penggajian ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-danger" id="set">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>
  {{-- -- END OF MODAL DELETE -- --}}

  {{-- -- MODAL EDIT GAJI -- --}}
  <div class="modal modal-default fade" id="myModalEditGaji" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('periodegaji.update')}}" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Gaji Pokok</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">NIP Pegawai</label>
              <div class="col-sm-9">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" id="idgapok" name="id">
                <input type="hidden" class="form-control" name="idperiode" value="{{$idperiode}}">
                <input type="hidden" name="periode_tahun" class="form-control" id="periode_tahun" placeholder="Periode Tahun" id="periode_tahun" readonly="true">
                <input type="text" class="form-control" id="nippegawaigapok" name="nip" readonly="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Pegawai</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="namapegawaigapok" name="nama" readonly="">
              </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Gaji Pokok</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="gaji_pokok" id="nilaigapok">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
            <input class="btn btn-success" type="submit" value="Simpan Perubahan">
          </div>
        </div>
      </form>
    </div>
  </div>
  {{-- -- END OF MODAL EDIT GAJI -- --}}

  {{-- -- MODAL EDIT WORKDAY -- --}}
  <div class="modal modal-default fade" id="myModalEditWorkDay" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('periodegaji.updateworkday')}}" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Hari Kerja</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">NIP Pegawai</label>
              <div class="col-sm-9">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" id="idhaker" name="id">
                <input type="hidden" class="form-control" name="idperiode" value="{{$idperiode}}">
                <input type="text" class="form-control" id="nippegawaihaker" name="nip" readonly="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Pegawai</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="namapegawaihaker" name="nama" readonly="">
              </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Hari Kerja</label>
                <div class="col-sm-9">
                  <select class="form-control" name="workday">
                    <option value="">-- PILIH --</option>
                    <option value="52" id="haker52">[5-2] -- 5 Hari Kerja, 2 Hari Libur</option>
                    <option value="61" id="haker61">[6-1] -- 6 Hari Kerja, 1 Hari Libur</option>
                    <option value="70" id="haker70">[7-0] -- 7 Hari Kerja, 0 Hari Libur</option>
                  </select>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
            <input class="btn btn-success" type="submit" value="Simpan Perubahan">
          </div>
        </div>
      </form>
    </div>
  </div>
  {{-- -- MODAL EDIT WORKDAY -- --}}

  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
          <p>{{ Session::get('message') }}</p>
        </div>
      @endif
    </div>

    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="box-title">
            Seluruh Data Pegawai Periode Pengajian Per Tanggal {{$getperiode->tanggal}}
          </h3>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-hover" id="tabelpegawai">
            <thead>
              <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>No Telp</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Gaji Pokok</th>
                <th>Hari Kerja</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>

  <script type="text/javascript">
    var d = new Date();
    var n = d.getFullYear();
    $('#periode_tahun').attr('value', n);
  </script>

  <script type="text/javascript">

    $(function() {
        $('#tabelpegawai').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('periodegaji.getdata', $idperiode) !!}',
            column: [
              {data: 'id', name: 'id'},
              {data: '0', name: 'nip'},
              {data: '1', name: 'name'},
              {data: '2', name: 'no_telp'},
              {data: '3', name: 'nama_jabatan'},
              {data: '5', name: 'status'},
              {data: '6', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#tabelpegawai').DataTable().on('click', 'a.hapus[data-value]', function () {
          var a = $(this).data('value');
          $('#set').attr('href', '{{url('/')}}/periode-pegawai/delete/'+a);
        });

        $('#tabelpegawai').DataTable().on('click', 'a.editgaji[data-value]', function () {
          var a = $(this).data('value');
          $.ajax({
            url: "{{ url('/') }}/set-gaji-pegawai/bind-gaji/"+a,
            dataType: 'json',
            success: function(data){
              // get
              var id = data.id;
              var nip = data.nip;
              var nama = data.nama;
              var gaji = data.gaji_pokok;

              // set
              $('#idgapok').attr('value', id);
              $('#nippegawaigapok').attr('value', nip);
              $('#namapegawaigapok').attr('value', nama);
              $('#nilaigapok').attr('value', gaji);
            }
          });
        });

        $('#tabelpegawai').DataTable().on('click', 'a.editworkday[data-value]', function () {
          var a = $(this).data('value');
          $.ajax({
            url: "{{ url('/') }}/set-gaji-pegawai/bind-gaji/"+a,
            dataType: 'json',
            success: function(data){
              // get
              var id = data.id;
              var nip = data.nip;
              var nama = data.nama;
              var workday = data.workday;

              // set
              $('#idhaker').attr('value', id);
              $('#nippegawaihaker').attr('value', nip);
              $('#namapegawaihaker').attr('value', nama);

              if (workday==52) {
                $('#haker52').attr('selected', true);
                $('#haker61').attr('selected', false);
                $('#haker70').attr('selected', false);
              } else if (workday==61) {
                $('#haker61').attr('selected', true);
                $('#haker52').attr('selected', false);
                $('#haker70').attr('selected', false);
              } else if (workday==70) {
                $('#haker61').attr('selected', false);
                $('#haker52').attr('selected', false);
                $('#haker70').attr('selected', true);
              }
            }
          });
        });
      });
  </script>

@stop
