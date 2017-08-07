@extends('layouts.master')

@section('title')
  <title>Tambah Data Client</title>
@stop

@section('breadcrumb')
  <h1>
    Master Client
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ url('masterclient')}}"> Master Client</a></li>
    <li class="active">Data Client</li>
  </ol>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
  	   <div class="box box-primary box-solid">
  	      <div class="box-header with-border">
  	         <h3 class="box-title">
        		@if(isset($MasterClient))
        		  Ubah Data Client
        		@else
        		  Data Client
        		@endif
        	  </h3>
        	</div>
  	<!-- form start -->
  	<div class="box-body" style="display: block;">
  		<div class="row">
  			<div class="col-md-12">
  			@if(isset($MasterClient))
  			  {!! Form::model($MasterClient, ['method' => 'PATCH', 'url' => ['masterclient', $MasterClient->id], 'class'=>'form-horizontal']) !!}
  			@else
  			  <form class="form-horizontal" method="post" action="{{ route('masterclient.store') }}">
  			@endif
  			  {!! csrf_field() !!}
  			<div class="box-body">
  			<div class="form-group {{ $errors->has('kode_client') ? 'has-error' : '' }}">
  			  <label class="col-sm-2 control-label">Kode Client</label>
  			  <div class="col-sm-10">
  				<input type="text" name="kode_client" class="form-control" placeholder="Kode Client" maxlength="5"
  				@if(isset($MasterClient))
  				  value="{{$MasterClient->kode_client}}"
  				@else
  				value=<?php echo $data['kodegenerate']?>
  				@endif
          readonly=""
  				>
          @if($errors->has('kode_client'))
  				<span class="help-block">
  				  <strong>{{ $errors->first('kode_client')}}
  				  </strong>
  				</span>
  			  @endif
  			  </div>
  			</div>
  			<div class="form-group {{ $errors->has('nama_client') ? 'has-error' : '' }}">
  			  <label class="col-sm-2 control-label">Nama Client</label>
  			  <div class="col-sm-10">
  				<input type="text" name="nama_client" class="form-control" placeholder="Nama Client" maxlength="20"
  				@if(isset($MasterClient))
  				  value="{{$MasterClient->nama_client}}"
  				@else
  				  value="{{ old('nama_client')}}"
  				@endif
  				>
          @if($errors->has('nama_client'))
  				<span class="help-block">
  				  <strong>{{ $errors->first('nama_client')}}
  				  </strong>
  				</span>
  			  @endif
  			  </div>
  			</div>
  		</div><!-- /.box-body -->
  			<div class="box-footer">
  			@if(isset($MasterClient))
  			  <button type="submit" class="btn btn-success pull-right" style="margin-left:5px;">Simpan Perubahan</button>
  			@else
  			  <button type="submit" class="btn btn-success pull-right" style="margin-left:5px;">Simpan</button>
          <button type="reset" class="btn btn-danger pull-left">Reset Formulir</button>
  			@endif
  			</div><!-- /.box-footer -->
  		</form>
  	</div><!-- /.box -->
  	</div><!--/.col -->
  </div>


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>


@stop
