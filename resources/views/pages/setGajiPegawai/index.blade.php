@extends('layouts.master')

@section('title')
  <title>Set Gaji Pegawai</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Set Gaji Pegawai
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Set Gaji Pegawai</li>
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


  <div class="modal modal-default fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('setgaji.update')}}" method="post">
      {{ csrf_field() }}
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Set Gaji Pegawai</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">NIP Pegawai</label>
              <div class="col-sm-9">
                <input type="hidden" class="form-control" id="id" name="id">
                <input type="text" class="form-control" id="nippegawai" name="nip" readonly="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Pegawai</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="namapegawai" name="nama" readonly="">
              </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Gaji Pokok</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="gajipokok" name="gajipokok" onkeypress="return isNumber(event)">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-success">Simpan Perubahan</a>
          </div>
        </div>
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
      @endif
    </div>

    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="box-title">
            Seluruh Data Pegawai
          </h3>
        </div>
        <div class="box-body">
          <table class="table table-hover" id="tabelpegawai">
            <thead>
              <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Status Kepegawaian</th>
                <th>Gaji Pokok</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>
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

  <script type="text/javascript">
    $(function() {
        $('#tabelpegawai').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('setgaji.getdata') !!}',
            column: [
              {data: 'id', name: 'id'},
              {data: '0', name: 'nip'},
              {data: '1', name: 'name'},
              {data: '2', name: 'no_telp'},
              {data: '3', name: 'nama_jabatan'},
              {data: '5', name: 'status'},
              {data: '6', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#tabelpegawai').DataTable().on('click', 'a.editgaji[data-value]', function () {
          var a = $(this).data('value');
          $.ajax({
            url: "{{ url('/') }}/set-gaji-pegawai/bind-gaji/"+a,
            dataType: 'json',
            success: function(data){
              // get
              var id = data.id;
              var nip = data.nip;
              var nama = data.nama;
              var gaji = data.gaji_pokok;

              // set
              $('#id').attr('value', id);
              $('#nippegawai').attr('value', nip);
              $('#namapegawai').attr('value', nama);
              $('#gajipokok').attr('value', gaji);
            }
          });
        });
      });
  </script>

@stop
