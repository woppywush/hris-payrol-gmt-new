@extends('layouts.master')

@section('title')
    <title>Kelola Komponen Gaji Variabel</title>
@stop

@section('breadcrumb')
  <h1>
    Komponen Gaji Variabel
    <small>Kelola Komponen Gaji Variabel</small>
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
            <h4 class="modal-title">Hapus Komponen Gaji Variabel</h4>
          </div>
          <div class="modal-body">
            <p>Apakah anda yakin untuk menghapus komponen gaji ini?</p>
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
      <form class="form-horizontal" action="{{route('komgaji.update')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Komponen Gaji Variabel</h4>
          </div>
          <div class="modal-body">
            <div class="form-group ">
              <label class="col-sm-3 control-label">Nama Komponen</label>
              <div class="col-sm-9">
              <input type="hidden" name="id" class="form-control" id="id">
              <input type="text" name="nama_komponen_edit" class="form-control" placeholder="Nama Komponen" id="nama_komponen_edit">
                @if($errors->has('nama_komponen_edit'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('nama_komponen_edit')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tipe Komponen</label>
              <div class="col-sm-9">
              <select class="form-control" name="tipe_komponen_edit" id="tipe_komponen_edit">
                <option value="">-- Pilih --</option>
                <option value="D" id="flag_penerimaan_edit">Penerimaan</option>
                <option value="P" id="flag_potongan_edit">Potongan</option>
              </select>
                @if($errors->has('tipe_komponen_edit'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('tipe_komponen_edit')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
             <div class="form-group ">
              <label class="col-sm-3 control-label">Periode Perhitungan</label>
              <div class="col-sm-9">
              <select class="form-control" name="periode_perhitungan_edit" id="periode_perhitungan_edit">
                <option value="">-- Pilih --</option>
                <option value="Bulanan" id="flag_bulanan_edit">Bulanan</option>
                <option value="Harian" id="flag_harian_edit">Harian</option>
                <option value="Jam" id="flag_jam_edit">Jam</option>
                <option value="Shift" id="flag_shift_edit">Shift</option>
              </select>
               @if($errors->has('periode_perhitungan_edit'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('periode_perhitungan_edit')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group " hidden="true">
              <label class="col-sm-3 control-label">Tipe Komponen</label>
              <div class="col-sm-9">
              <select class="form-control" name="tipe_komponen_gaji_edit" id="tipe_komponen_gaji_edit">
                <option value="">-- Pilih --</option>
                <option value="0" id="flag_tetap_edit">Tetap</option>
                <option value="1" id="flag_variabel_edit">Variabel</option>
              </select>
                @if($errors->has('tipe_komponen_gaji_edit'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('tipe_komponen_gaji_edit')}}
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
      <!-- Horizontal Form -->
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Formulir Tambah Komponen Gaji Variabel</h3>
        </div>
        <form class="form-horizontal" action="{{route('komgaji.store')}}" method="post">
          {{csrf_field()}}
        <div class="box-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Komponen</label>
              <div class="col-sm-9">
              <input type="text" name="nama_komponen" class="form-control" value="{{ old('nama_komponen') }}" placeholder="Nama Komponen">
                @if($errors->has('nama_komponen'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('nama_komponen')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tipe Perhitungan</label>
              <div class="col-sm-9">
              <select class="form-control" name="tipe_komponen">
                <option value="">-- Pilih --</option>
                <option value="D">Penerimaan</option>
                <option value="P">Potongan</option>
              </select>
                @if($errors->has('tipe_komponen'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('tipe_komponen')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Periode Perhitungan</label>
              <div class="col-sm-9">
              <select class="form-control" name="periode_perhitungan">
                <option value="">-- Pilih --</option>
                <option value="Bulanan">Bulanan</option>
                <option value="Harian">Harian</option>
                <option value="Jam">Jam</option>
                <option value="Shift">Shift</option>
              </select>
              @if($errors->has('periode_perhitungan'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('periode_perhitungan')}}
                    </strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group " hidden="true">
              <label class="col-sm-3 control-label">Tipe Komponen</label>
                <div class="col-md-9 ">
                  <select class="form-control" name="tipe_komponen_gaji">
                    <option value="">-- Pilih --</option>
                    <option value="0">Tetap</option>
                    <option value="1">Variable</option>
                  </select>
                @if($errors->has('tipe_komponen_gaji'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('tipe_komponen_gaji')}}
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
          <h3 class="box-title">Seluruh Komponen Gaji Variabel</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead>
                    <tr role="row">
                      <th>No</th>
                      <th>Nama</th>
                      <th>Periode</th>
                      <th>Tipe</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($getkomponen)!=0)
                      @php
                        $pageget;
                        if($getkomponen->currentPage()==1)
                          $pageget = 1;
                        else
                          $pageget = (($getkomponen->currentPage() - 1) * $getkomponen->perPage())+1;
                      @endphp
                      @foreach ($getkomponen as $key)
                        <tr>
                          <td>
                            {{$pageget}}
                          </td>
                          <td>
                            {{$key->nama_komponen}}
                          </td>
                          <td>
                            {{$key->periode_perhitungan}}
                          </td>
                          <td>
                            @if ($key->tipe_komponen=="D")
                              <span class="badge bg-green">Penerimaan</span>
                            @elseif ($key->tipe_komponen=="P")
                              <span class="badge bg-red">Potongan</span>
                            @endif
                          </td>
                          <td>
                            @if ($key->tipe_komponen_gaji==0)
                              <span class="badge bg-navy">Tetap</span>
                            @else
                              <span class="badge bg-purple">Variable</span>
                            @endif
                          </td>
                          <td>
                          @if($key->id == '9991' || $key->id == '9992' || $key->id == '9993')
                            <span data-toggle="tooltip" title="Tidak Dapat Dirubah">
                              <a href="" class="btn btn-xs bg-navy disabled"><i class="fa fa-warning"></i></a>
                            </span>
                          @else
                            <span data-toggle="tooltip" title="Edit Data">
                              <a href="" class="btn btn-xs btn-warning edit" data-toggle="modal" data-target="#myModalEdit" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
                            </span>
                            <span data-toggle="tooltip" title="Hapus Data">
                              <a href="" class="btn btn-xs btn-danger hapus" data-toggle="modal" data-target="#myModal" data-value="{{$key->id}}"><i class="fa fa-remove"></i></a>
                            </span>
                          @endif
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
                {{-- <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Menampilkan 1 s/d {!! $getkomponen->count() !!}  dari {!! count($getkomponen) !!} Data</div> --}}
              </div>
              <div class="col-sm-7">
                <div class="pull-right">
                  {{ $getkomponen->links() }}
                </div>
              </div>
            </div>
          </div>
          </div><!-- /.box-body -->
        </div>
      </div><!--/.col -->
      </div>   <!-- /.row -->


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

  <script type="text/javascript">
  @if ($errors->has('nama_komponen_edit') || $errors->has('tipe_komponen_edit') || $errors->has('periode_perhitungan_edit') || $errors->has('tipe_komponen_gaji_edit'))
    $('#myModalEdit').modal('show');
  @endif
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
          $('#sethapus').attr('href', "{{ url('/') }}/komponen-gaji/delete/"+a);
      });

      $('a.edit').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/komponen-gaji/bind-gaji/"+a,
          success: function(data){
            //get
            var id = data.id;
            var nama_komponen_edit = data.nama_komponen;
            var tipe_komponen_edit = data.tipe_komponen;
            var periode_perhitungan_edit = data.periode_perhitungan;
            var tipe_komponen_gaji_edit = data.tipe_komponen_gaji;
            //set
            $('#id').attr('value', id);
            $('#nama_komponen_edit').attr('value', nama_komponen_edit);

            if (tipe_komponen_edit=="D") {
              $('#flag_penerimaan_edit').attr('selected', true);
            } else {
              $('#flag_potongan_edit').attr('selected', true);
            }

            if (periode_perhitungan_edit=="Bulanan") {
              $('#flag_bulanan_edit').attr('selected', true);
            } else if (periode_perhitungan_edit=="Harian") {
              $('#flag_harian_edit').attr('selected', true);
            } else if (periode_perhitungan_edit=="Jam") {
              $('#flag_jam_edit').attr('selected', true);
            } else if (periode_perhitungan_edit=="Shift") {
              $('#flag_shift_edit').attr('selected', true);
            }

            if (tipe_komponen_gaji_edit=="0") {
              $('#flag_tetap_edit').attr('selected', true);
            } else {
              $('#flag_variabel_edit').attr('selected', true);
            }
          }
        });
      });
    });
  </script>
@stop
