@extends('layouts.master')

@section('title')
    <title>Kelola History Gaji Pokok Pegawai</title>
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Input History Gaji Pokok Pegawai
    <small>Kelola Payroll</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">History Gaji Pokok Pegawai</li>
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
  </div>

  <div class="row">
    <div class="col-md-12">
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">Tambah Data Gaji Pokok Pegawai Client</a></li>
          <li><a href="#tab_2" data-toggle="tab">Lihat Data Gaji Pokok Pegawai Client</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Input History Gaji Pokok Pegawai Ke Client</h3>
              </div>
              <div class="box-body">
                <div class="col-md-12" style="margin-bottom:20px;">
                </div>
                <div class="col-md-12">

                  <form class="form-horizontal" method="post" action="{{route('historygajipokok.store')}}"> <!-- START FORM -->
                    {!! csrf_field() !!}
                    <div class="form-group ">
                      <label class="col-sm-3 control-label">Tahun Periode</label>
                      <div class="col-sm-6">
                      <input type="text" name="periode_tahun" class="form-control" id="periode_tahun" placeholder="Periode Tahun" id="periode_tahun" readonly="true">
                      </div>
                        @if($errors->has('periode_tahun'))
                          <span class="help-block">
                            <strong style="color: red">{{ $errors->first('periode_tahun')}}
                            </strong>
                          </span>
                        @endif
                    </div>
                    <div class="form-group ">
                      <label class="col-sm-3 control-label">Gaji Pokok</label>
                      <div class="col-sm-6">
                      <input type="text" name="gaji_pokok" class="form-control" id="gaji_pokok" placeholder="Nilai" id="gaji_pokok" onkeypress="return isNumber(event)">
                      </div>
                        @if($errors->has('gaji_pokok'))
                          <span class="help-block">
                            <strong style="color: red">{{ $errors->first('gaji_pokok')}}
                            </strong>
                          </span>
                        @endif
                    </div>
                    <div class="form-group ">
                      <label class="col-sm-3 control-label">Keterangan</label>
                      <div class="col-sm-6">
                      <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" id="keterangan">
                      </div>
                       @if($errors->has('keterangan'))
                          <span class="help-block">
                            <strong style="color: red">{{ $errors->first('keterangan')}}
                            </strong>
                          </span>
                        @endif
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
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_2">
            <div class="box box-primary box-solid">
              <div class="box-header">
                <h3 class="box-title">History Gaji Pokok Pegawai</h3>
              </div>
              <div class="box-body table-responsive">
                <table id="table_histori" class="table table-hover">
                  <thead>
                    <tr>
                      <th>NIP</th>
                      <th>Nama Pegawai</th>
                      <th>Nomor Telepon</th>
                      <th>Tahun Periode</th>
                      <th>Gaji Pokok</th>
                      <th>Tanggal Pembuatan</th>
                      <th>Client</th>
                      <th>Cabang</th>
                      <th>Status Pegawai</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                </table>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
  <script type="text/javascript">
    $(function() {
        $('#table_histori').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables.data.history') !!}',
            column: [
              {data: '0', name: 'nip_pegawai'},
              {data: '1', name: 'nama_pegawai'},
              {data: '2', name: 'no_telp_pegawai'},
              {data: '3', name: 'periode_tahun'},
              {data: '4', name: 'gaji_pokok'},
              {data: '5', name: 'created_at'},
              {data: '6', name: 'nama_client'},
              {data: '7', name: 'nama_cabang'},
              {data: '8', name: 'status_pegawai'}
            ]
        });
      });
  </script>

    
  <script type="text/javascript">
    $(document).ready(function(){
      $(".select2").select2();
    });
  </script>
  <script type="text/javascript">
    var d = new Date();
    var n = d.getFullYear();
    $('#periode_tahun').attr('value', n);

    function toggle(pilih) {
    checkboxes = document.getElementsByName('idcabangclient[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = pilih.checked;
      }
    }
  </script>
  <script type="text/javascript">
  $(document).ready(function() {
    // Setup - add a text input to each footer cell
      $('#table_histori tfoot th').each( function () {
          var title = $(this).text();
          $(this).html( '<input type="text" class="form-control" style="border:1px solid #3598DC; width:100%" />' );
      } );

      // DataTable
      var table = $('#table_histori').DataTable();

      // Apply the search
      table.columns().every( function () {
          var that = this;

          $( 'input', this.footer() ).on( 'keyup change', function () {
              if ( that.search() !== this.value ) {
                  that
                      .search( this.value )
                      .draw();
              }
          } );
      } );
  } );
  </script>
  <script type="text/javascript">
    function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
      }
      return true;
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
