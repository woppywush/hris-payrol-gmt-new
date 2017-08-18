@extends('layouts.master')

@section('title')
    <title>Kelola Komponen Gaji</title>
@stop

@section('breadcrumb')
  <h1>
    Rapel Gaji
    <small>List Rapel Gaji</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">List Rapel Gaji</li>
  </ol>
@stop

@section('content')
  <script>
    window.setTimeout(function() {
      $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 2000);

    window.setTimeout(function() {
      $(".alert-warning").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 2000);
  </script>

  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        <p>{{ Session::get('message') }}</p>
      </div>
      @endif
      @if(Session::has('gagal'))
      <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-times"></i> Perhatian!</h4>
        <p>{{ Session::get('gagal') }}</p>
      </div>
      @endif
    </div>
    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Seluruh Batch Rapel Gaji</h3>
        </div>
        <div class="box-body table-responsive">
          <table id="table_list" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Client</th>
                <th>Cabang Client</th>
                <th>Tahun Penyesuaian</th>
                <th>Tanggal Penyesuaian</th>
                <th>Nilai Penyesuaian</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key)
                <tr>
                  <td>#</td>
                  <td>{{$key->nama_client}}</td>
                  <td>{{$key->nama_cabang}}</td>
                  @php
                    $exp = explode('-', $key->tanggal_proses);
                  @endphp
                  <td><span class="badge bg-green">{{$exp[0]}}</span></td>
                  <td>{{$key->tanggal_proses}}</td>
                  <td>{{$key->nilai}}</td>
                  <td>
                    <span data-toggle="tooltip" data-original-title="Lihat Detail">
                      <a href="{{route('rapelgaji.detail', $key->id_rapel)}}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                    </span>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".select2").select2();
    });
  </script>
  <script>
  $("#table_list").DataTable();

  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
          });
  </script>
  <script type="text/javascript">
    function toggle(pilih) {
    checkboxes = document.getElementsByName('idpegawai[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = pilih.checked;
    }
  }
  </script>

@stop
