@extends('layouts.master')

@section('title')
    <title>Kelola Hari Libur</title>
@stop

@section('breadcrumb')
  <h1>
    Hari Libur
    <small>Kelola Hari Libur</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
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
      $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 5000);
  </script>

    <!-- Modal Hapus -->
    <div class="modal modal-default fade" id="myModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Hapus Hari Libur</h4>
          </div>
          <div class="modal-body">
            <p>Apakah anda yakin untuk menghapus hari libur ini?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
            <a href="#" class="btn btn-danger" id="sethapus">Ya, saya yakin.</a>
          </div>
        </div>

      </div>
    </div>

    <!-- Modal Update-->
    <div class="modal fade" id="myModalEdit" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('hari.libur.update')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Hari Libur</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Hari Libur</label>
              <div class="col-sm-9">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right datepicker1" id="libur" type="text" name="libur" placeholder="Hari Libur">
                </div>
                </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Keterangan</label>
              <div class="col-sm-9">
              <input type="hidden" name="id" class="form-control" id="id">
              <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" id="keterangan">
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Status</label>
              <div class="col-sm-9">
              <select class="form-control" name="status" id="status">
                <option>-- Pilih --</option>
                <option value="0" id="flag_aktif">Aktif</option>
                <option value="1" id="flag_non_aktif">Tidak Aktif</option>
              </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-success">Simpan Perubahan</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <!--column -->
    <div class="col-md-12">
      @if(Session::has('message'))
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
          <p>{{ Session::get('message') }}</p>
        </div>
      @endif
      @if(Session::has('messagefail'))
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Oops, terjadi kesalahan!</h4>
          <p>{{ Session::get('messagefail') }}</p>
        </div>
      @endif
    </div>
    <div class="col-md-5">
      <form class="form-horizontal" action="{{route('hari.libur.store')}}" method="post">
          {{csrf_field()}}
      <!-- Horizontal Form -->
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Formulir Tambah Hari Libur</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Hari Libur</label>
              <div class="col-sm-9">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right datepicker1" type="text" name="libur" placeholder="Hari Libur">
                </div>
                 @if($errors->has('libur'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('libur')}}
                    </strong>
                  </span>
                @endif
                </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Keterangan</label>
              <div class="col-sm-9">
              <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
               @if($errors->has('keterangan'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('keterangan')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Status</label>
              <div class="col-sm-9">
              <select class="form-control" name="status">
                <option value="">-- Pilih --</option>
                <option value="0">Aktif</option>
                <option value="1">Tidak Aktif</option>
              </select>
               @if($errors->has('status'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('status')}}
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
    </div><!--/.col -->

    <div class="col-md-7">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="box-title">Seluruh Hari Libur</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead>
                    <tr role="row">
                      <th>No</th>
                      <th>Hari Libur</th>
                      <th>Keterangan</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($getharilibur)!=0)
                      @php
                        $pageget;
                        if($getharilibur->currentPage()==1)
                          $pageget = 1;
                        else
                          $pageget = (($getharilibur->currentPage() - 1) * $getharilibur->perPage())+1;
                      @endphp
                      @foreach ($getharilibur as $key)
                        <tr>
                          <td>
                            {{$pageget}}
                          </td>
                          <td>
                            {{ \Carbon\Carbon::parse($key->libur)->format('d-M-y')}}
                          </td>
                          <td>
                           {{$key->keterangan}}
                          </td>
                          <td>
                            @if ($key->status=="0")
                              <span class="badge bg-green">Aktif</span>
                            @elseif ($key->status=="1")
                              <span class="badge bg-red">Tidak Aktif</span>
                            @endif
                          </td>
                          <td>
                            <span data-toggle="tooltip" title="Edit Data">
                              <a href="" class="btn btn-xs btn-warning edit" data-toggle="modal" data-target="#myModalEdit" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
                            </span>
                            <span data-toggle="tooltip" title="Hapus Data">
                              <a href="" class="btn btn-xs btn-danger hapus" data-toggle="modal" data-target="#myModal" data-value="{{$key->id}}"><i class="fa fa-remove"></i></a>
                            </span>
                          </td>
                        </tr>
                        @php
                          $pageget++;
                        @endphp
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-5">
                {{-- <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Menampilkan 1 s/d {!! $getharilibur->count() !!}  dari {!! count($getharilibur) !!} Data</div> --}}
              </div>
              <div class="col-sm-7">
                <div class="pull-right">
                  {{ $getharilibur->links() }}
                </div>
              </div>
            </div>
          </div>
          </div><!-- /.box-body -->
        </div>
      </div><!--/.col -->


  <!-- jQuery 2.1.4 -->
  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>
  {{-- datepicker --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>


  <script type="text/javascript">
  $('.datepicker1').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    daysOfWeekDisabled: [0,6]
  });
  </script>
  <script type="text/javascript">
    $('#myModalEdit').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#myModal').on('hidden.bs.modal', function () {
     location.reload();
    });
  </script>

  <script type="text/javascript">
    $(function(){
       $('a.hapus').click(function(){
        var a = $(this).data('value');
          $('#sethapus').attr('href', "{{ url('/') }}/hari-libur/delete/"+a);
      });

      $('a.edit').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/hari-libur/bind-hari-libur/"+a,
          success: function(data){
            //get
            var id = data.id;
            var libur = data.libur;
            var keterangan = data.keterangan;
            var status = data.status;
            //set
            $('#id').attr('value', id);
            $('#libur').attr('value', libur);
            $('#keterangan').attr('value', keterangan);

            if (status=="0") {
              $('#flag_aktif').attr('selected', true);
            } else {
              $('#flag_non_aktif').attr('selected', true);
            }
          }
        });
      });
    });
  </script>
@stop
