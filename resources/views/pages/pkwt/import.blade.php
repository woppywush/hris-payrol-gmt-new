@extends('layouts.master')

@section('title')
  <title>Import Data PKWT</title>
  <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  <style>
  .datepicker{z-index:1151 !important;}
  </style>
@stop

@section('breadcrumb')
  <h1>
    Import Data PKWT
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Import Data PKWT</li>
  </ol>
@stop

@section('content')
  <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
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
      @elseif(Session::has('error'))
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Error!</h4>
          <p>{{ Session::get('error') }}</p>
        </div>
      @endif
    </div>
    <div class="col-md-6">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Download Template</h3>
        </div>
          <div class="box-body">
            <div class="form-group">
              <a href="{{ route('pkwtGetTemplate') }}"><button class="btn btn-block btn-success btn-lg">Download Template</button></a>
            </div>
          </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Upload Data PKWT</h3>
        </div>
        <div class="box-body">
          <div class="col-md-12" style="margin-bottom:20px;">
            <form role="form" method="post" action="{{ route('pkwtProses') }}" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="callout callout-warning">
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="importPkwt" accept=".xlsx" required="">
                </div>
              </div>
               <p class="help-block" style="color: red"><i><b>*Harap Import Data Sesuai Dengan Template.</b></i></p>
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Proses Upload</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  @if(isset($gagal))
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h2>Data Gagal Import</h2>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-hover" id="tabelpegawai">
            <thead>
              <tr>
                <th>NIP Pegawai</th>
                <th>Cabang Client</th>
                <th>NIP Supervisi</th>
                <th>Tanggal Masuk GMT</th>
                <th>Tanggal Masuk Client</th>
                <th>Tanggal Awal PKWT</th>
                <th>Tanggal Akhir PKWT</th>
                <th>Status Karyawan PKWT</th>
                <th>Status PKWT</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($gagal as $key)
                <td>{{$key->id_pegawai}}</td>
                <td>{{$key->id_cabang_client}}</td>
                <td>{{$key->id_kelompok_jabatan}}</td>
                <td>{{$key->tanggal_masuk_gmt}}</td>
                <td>{{$key->tanggal_masuk_client}}</td>
                <td>{{$key->tanggal_awal_pkwt}}</td>
                <td>{{$key->tanggal_akhir_pkwt}}</td>
                <td>{{$key->status_karyawan_pkwt}}</td>
                <td>{{$key->status_pkwt = 1 ? 'Aktif' : 'Tidak Aktif'}}</td>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
  @endif


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

  <script type="text/javascript">
    $(function() {
        $('#tabelpegawai').DataTable();
      });
  </script>
@stop
