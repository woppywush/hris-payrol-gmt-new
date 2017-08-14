@extends('layouts.master')

@section('title')
    <title>Kelola Periode Gaji</title>
    <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Periode Pemrosesan Gaji
    <small>Kelola Periode Gaji</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Kelola Periode Gaji</li>
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

    <div class="modal modal-default fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Hapus Periode Gaji</h4>
          </div>
          <div class="modal-body">
            <p>Apakah anda yakin untuk menghapus periode gaji ini?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
            <a href="#" class="btn btn-danger" id="set">Ya, saya yakin.</a>
          </div>
        </div>
      </div>
    </div>

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
    <div class="col-md-5">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Formulir Tambah Periode Gaji</h3>
        </div>
        <form class="form-horizontal" action="{{route('periodegaji.store')}}" method="post">
          {{csrf_field()}}
        <div class="box-body">
            <div class="form-group ">
            <label class="col-sm-3 control-label">Per Tanggal</label>
              <div class="col-sm-9">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="tanggal" class="form-control" placeholder="Tanggal Periode Penggajian" id="tanggal">
              </div>
                @if($errors->has('tanggal'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('tanggal')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Keterangan</label>
              <div class="col-sm-9">
                <textarea name="keterangan" rows="4" cols="40" class="form-control"></textarea>
                @if($errors->has('keterangan'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('keterangan')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
        </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right btn-sm">Simpan</button>
            <button type="reset" class="btn btn-danger btn-sm">Reset Formulir</button>
          </div>
        </div>
      </form>
    </div>

    <div class="col-md-7">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="box-title">Seluruh Periode Penggajian</h3>
        </div>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              @if (count($getperiode)!=0)
                @foreach ($getperiode as $key)
                  <div class="col-md-6">
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <h3>Periode: {{$key->tanggal}}</h3>
                        <p>Pemrosesan Gaji Per Tanggal {{$key->tanggal}} Tiap Bulan</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <a href="{{route('periodegaji.detail', $key->id)}}" class="small-box-footer">
                        Lihat detail pegawai di periode ini &nbsp; <i class="fa fa-arrow-circle-right"></i>
                      </a>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
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
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>


  <script type="text/javascript">
    $(function(){

      $('#tanggal').datepicker({
          autoclose: true,
          todayHighlight: true,
          daysOfWeekDisabled: [0,6],
          format: 'dd',
          startView: "date",
          minViewMode: "date"
      });
    });
  </script>
@stop
