@extends('layouts.master')

@section('title')
    <title>Kelola Pengecualian Client</title>
@stop

@section('breadcrumb')
  <h1>
    Pengecualian
    <small>Kelola Pengecualian Client</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Kelola Pengecualian Client</li>
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

  <div class="callout callout-warning">
     <h4>Pemberitahuan!</h4>
     <p>Data ini di input untuk client per area yang mengabaikan hari libur nasional.</p>
   </div>

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
          <h4><i class="icon fa fa-ban"></i> Oops, terjadi kesalahan!</h4>
          <p>{{ Session::get('messagefail') }}</p>
        </div>
      @endif
    </div>
  </div>

  <div class="row">
    <form class="form-horizontal" action="{{route('pengecualian.client.store')}}" method="post">
      {{csrf_field()}}
    <div class="col-sm-6">
     <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="box-title">Seluruh Client Yang Tersedia</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
              <thead>
                <tr role="row">
                  <th>
                    <span data-toggle="tooltip" data-placement="right" title="Pilih Semua">
                      <input type="checkbox" onClick="togglenew(this)"  class="flat-red"/>
                    </span>
                  </th>
                  <th>Nama Client</th>
                  <th>Nama Cabang</th>
                  <th>Alamat</th>
                </tr>
                 <tbody>
                 @if(isset($getpengecualianclientnew))
                    @foreach($getpengecualianclientnew as $key)
                    <tr>
                      <td><input type="checkbox" class="minimal" name="idcabangclientnew[]" value="{{$key->id}}"></td>
                      <td>{{ $key->nama_client }}</td>
                      <td>{{ $key->nama_cabang }}</td>
                      <td>{{ $key->alamat_cabang }}</td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
              </thead>
            </table>
            <hr/>
            <button type="submit" class="btn btn-success btn-block">Simpan</button>
          </div>
        </div>
      </div>
    </form>

    <form class="form-horizontal" action="{{route('pengecualian.client.delete')}}" method="post">
      {{csrf_field()}}
      <div class="col-sm-6">
        <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="box-title">Data Seluruh Pengecualian Client</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead>
                    <tr role="row">
                      <th>
                        <span data-toggle="tooltip" data-placement="right" title="Pilih Semua">
                          <input type="checkbox" onClick="toggleold(this)"  class="flat-red"/>
                        </span>
                      </th>
                      <th>Nama Client</th>
                      <th>Nama Cabang</th>
                      <th>Alamat</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(isset($getpengecualianclientold))
                      @if (count($getpengecualianclientold)!=0)
                        @foreach($getpengecualianclientold as $key)
                          <tr>
                            <td style="width:2%"><input type="checkbox" class="minimal" name="idcabangclientold[]" value="{{$key->id}}"></td>
                            <td>{{ $key->nama_client }}</td>
                            <td>{{ $key->nama_cabang }}</td>
                            <td>{{ $key->alamat_cabang }}</td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="4" align="center"><span class="text-muted">Data tidak tersedia.</span></td>
                        </tr>
                      @endif
                   @endif
                  </tbody>
                </table>
                <hr/>
                <button type="submit" class="btn btn-danger btn-block">Hapus</button>
              </div>
            </div>
          </div>
          </div><!-- /.box-body -->
        </div>
      </div><!-- ./col -->
    </form>
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
    function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
      }
      return true;
    }
  </script>
  <script type="text/javascript">
    function togglenew(pilih) {
    checkboxes = document.getElementsByName('idcabangclientnew[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = pilih.checked;
    }
  }
  </script>

  <script type="text/javascript">
    function toggleold(pilih) {
    checkboxes = document.getElementsByName('idcabangclientold[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = pilih.checked;
    }
  }
  </script>

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
          $('#sethapus').attr('href', "{{ url('/') }}/bpjs/delete/"+a);
      });

      $('a.edit').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/bpjs/bind-bpjs/"+a,
          success: function(data){
            //get
            var id = data.id;
            var id_bpjs_edit = data.id_bpjs;
            var keterangan_edit = data.  keterangan;
            var bpjs_dibayarkan_edit = data.bpjs_dibayarkan;
            var id_cabang_client_edit = data. id_cabang_client;

            //set
            $('#id').attr('value', id);
            if (id_bpjs_edit == "9991") {
              document.getElementById('lbleditbpjs').innerHTML = 'Edit Bpjs Kesehatan';
              lbleditbpjs.style.color = "#DD4B39";
            } else if (id_bpjs_edit == "9992"){
              document.getElementById('lbleditbpjs').innerHTML = 'Edit Bpjs Ketenagakerjaan';
              lbleditbpjs.style.color = "#F39C12";
            } else if (id_bpjs_edit == "9993"){
              document.getElementById('lbleditbpjs').innerHTML = 'Edit Bpjs Pensiun';
              lbleditbpjs.style.color = "#00A65A";
            }

            $('option').attr('selected', false);
            $('#id_cabang_client_edit').prop("disabled", true);
            $('option#cel'+id_cabang_client_edit).attr('selected', true);
            $('#id_bpjs_edit').prop("disabled", true);
            $('option#tipebpjs'+id_bpjs_edit).attr('selected', true);
            $(".select2").select2();

            $('#keterangan_edit').attr('value', keterangan_edit);
            $('#bpjs_dibayarkan_edit').attr('value', bpjs_dibayarkan_edit);
          }
        });
      });
    });
  </script>
@stop
