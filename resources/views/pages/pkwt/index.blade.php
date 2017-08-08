@extends('layouts.master')

@section('title')
  <title>Lihat Data PKWT</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Data PKWT
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">PKWT</li>
  </ol>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <a class="btn btn-round bg-red" href="{{ route('pkwt.create') }}"><i class="fa fa-users"></i> Tambah PKWT</a>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-hover" id="tabelpkwt">
            <thead>
              <tr>
                <th>NIP</th>
                <th>NIP Lama</th>
                <th>Nama</th>
                <th>Tanggal Awal PKWT</th>
                <th>Tanggal Akhir PKWT</th>
                <th>Kelompok Jabatan</th>
                <th>Client - Cabang</th>
                <th>Keterangan</th>
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
    $(function() {
        $('#tabelpkwt').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables.pkwt') !!}',
            column: [
              {data: 'id', name: 'id'},
              {data: '0', name: 'nip'},
              {data: '1', name: 'nip_lama'},
              {data: '2', name: 'nama'},
              {data: '3', name: 'tanggal_awal_pkwt'},
              {data: '4', name: 'tanggal_akhir_pkwt'},
              {data: '5', name: 'id_kelompok_jabatan'},
              {data: '6', name: 'nama_cabang'},
              {data: '7', name: 'keterangan'},
              {data: '8', name: 'action', orderable: false, searchable: false}
            ]
        });

    });
  </script>

@stop
