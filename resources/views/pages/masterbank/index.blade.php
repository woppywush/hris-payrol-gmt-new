@extends('layouts.master')

@section('title')
  <title>Tambah Data Bank</title>
@stop

@section('breadcrumb')
  <h1>
    Data Bank
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"> Master Bank</li>
  </ol>
@stop

@section('content')
  @if (session('level') == 1)
  <script>
    window.setTimeout(function() {
      $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 1500);
  </script>
  <script>
    window.setTimeout(function() {
      $(".alert-warning").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 1500);
  </script>

  <div class="modal modal-default fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Bank</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data bank ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="{{url('masterjabatan/hapusjabatan/1')}}" class="btn btn-primary" id="set">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>
  @endif

  <div class="row">
    @if(Session::has('message'))
    <div class="col-md-12">
      <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        <p>{{ Session::get('messagefail') }}</p>
      </div>
    </div>
    @endif
    @if (session('tambah'))
    <div class="col-md-12">
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>	<i class="icon fa fa-check"></i> Sukses!</h4>
        {{ session('tambah') }}
      </div>
    </div>
    @endif
    @if (session('ubah'))
    <div class="col-md-12">
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>	<i class="icon fa fa-check"></i> Sukses!</h4>
        {{ session('ubah') }}
      </div>
    </div>
    @endif

    @if (session('level') == 1)
    <div class="col-md-5">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">
            @if(isset($BankEdit))
              Ubah Data Bank
            @else
              Tambah Data Bank
            @endif
            </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"></button>
          </div>
        </div>
        <div class="box-body" style="display: block;">
          <div class="row">
            <div class="col-md-12">
              @if(isset($BankEdit))
                <form class="form-horizontal" method="post" action="{{ route('masterbank.edit') }}">
        			@else
        			  <form class="form-horizontal" method="post" action="{{ route('masterbank.store') }}">
        			@endif
                {!! csrf_field() !!}
                <div class="box-body">
                  <div class="form-group {{ $errors->has('nama_bank') ? 'has-error' : '' }}">
                    <label class="col-sm-3 control-label">Nama Bank</label>
                    <div class="col-sm-9">
                      <input type="text" name="nama_bank" class="form-control" placeholder="Nama Bank" maxlength="40" @if(isset($BankEdit)) value="{{$BankEdit->nama_bank}}" @else value="{{ old('nama_bank') }}" @endif >
                      @if($errors->has('nama_bank'))
                      <span class="help-block">
                        <strong>{{ $errors->first('nama_bank')}}
                        </strong>
                      </span>
                      @endif
                    </div>
                  </div>
                  @if (isset($BankEdit))
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
                      <input type="hidden" name="id" value="{{ $BankEdit->id }}">
                      <label>
                        <input type="checkbox" class="flat" name="flag_status" @if($BankEdit->flag_status == 1) checked="" @endif/>
                      </label>
                    </div>
                  </div>
                  @endif
                </div>
                <div class="box-footer">
                  @if(isset($BankEdit))
          			  <button type="submit" class="btn btn-success pull-right">Simpan Perubahan</button>
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
            <h3 class="box-title">Data Bank</h3>
          </div>
          <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
              <div class="row">
                <div class="col-sm-12">
                  <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                        <th>No</th>
                        <th>Nama Bank</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  @if($getBank->isEmpty())
                    <tr>
                      <td colspan="4" class="text-muted" style="text-align:center;"><i>Data bank tidak tersedia.</i></td>
                    </tr>
                  @else
                    <?php
                      $pageget;
                      if($getBank->currentPage()==1)
                        $pageget = 1;
                      else
                        $pageget = (($getBank->currentPage() - 1) * $getBank->perPage())+1;
                    ?>
                    @foreach($getBank as $bank)
                    <tr>
                      <td>{{ $pageget }}</td>
                      <td class="">{!! $bank->nama_bank !!}</td>
                      <td class="">
                        @if($bank->flag_status == '1')
                            <small class="label bg-green">Aktif</small>
                        @else
                          <span class="label bg-red">Tidak Aktif</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('masterbank.ubah', array('id' => $bank->id)) }}" class="btn btn-xs btn-warning {{ $onlyHrd }}"  data-toggle='tooltip' title='Edit Data'><i class="fa fa-edit" alt="Ubah"></i></a>
                        <span data-toggle="tooltip" title="Hapus Data">
                        <a href="" class="btn btn-xs btn-danger hapus {{ $onlyHrd }}" data-toggle="modal" data-target="#myModal" data-value="{{$bank->id}}"><i class="fa fa-remove"></i></a>
                      </span>
                      </td>
                    </tr>
                    <?php $pageget++; ?>
                    @endforeach
                  @endif
                    </tbody>
                  </table>
                </div>
              </div>

            <div class="row">
              <div class="col-sm-5">
                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Menampilkan 1 s/d {!! $getBank->count() !!}  dari {!! $getBank->total() !!} Bank</div>
              </div>
              <div class="col-sm-7">
                <div class="pull-right">
                  {{ $getBank->links() }}
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

  @if (session('level') == 1)
  <script type="text/javascript">
    $(function(){
      $('a.hapus').click(function(){
        var a = $(this).data('value');
        $('#set').attr('href', "{{ url('/') }}/masterbank/hapusbank/"+a);
      });
    });
  </script>
  @endif


@stop
