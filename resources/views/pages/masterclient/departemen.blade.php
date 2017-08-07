@extends('layouts.master')

@section('title')
  <title>Tambah Departemen Cabang Client</title>
@stop

@section('breadcrumb')
  <h1>
    Departemen Cabang
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('masterclient.index')}}"> Master Client</a></li>
    <li><a href="{{ route('masterclient.cabang', $CabangClient->id) }}"> Cabang Client</a></li>
    <li class="active">Departemen Cabang</li>
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

      <div class="row">
        <div class="col-md-12">
        @if (session('tambah'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>	<i class="icon fa fa-check"></i> Sukses!</h4>
            {{ session('tambah') }}
          </div>
        @endif
        @if (session('ubah'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>	<i class="icon fa fa-check"></i> Sukses!</h4>
            {{ session('ubah') }}
          </div>
        @endif
        </div>

        @if (session('level') == 1)
        <div class="col-md-5">
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">
                @if(isset($DepartemenEdit))
                  Ubah Data Departemen Cabang Client
                @else
                  Tambah Departemen Cabang : {!! $CabangClient->nama_cabang !!}
                @endif</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body" style="display: block;">
              <div class="row">
                <div class="col-md-12">
                  @if(isset($DepartemenEdit))
                    {!! Form::model($DepartemenCabang, ['method' => 'post', 'url' => ['departemen', $DepartemenEdit->id], 'class' => 'form-horizontal']) !!}
                  @else
                    <form class="form-horizontal" method="post" action="{{ route('departemen.store') }}">
                  @endif
                    {!! csrf_field() !!}
                    <div class="box-body">
                      <div class="form-group {{ $errors->has('kode_departemen') ? 'has-error' : '' }}">
                        <label class="col-sm-3 control-label">Kode Departemen</label>
                        <div class="col-sm-9">
                          <input type="text" name="kode_departemen" class="form-control" placeholder="Kode Departemen" maxlength="5" @if(isset($DepartemenEdit))
                            value="{{ $DepartemenEdit->kode_departemen}}" readonly=""
                          @else
                            value="{{ 'DEP'.$AutoNumber }}" readonly=""
                          @endif
                          >
                          @if($errors->has('kode_departemen'))
                            <span class="help-block">
                              <strong>{{ $errors->first('kode_departemen')}}
                              </strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="form-group {{ $errors->has('nama_departemen') ? 'has-error' : '' }}">
                        <label class="col-sm-3 control-label">Nama Departemen</label>
                        <div class="col-sm-9">
                          <input type="text" name="nama_departemen" class="form-control" placeholder="Nama Departemen" maxlength="45" @if(isset($DepartemenEdit))
                            value="{{ $DepartemenEdit->nama_departemen}}"
                          @else
                            value="{{ old('nama_departemen') }}"
                          @endif>
                          @if($errors->has('nama_departemen'))
                            <span class="help-block">
                              <strong>{{ $errors->first('nama_departemen')}}
                              </stron>
                            </span>
                          @endif
                        </div>
                      </div>
                      <input type="hidden" name="id_cabang" class="form-control" value="{!! $CabangClient->id !!}">
                    </div>
                    <div class="box-footer">
                      @if(isset($DepartemenEdit))
                        <button type="submit" class="btn btn-success pull-right" style="margin-left:5px;">Simpan Perubahan</button>
                      @else
                        <button type="submit" class="btn btn-success pull-right" style="margin-left:5px;">Simpan</button>
                        <button type="reset" class="btn btn-danger pull-left">Reset Formulir</button>
                      @endif

                    </div>
                  </form>
                </div>
              </div>
            </div>
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

        <div class="col-md-7">
          <div class="box box-primary box-solid">
                <div class="box-header">
                  <h3 class="box-title">Tabel Departemen Cabang : {!! $CabangClient->nama_cabang !!}</h3>
                </div>
                <div class="box-body">
                  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                      <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                        <th>No</th>
                        <th rowspan="1" colspan="1" >Kode Departemen</th>
                        <th rowspan="1" colspan="1" >Nama Departemen</th>
                        <th rowspan="1" colspan="1" >Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $page = $DepartemenCabang->currentPage();
                      if($page == 1){
                        $no = 1;
                      }elseif($page == 2){
                        $no = 11;
                      }elseif($page == 3){
                        $no = 21;
                      }elseif($page == 4){
                        $no = 31;
                      }
                      ?>
                    @foreach($DepartemenCabang as $Departemen)
                    <tr>
                      <td>{!! $no++ !!}</td>
                      <td class="">{!! $Departemen->kode_departemen !!}</td>
                      <td class="">{!! $Departemen->nama_departemen !!}</td>
                      <td>
                        <a href="{{ route('departemen.edit', $Departemen->id)}}" class="btn btn-xs btn-warning {{ $onlyHrd }}" data-toggle='tooltip' title='Edit Data'><i class="fa fa-edit"></i></a>
                      </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Menampilkan 1 s/d {!! $DepartemenCabang->count() !!} dari {!! $DepartemenCabang->total() !!} Departemen</div>
                </div>
                <div class="col-sm-7">
                  <div class="dataTables_paginate paging_simple_numbers pull-right" id="example1_paginate">
                    {!! $DepartemenCabang->render() !!}
                  </div>
                </div>
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


@stop
