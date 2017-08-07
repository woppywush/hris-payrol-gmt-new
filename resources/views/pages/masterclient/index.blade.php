@extends('layouts.master')

@section('title')
  <title>Master Client</title>
@stop

@section('breadcrumb')
  <h1>
    Master Client
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
@stop

@section('content')
  @if (session('level') == 1)
  <div class="callout callout-warning">
    <a style="text-decoration:none" href="{{url('masterclient/create')}}" class="btn btn-primary btn-sm"><i class="fa fa-building-o"></i>  Tambah Client</a>
  </div>
  @endif

  <div class="row">
    <script>
      window.setTimeout(function() {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
      }, 2000);
    </script>
    @if (session('tambah'))
    <div class="col-md-12">
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>	<i class="icon fa fa-check"></i> Sukses!</h4>
        {{ session('tambah') }}
      </div>
    </div>
    @endif
    @if (session('update'))
    <div class="col-md-12">
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>	<i class="icon fa fa-check"></i> Sukses!</h4>
        {{ session('update') }}
      </div>
    </div>
    @endif

    @php
      if (session('level') != 1) {
        $onlyHrd = 'disabled';
      }else {
        $onlyHrd = '';
      }
    @endphp

    @foreach($getClient as $client)
    <div class="col-md-4">
      <div class="box box-primary box-solid box-widget widget-user-2">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a style="text-decoration:none" href="{{url('masterclient', $client->id).('/edit')}}" class="btn btn-primary btn-sm {{ $onlyHrd }}"><i class="fa fa-building-o"></i> Ubah Client</a>
          </h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Client</label>
              <div class="col-sm-9">
                <input class="form-control" type="text" name="nama_client" placeholder="Nama Client" value="{{ $client->nama_client}}" readonly="true">
              </div>
          </div>
        </div>

        <div class="box-footer no-padding">
          <ul class="nav nav-stacked">
            <li><a href="{{ route('masterclient.cabang', $client->id)}}">Cabang Client <span class="pull-right badge bg-blue">{{ $client->hitungCabang}}</span></a></li>
          </ul>
        </div>
      </div>
    </div>
    @endforeach
    </div>
    @if(!$getClient->isEmpty())
    <div class="row">
      <div style="text-align: center; vertical-align: middle;">
        {{ $getClient->links() }}
      </div>
    </div>
    @endif


  <script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
  <script src="{{ asset('plugins/fastclick/fastclick.min.js') }}"></script>
  <script src="{{ asset('dist/js/app.min.js') }}"></script>
  <script src="{{ asset('/dist/js/pages/dashboard.js') }}"></script>
  <script src="{{ asset('/dist/js/demo.js') }}"></script>


@stop
