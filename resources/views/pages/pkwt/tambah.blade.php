@extends('layouts.master')

@section('title')
  <title>Tambah Data PKWT</title>
  <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Data PKWT
    <small>Kelola Data PKWT</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Kelola Data PKWT</li>
  </ol>
@stop

@section('content')
  @if(Session::has('message'))
  <script>
    window.setTimeout(function() {
      $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 2000);
  </script>

  <div class="col-md-12">
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        <p>{{ Session::get('message') }}</p>
      </div>
  </div>
  @endif


  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Data PKWT</h3>
        </div>
        <form class="form-horizontal" method="post" action="{{ route('pkwt.store') }}">
          {!! csrf_field() !!}
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">NIP</label>
              <div class="col-sm-9">
                <select name="id_pegawai" class="form-control select2" style="width: 100%;">
                  <option selected="selected"></option>
                  @foreach($getnip as $key)
                    <option value="{{ $key->id }}" {{ old('id_pegawai') == $key->id ? 'selected=""' : ''}}>{{ $key->nip }} - {{ $key->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Client</label>
              <div class="col-sm-9">
                <select name="id_cabang_client" class="form-control select2" style="width: 100%;">
                  <option selected="selected"></option>
                  @foreach($getclient as $client)
                    <optgroup label="{{ $client->nama_client}}">
                      @foreach($getcabang as $key)
                        @if($client->id == $key->id_client)
                          <option value="{{ $key->id }}" {{ old('id_cabang_client') == $key->id ? 'selected=""' : ''}}>{{ $key->kode_cabang }} - {{ $key->nama_cabang }}</option>
                        @endif
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Kelompok Jabatan</label>
              <div class="col-sm-9">
                <select name="id_kelompok_jabatan" class="form-control select2" style="width: 100%;">
                  <option selected="selected"></option>
                  @foreach($get_kel_jabatan as $key)
                    <option value="{{ $key->id }}" {{ old('id_kelompok_jabatan') == $key->id ? 'selected=""' : ''}}>{{ $key->nip }} - {{ $key->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal Masuk GMT</label>
              <div class="col-sm-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tanggal_masuk_gmt" class="form-control" id="tanggal_masuk_gmt" value="{{ old('tanggal_masuk_gmt') }}" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal Awal PKWT</label>
              <div class="col-sm-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tanggal_awal_pkwt" class="form-control" id="tanggal_awal_pkwt" value="{{ old('tanggal_awal_pkwt') }}" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal Akhir PKWT</label>
              <div class="col-sm-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tanggal_akhir_pkwt" class="form-control" id="tanggal_akhir_pkwt" value="{{ old('tanggal_akhir_pkwt') }}" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal Kerja Pada Client</label>
              <div class="col-sm-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input readonly type="text" name="tanggal_masuk_client" class="form-control" id="tanggal_masuk_client" value="{{ old('tanggal_masuk_client') }}" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Status Karyawan</label>
              <div class="col-sm-9">
                <select class="form-control" name="status_karyawan_pkwt">
                  <option value="1" {{ old('status_karyawan_pkwt') == 1 ? 'selected=""' : ''}}>Kontrak</option>
                  <option value="2" {{ old('status_karyawan_pkwt') == 2 ? 'selected=""' : ''}}>Freelance</option>
                  <option value="3" {{ old('status_karyawan_pkwt') == 3 ? 'selected=""' : ''}}>Tetap</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Status PKWT</label>
              <div class="col-sm-9">
                <select class="form-control" name="status_pkwt">
                  <option value="1" {{ old('status_pkwt') == 1 ? 'selected=""' : ''}}>Aktif</option>
                  <option value="0" {{ old('status_pkwt') == 0 ? 'selected=""' : ''}}>Tidak Aktif</option>
                </select>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="reset" class="btn btn-danger">Cancel</button>
            <button type="submit" class="btn btn-success pull-right">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>

  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".select2").select2();
    });
  </script>

  <script type="text/javascript">
    $(function(){
      $("#tanggal_awal_pkwt").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        daysOfWeekDisabled: [0,6]
      });
      $("#tanggal_akhir_pkwt").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        daysOfWeekDisabled: [0,6]
      });
      $("#tanggal_masuk_gmt").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        daysOfWeekDisabled: [0,6]
      });

      $('#tanggal_awal_pkwt').change(function(){
        var value = $(this).val();
        $('#tanggal_masuk_client').val(value);
      });
    });
  </script>
@stop
