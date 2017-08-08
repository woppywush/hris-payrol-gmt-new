@extends('layouts.master')

@section('title')
  <title>Lihat Detail PKWT</title>
  <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  <style>
  .datepicker{z-index:1151 !important;}
  </style>
@stop

@section('breadcrumb')
  <h1>
    Detail PKWT
    <small>Lihat Detail PKWT</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('pkwt.index') }}"><i class="fa fa-document"></i> PKWT</a></li>
    <li class="active">Kelola Data PKWT</li>
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
    <script>
      window.setTimeout(function() {
        $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
      }, 2000);
    </script>

    {{-- Modal for Terminate--}}
    <div class="modal modal-default fade" id="modalterminatepkwt" role="dialog">
      <div class="modal-dialog">
        <form class="form-horizontal" action="{{ route('pkwt.terminate')}}" method="post">
          {!! csrf_field() !!}
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Terminate PKWT</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label class="col-sm-3 control-label">Alasan Terminate</label>
                <div class="col-sm-9">
                  <textarea name="keterangan" class="form-control" cols="35" rows="10">PKWT ini telah di-Terminate dengan alasan : </textarea>
                  <input type="hidden" name="id_pkwt" class="form-control" id="id_pkwt" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Tidak</button>
              <button type="submit" class="btn btn-success">Terminate</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal modal-default fade" id="modaleditpkwt" role="dialog">
      <div class="modal-dialog">
        <form class="form-horizontal" action="{{ route('pkwt.edit')}} " method="post">
          {!! csrf_field() !!}
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Data PKWT</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label class="col-sm-3 control-label">Kelompok Jabatan</label>
                <div class="col-sm-9">
                  <input type="hidden" name="id_pkwt_change" class="form-control" id="id_pkwt_change" required>
                  <select name="id_kelompok_jabatan" class="form-control" style="width: 100%;">
                    <option value=""></option>
                    @foreach($get_kel_jabatan as $key)
                      <option value="{{$key->id}}" id="editkeljab{{$key->id}}">{{$key->nama}}</option>
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
                    <input type="text" name="tanggal_masuk_gmt" class="form-control" id="tanggal_masuk_gmt" value="" required>
                    <input type="hidden" name="nip" class="form-control" value="{{$getnip[0]->nip}}" required>
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
                    <input type="text" name="tanggal_awal_pkwt" class="form-control" id="tanggal_awal_pkwt" value="" required>
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
                    <input type="text" name="tanggal_akhir_pkwt" class="form-control" id="tanggal_akhir_pkwt" value="" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Tanggal Bekerja di Client</label>
                <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="tanggal_masuk_client" class="form-control" id="tanggal_masuk_client" value="" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Status Karyawan</label>
                <div class="col-sm-9">
                  <select class="form-control" name="status_karyawan_pkwt">
                    <option>-- Pilih --</option>
                    <option value="1" id="status_karyawan_kontrak">Kontrak</option>
                    <option value="2" id="status_karyawan_freelance">Freelance</option>
                    <option value="3" id="status_karyawan_tetap">Tetap</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Status PWKT</label>
                <div class="col-sm-9">
                  <select class="form-control" name="status_pkwt">
                    <option>-- Pilih --</option>
                    <option value="1" id="status_pkwt_aktif">Aktif</option>
                    <option value="0" id="status_pkwt_tidakaktif">Tidak Aktif</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
              <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
          </div>
        </form>
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
      @elseif(Session::has('terminate'))
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-close"></i> Berhasil!</h4>
          <p>{{ Session::get('terminate') }}</p>
        </div>
      @endif
    </div>
    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Detail PKWT</h3>
        </div>

        <div class="box-body">
          <div class="col-md-12" style="margin-bottom:20px;">
            <table style="font-size:18px;">
              <tr>
                <td width="80px"><b>NIP</b></td>
                <td>:</td>
                <td style="padding-left:10px;">{{ $getnip[0]->nip }}</td>
              </tr>
              <tr>
                <td><b>Nama</b></td>
                <td>:</td>
                <td style="padding-left:10px;">{{ $getnip[0]->nama }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Histori PKWT</h3>
              </div>
              <div class="box-body">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>Departemen/Kota</th>
                      <th>Tanggal Bekerja di Client</th>
                      <th>Tanggal Awal PKWT</th>
                      <th>Tanggal Akhir PKWT</th>
                      <th>Kelompok Jabatan</th>
                      <th>Status Karyawan</th>
                      <th>Keterangan</th>
                      <th>Aksi</th>
                    </tr>

                    @foreach($getpkwt as $key)
                      <tr>
                        <td>{{$key->nama_client}} - {{$key->nama_cabang}}</td>
                        <td>{{$key->tanggal_masuk_client}}</td>
                        <td>{{$key->tanggal_awal_pkwt}}</td>
                        <td>{{$key->tanggal_akhir_pkwt}}</td>
                        <td>{{$key->nama}}</td>
                        <td>
                          @if($key->status_karyawan_pkwt==1)
                            Kontrak
                          @elseif($key->status_karyawan_pkwt==2)
                            Freelance
                          @elseif($key->status_karyawan_pkwt==3)
                            Tetap
                          @endif
                        </td>
                        <td>
                          <?php
                            if ($key->flag_terminate == '0') {
                              echo "<span class='label bg-red'>Terminate</span>";
                            } else {
                              $date1=date_create($key->tanggal_akhir_pkwt);
                              $date2=date_create(gmdate("Y-m-d", time()+60*60*7));
                              $diff=date_diff($date2,$date1);
                              $sym = substr($diff->format("%R%a"), 0, 1);
                              $days = substr($diff->format("%R%a"), 1);
                              if($days==0)
                              {
                                echo "<span class='label bg-yellow'>Expired Hari Ini</span>";
                              }
                              elseif($sym=="+" && $days <= 30)
                              {
                                echo "<span class='label bg-yellow'>Expired Dalam ".$days." Hari</span>";
                              }
                              elseif($sym=="+" && $days > 30)
                              {
                                echo "<span class='label bg-green'>PKWT Aktif</span>";
                              }
                              elseif($sym=="-")
                              {
                                echo "<span class='label bg-red'>Telah Expired</span>";
                              }
                            }
                          ?>
                        </td>
                        <td>
                          @if($key->status_pkwt == '1')
                            <span data-toggle="tooltip" title="Edit Data">
                              <a href="#" data-value="{{$key->id}}" class="btn btn-xs btn-warning edit_pkwt" data-toggle="modal" data-target="#modaleditpkwt"><i class="fa fa-edit"></i></a>
                            </span>
                            <span data-toggle="tooltip" title="Terminate">
                              <a href="#" data-value="{{$key->id}}" class="btn btn-xs btn-danger terminate_pkwt" data-toggle="modal" data-target="#modalterminatepkwt"><i class="fa fa-power-off"></i></a>
                            </span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>

  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".select2").select2();
    });
  </script>
  <script type="text/javascript">
    $('#modaleditpkwt').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#modalterminatepkwt').on('hidden.bs.modal', function () {
     location.reload();
    });
  </script>

  <script type="text/javascript">
    $('.terminate_pkwt').click(function(){
      var a = $(this).data('value');
      $.ajax({
        url: "{{ url('/')}}/pkwt/edit/"+a,
        dataType: 'json',
        success: function(data){
          var id_pkwt = data.id;
          //set
          $('#id_pkwt').attr('value', id_pkwt);
        }
      });
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
      $("#tanggal_masuk_client").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        daysOfWeekDisabled: [0,6]
      });

      $('.edit_pkwt').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/pkwt/edit/"+a,
          dataType: 'json',
          success: function(data){
            var id_pkwt = data.id;
            var id_kelompok_jabatan = data.id_kelompok_jabatan;
            var tanggal_masuk_gmt = data.tanggal_masuk_gmt;
            var tanggal_masuk_client = data.tanggal_masuk_client;
            var tanggal_awal_pkwt = data.tanggal_awal_pkwt;
            var tanggal_akhir_pkwt = data.tanggal_akhir_pkwt;
            var status_karyawan_pkwt = data.status_karyawan_pkwt;
            var status_pkwt = data.status_pkwt;

            // set
            $('#id_pkwt_change').attr('value', id_pkwt);
            $('#editkeljab'+id_kelompok_jabatan).attr('selected', true);
            $('#tanggal_masuk_gmt').attr('value', tanggal_masuk_gmt);
            $('#tanggal_masuk_client').attr('value', tanggal_masuk_client);
            $('#tanggal_awal_pkwt').attr('value', tanggal_awal_pkwt);
            $('#tanggal_akhir_pkwt').attr('value', tanggal_akhir_pkwt);

            // alert(status_pkwt);
            if(status_pkwt=="1")
            {
              $('#status_pkwt_aktif').attr('selected', true);
            }
            else if(status_pkwt=="0")
            {
              $('#status_pkwt_tidakaktif').attr('selected', true);
            }

            if(status_karyawan_pkwt==1)
            {
              $('#status_karyawan_kontrak').attr('selected', true);
            }
            else if(status_karyawan_pkwt==2)
            {
              $('#status_karyawan_freelance').attr('selected', true);
            }
            else if(status_karyawan_pkwt==3)
            {
              $('#status_karyawan_freelance').attr('selected', true);
            }
          }
        });
      });
    });
  </script>
@stop
