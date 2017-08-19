@extends('layouts.master')

@section('title')
  <title>Import Data Pegawai</title>
  <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  <style>
  .datepicker{z-index:1151 !important;}
  </style>
@stop

@section('breadcrumb')
  <h1>
    Import Data Pegawai
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Import Data Pegawai</li>
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
              <a href="{{ route('importPegawai.getTemplate') }}"><button class="btn btn-block btn-success btn-lg">Download Template</button></a>
            </div>
          </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Upload Data Pegawai</h3>
        </div>
        <div class="box-body">
          <div class="col-md-12" style="margin-bottom:20px;">
            <form role="form" method="post" action="{{ route('importPegawai.proses') }}" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="callout callout-warning">
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="importPegawai" accept=".xlsx" required="">
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


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
@stop
