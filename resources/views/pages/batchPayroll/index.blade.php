@extends('layouts.master')

@section('title')
    <title>Kelola Batch Payroll</title>
    <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Batch Payroll
    <small>Kelola Batch Payroll</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Kelola Batch Payroll</li>
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
      }, 2000);
    </script>

    @if (session('level') == 2)
    <div class="modal modal-default fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Hapus Batch Payroll</h4>
          </div>
          <div class="modal-body">
            <p>Seluruh data penggajian pegawai yang telah di generate akan terhapus, apakah anda yakin untuk menghapus Batch Payroll ini?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
            <a href="#" class="btn btn-danger" id="sethapus">Ya, saya yakin.</a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-default fade" id="myModalEdit" role="dialog">
    <div class="modal-dialog">
     <form class="form-horizontal" action="{{route('batchpayroll.update')}}" method="post">
      {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Batch Payroll</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="col-md-3 control-label">Periode Penggajian</label>
              <div class="col-sm-9">
              <input type="hidden" name="id" class="form-control" id="id">
              <select class="form-control" name="periode_edit">
                <option value="">-- Pilih --</option>
                @foreach ($getperiode as $key)
                  <option value="{{$key->id}}" id="editperiode{{$key->id}}">Per Tanggal {{$key->tanggal}}</option>
                @endforeach
              </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Tanggal Cut Off Absen</label>
              <div class="col-sm-9">
               <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right datepicker1" type="text" name="tanggal_awal_edit" id="tanggal_awal_edit" placeholder="Dari">
                </div>
                <br>
               <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right datepicker1" type="text" name="tanggal_akhir_edit" id="tanggal_akhir_edit" placeholder="Sampai">
                </div>
                 @if($errors->has('periode'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('periode')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-success">Simpan Perubahan</a>
          </div>
        </div>
      </form>
      </div>
    </div>
  @endif

  <div class="row">
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
          <h4><i class="icon fa fa-close"></i> Oops, terjadi kesalahan!</h4>
          <p>{{ Session::get('messagefail') }}</p>
        </div>
      @endif
    </div>

    @if (session('level') == 2)
    <div class="col-md-5">
      <form class="form-horizontal" action="{{route('batchpayroll.store')}}" method="post">
          {{csrf_field()}}
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Formulir Batch Payroll</h3>
        </div>
          <div class="box-body">
            <div class="form-group">
              <label class="col-md-3 control-label">Periode Penggajian</label>
              <div class="col-sm-9">
              <select class="form-control" name="periode">
                <option value="">-- Pilih --</option>
                @foreach ($getperiode as $key)
                  <option value="{{$key->id}}">Per Tanggal {{$key->tanggal}}</option>
                @endforeach
              </select>
                @if($errors->has('periode'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('periode')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
             <label class="col-md-3 control-label">Tanggal Cut Off Absen</label>
              <div class="col-sm-9">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right datepicker1" type="text" name="tanggal_awal" id="tanggal_awal" placeholder="Dari">
                </div>
                @if($errors->has('tanggal_awal'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('tanggal_awal')}}
                    </strong>
                  </span>
                @endif
                <br>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right datepicker1" type="text" name="tanggal_akhir" id="tanggal_akhir" placeholder="Sampai">
                </div>
                @if($errors->has('tanggal_akhir'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('tanggal_akhir')}}
                    </strong>
                  </span>
                @endif
                </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right btn-sm">Generate Batch</button>
            <button type="reset" class="btn btn-danger btn-sm">Reset Formulir</button>
          </div>
        </div>
      </form>
    </div><!--/.col -->
    @endif

    @php
      if (session('level') != 2) {
        $onlyPayroll = 'disabled';
      }else {
        $onlyPayroll = '';
      }
    @endphp

    <div class="col-md-7">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="box-title">Seluruh Batch Payroll</h3>
        </div>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead>
                    <tr role="row">
                      <th>No</th>
                      <th>Periode Gaji</th>
                      <th>Tanggal Awal</th>
                      <th>Tanggal Akhir</th>
                      <th>Status Proses</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($getbatch)!=0)
                      @php
                        $pageget;
                        if($getbatch->currentPage()==1)
                          $pageget = 1;
                        else
                          $pageget = (($getbatch->currentPage() - 1) * $getbatch->perPage())+1;
                      @endphp
                      @foreach ($getbatch as $key)
                        <tr>
                          <td>{{$pageget}}</td>
                          <td>Per Tanggal {{$key->tanggal}}</td>
                          <td>
                            @php
                              $date = explode("-", $key->tanggal_proses);
                            @endphp
                            {{$date[2]}}-{{$date[1]}}-{{$date[0]}}
                          </td>
                          <td>
                            @if($key->tanggal_proses_akhir !=null)
                              @php
                                $date = explode("-", $key->tanggal_proses_akhir);
                              @endphp
                              {{$date[2]}}-{{$date[1]}}-{{$date[0]}}
                            @endif
                          </td>
                          <td>
                            @if ($key->flag_processed==0)
                              <span class="badge">Belum Diproses</span>
                            @else
                              <span class="badge bg-green">Sudah Diproses</span>
                            @endif
                          </td>
                          <td>
                            <span data-toggle="tooltip" title="Lihat Detail">
                              <a href="{{route('batchpayroll.detail', $key->id)}}" class="btn btn-xs btn-primary edit"><i class="fa fa-eye"></i></a>
                            </span>
                            <span data-toggle="tooltip" title="Edit Data">
                              <a href="" class="btn btn-xs btn-warning edit {{ $onlyPayroll }}" data-toggle="modal" data-target="#myModalEdit" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
                            </span>
                            <span data-toggle="tooltip" title="Hapus Data">
                              <a href="" class="btn btn-xs btn-danger hapus {{ $onlyPayroll }}" data-toggle="modal" data-target="#myModal" data-value="{{$key->id}}"><i class="fa fa-remove"></i></a>
                            </span>
                          </td>
                        </tr>
                        @php
                          $pageget++;
                        @endphp
                      @endforeach
                    @else
                      <tr>
                        <td colspan=6 align="center">
                          <i class="text-muted">Data tidak tersedia.</i>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-5">
              </div>
              <div class="col-sm-7">
                <div class="pull-right">
                  {{ $getbatch->links() }}
                </div>
              </div>
            </div>
          </div>
          </div><!-- /.box-body -->
        </div>
      </div><!--/.col -->


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $("#tanggal_awal").datepicker({
            todayBtn:  1,
            autoclose: true,
        }).on('changeDate', function (selected) {
          $("#tanggal_akhir").prop('disabled', false);
          $("#tanggal_akhir").val("");
            var minDate = new Date(selected.date.valueOf());
            $("#tanggal_akhir").datepicker('setStartDate', minDate);
        });

        $("#tanggal_akhir").datepicker()
            .on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
            });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
        $("#tanggal_awal_edit").datepicker({
            todayBtn:  1,
            autoclose: true,
        }).on('changeDate', function (selected) {
          $("#tanggal_akhir_edit").prop('disabled', false);
          $("#tanggal_akhir_edit").val("");
            var minDate = new Date(selected.date.valueOf());
            $("#tanggal_akhir_edit").datepicker('setStartDate', minDate);
        });

        $("#tanggal_akhir_edit").datepicker()
            .on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
            });
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
          $('#sethapus').attr('href', "{{ url('/') }}/batch-payroll/delete/"+a);
      });

      $('a.edit').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/batch-payroll/bind-batch-payroll/"+a,
          success: function(data){
            //get
            var id = data.id;
            var periode_edit = data.id_periode_gaji;
            var tanggal_awal_edit = data.tanggal_proses;
            var tanggal_akhir_edit = data.tanggal_proses_akhir;
            //set
            $('#id').attr('value', id);
            $('#editperiode'+periode_edit).attr('selected', true);
            $('#tanggal_awal_edit').attr('value', tanggal_awal_edit);
            $('#tanggal_akhir_edit').attr('value', tanggal_akhir_edit);
          }
        });
      });
    });
  </script>

   <script type="text/javascript">
  $('.datepicker1').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    daysOfWeekDisabled: [0,6]
  });
  </script>
@stop
