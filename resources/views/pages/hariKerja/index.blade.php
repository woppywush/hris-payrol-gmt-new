@extends('layouts.master')

@section('title')
    <title>Kelola Hari Kerja</title>
@stop

@section('breadcrumb')
  <h1>
    Input Hari Kerja Pegawai
    <small>Kelola Payroll</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Hari Kerja Pegawai</li>
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
          <h3 class="box-title">Input Hari Kerja Ke Client</h3>
        </div>
        <div class="box-body">
          <div class="col-md-12" style="margin-bottom:20px;">
          </div>
          <div class="col-md-12">

            <form class="form-horizontal" method="post" action="{{route('harikerja.store')}}"> <!-- START FORM -->
              {!! csrf_field() !!}
              <div class="form-group">
                <label class="col-sm-4 control-label">Hari Kerja</label>
                <div class="col-sm-4">
                  <select class="form-control" name="workday" required="true">
                    <option value="">-- PILIH --</option>
                    <option value="52" id="haker52">[5-2] -- 5 Hari Kerja, 2 Hari Libur</option>
                    <option value="61" id="haker61">[6-1] -- 6 Hari Kerja, 1 Hari Libur</option>
                    <option value="70" id="haker70">[7-0] -- 7 Hari Kerja, 0 Hari Libur</option>
                  </select>
                </div>
              </div>
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Pilih Pegawai</h3>
              </div>
                <div class="box-body">
                  <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
                        <thead>
                          <tr role="row">
                            <th>
                              <span data-toggle="tooltip" data-placement="right" title="Pilih Semua">
                                <input type="checkbox" onClick="toggle(this)"  class="flat-red"/>
                              </span>
                            </th>
                            <th>Nama Client</th>
                            <th>Nama Cabang</th>
                            <th>Alamat</th>
                            <th style="width:10%">Total Pegawai</th>
                          </tr>
                           <tbody>
                           @if(isset($getlistClientNew))
                              @foreach($getlistClientNew as $key)
                              <tr>
                                <td><input type="checkbox" class="minimal" name="idcabangclient[]" value="{{$key->id}}"></td>
                                <td>{{ $key->nama_client }}</td>
                                <td>{{ $key->nama_cabang }}</td>
                                <td>{{ $key->alamat_cabang }}</td>
                                <td style="text-align:center"><span class="badge bg-orange">{{$key->total_pegawai}}</span></td>
                              </tr>
                              @endforeach
                          @endif
                          </tbody>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                    <div class="box-footer">
                      <div class="col-sm-6">
                        <button type="submit" class="btn btn-success pull-right">Simpan</button>
                      </div>
                    </div>
                </form> <!-- END FORM -->
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
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".select2").select2();
    });
  </script>
  <script type="text/javascript">
    function toggle(pilih) {
    checkboxes = document.getElementsByName('idcabangclient[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = pilih.checked;
    }
  }
  </script>
  <script>
  $("#example1").DataTable();

  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
          });
  </script>
@stop
