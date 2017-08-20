@extends('layouts.master')

@section('title')
    <title>Kelola Komponen Gaji</title>
@stop

@section('breadcrumb')
  <h1>
    Rapel Gaji
    <small>Perhitungan Rapel Gaji</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Perhitungan Rapel Gaji</li>
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
      $(".alert-warning").fadeTo(500, 0).slideUp(500, function(){
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
      @endif
      @if(Session::has('gagal'))
      <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-times"></i> Perhatian!</h4>
        <p>{{ Session::get('gagal') }}</p>
      </div>
      @endif
    </div>
    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Pilih Client Area</h3>
        </div>
        <div class="box-body">
          <div class="col-md-12" style="margin-bottom:20px;">
          </div>
          <div class="col-md-12">
              <form class="form-horizontal" method="post" action="{{route('rapelgaji.getclienthistory')}}">
                {!! csrf_field() !!}
                <div class="callout callout-warning">
                  <label class="col-sm-2 control-label">Client</label>
                  <div class="col-sm-8">
                    <select name="id_cabang_client" class="form-control select2" style="width: 100%;" required="true">
                      @if (!isset($getClientByID))
                        <option selected="selected"></option>
                      @endif
                      @foreach($getClient as $client)
                        <optgroup label="{{ $client->nama_client}}">
                          @foreach($getCabang as $key)
                            @if($client->id == $key->id_client)
                              <option value="{{ $key->id }}"
                                  @if (isset($getClientByID) && $getClientByID[0]->id_cabang == $key->id)
                                    selected
                                  @endif
                                >{{ $key->kode_cabang }} - {{ $key->nama_cabang }}</option>
                            @endif
                          @endforeach
                        </optgroup>
                      @endforeach
                    </select>
                  </div>
                   <button type="submit" class="btn btn-success">Proses</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">List Histori Penyesuaian Gaji</h3>
          </div>
          <div class="box-body">
            @if (isset($historydata))
              <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                  <tr role="row">
                    <th>#</th>
                    <th>Client</th>
                    <th>Cabang Client</th>
                    <th>Tanggal Penyesuaian</th>
                    <th>Nilai Gaji</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($historydata)!=0)
                    @foreach ($historydata as $key)
                      <tr>
                        <td>#</td>
                        <td>
                          @foreach ($getClient as $gc)
                            @if ($gc->id == $key->id_client)
                              {{$gc->nama_client}}
                              @php
                              break;
                              @endphp
                            @endif
                          @endforeach
                        </td>
                        <td>
                          @foreach ($getCabang as $gcc)
                            @if ($gcc->id == $key->id_cabang_client)
                              {{$gcc->nama_cabang}}
                              @php
                              break;
                              @endphp
                            @endif
                          @endforeach
                        </td>
                        <td>{{$key->tanggal_penyesuaian}}</td>
                        <td>{{$key->nilai}}</td>
                        <td>
                          @if ($key->flag_rapel_gaji==0)
                            <span class="badge bg-yellow">Belum</span>
                          @else
                            <span class="badge bg-green">Sudah</span>
                          @endif
                        </td>
                        <td>
                          @if ($key->flag_rapel_gaji==0)
                            <a href="{{route('rapelgaji.proses', $key->id)}}" class="btn btn-xs btn-warning">Generate Batch</a>
                          @else
                            <button type="button" name="button" class="btn btn-xs btn-success" disabled="">Generate Batch</button>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="7">
                        <span class="text-muted"><i><center>Data tidak tersedia</center></i></span>
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            @else
              <span class="text-muted">
                Silahkan lakukan proses pemilihan client di kolom atas.
              </span>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Timeline Perubahan Gaji</h3>
          </div>
          <div class="box-body">
            @if (isset($historydata))
              @if (count($historydata)!=0)
                <div class="row" style="margin-top:10px;">
                  <div class="col-md-12">
                    <ul class="timeline">
                      <li class="time-label" style="margin-left:8px;">
                        <span class="bg-red">
                          &nbsp;&nbsp;Start&nbsp;&nbsp;
                        </span>
                      </li>
                      @foreach ($historydataasc as $key)
                        <li>
                          <i class="fa fa-money bg-blue"></i>
                          <div class="timeline-item" style="background:#ddf2ff;">
                            <div class="timeline-body">
                              @php
                                $exp = explode('-', $key->tanggal_penyesuaian);
                              @endphp
                              <span class="badge bg-green">{{$exp[0]}}</span> &nbsp;--&nbsp; Rp {{$key->nilai}}
                            </div>
                          </div>
                        </li>
                      @endforeach
                      <li class="time-label" style="margin-left:11px;">
                        <span class="bg-green">
                          &nbsp;&nbsp;End&nbsp;&nbsp;
                        </span>
                      </li>
                    </ul>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              @else
                <div class="row" style="margin-top:10px;">
                  <div class="col-md-12">
                    <ul class="timeline">
                      <li class="time-label" style="margin-left:8px;">
                        <span style="background:#c6c6c6;">
                          &nbsp;&nbsp;Start&nbsp;&nbsp;
                        </span>
                      </li>
                      <li>
                        <i class="fa fa-money" style="background:#c6c6c6;"></i>
                        <div class="timeline-item" style="background:#c6c6c6;">
                          <div class="timeline-body">
                            <i class="text-muted">Data history tidak tersedia.</i>
                          </div>
                        </div>
                      </li>
                      <li class="time-label" style="margin-left:11px;">
                        <span style="background:#c6c6c6;">
                          &nbsp;&nbsp;End&nbsp;&nbsp;
                        </span>
                      </li>
                    </ul>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              @endif
              <span class="text-muted">
                <i>
                  Timeline di generate dari histori perubahan gaji per client area.
                </i>
              </span>
            @else
              <span class="text-muted">
                Silahkan lakukan proses pemilihan client di kolom atas.
              </span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
  {{-- datepicker --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $(".select2").select2();
      $('#tanggal').datepicker({
          autoclose: true,
          todayHighlight: true,
          daysOfWeekDisabled: [0,6],
          format: 'yyyy-mm-dd',
          startView: "date",
          minViewMode: "date"
      });
    });
  </script>

  <script>
    $("#example1").DataTable();

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass: 'iradio_minimal-blue'
            });
  </script>
  <script type="text/javascript">
    function toggle(pilih) {
    checkboxes = document.getElementsByName('idpegawai[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = pilih.checked;
    }
  }
  </script>

@stop
