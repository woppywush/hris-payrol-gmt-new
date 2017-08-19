@extends('layouts.master')

@section('title')
    <title>Kelola Batch THR</title>
    <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Batch THR
    <small>Kelola Batch THR</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Perhitungan THR</li>
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
              <h4 class="modal-title">Hapus Batch THR</h4>
            </div>
            <div class="modal-body">
              <p>Seluruh data yang telah di generate untuk batch ini akan terhapus, apakah anda yakin untuk menghapusnya?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
              <a href="#" class="btn btn-danger" id="sethapus">Ya, saya yakin.</a>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="myModalEdit" role="dialog">
        <div class="modal-dialog">
          <form class="form-horizontal" action="#" method="post" id="formedit">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Batch THR</h4>
              </div>
              <div class="modal-body">
                <div class="form-group ">
                  <label class="col-sm-3 control-label">Periode Penggajian</label>
                  <div class="col-sm-9">
                    {{ csrf_field() }}
                    <select class="form-control" name="periode">
                      <option value="">-- Pilih --</option>
                      @foreach ($getperiode as $key)
                        <option value="{{$key->id}}" id="periode{{$key->tanggal}}">Per Tanggal {{$key->tanggal}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-3 control-label">Bulan Hitung THR</label>
                  <div class="col-sm-9">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input class="form-control pull-right bulanthr" type="text" name="bulan_awal" placeholder="Dari" id="edit_bulan_awal">
                    </div>
                    <br>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input class="form-control pull-right bulanthr" type="text" name="bulan_akhir" placeholder="Sampai" id="edit_bulan_akhir">
                    </div>
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
      <form class="form-horizontal" action="{{route('thr.store')}}" method="post">
          {{csrf_field()}}
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Formulir Batch THR</h3>
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
             <label class="col-md-3 control-label">Bulan Hitung THR</label>
              <div class="col-sm-9">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right bulanthr" type="text" name="bulan_awal" placeholder="Dari">
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
                  <input class="form-control pull-right bulanthr" type="text" name="bulan_akhir" placeholder="Sampai">
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
    </div>
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
          <h3 class="box-title">Seluruh Batch THR</h3>
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
                      <th>Bulan Awal</th>
                      <th>Bulan Akhir</th>
                      <th>Jumlah Bulan</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $no=1;
                    @endphp
                    @foreach ($getbatchthr as $key)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>Per Tanggal {{ $key->periode->tanggal }}</td>
                        <td>
                          @php
                            setlocale(LC_TIME, 'id_ID.utf8');
                            \Carbon\Carbon::setLocale('id');

                            $bulan_awal = explode('-', $key->bulan_awal);
                            $dt = \Carbon\Carbon::create($bulan_awal[1], $bulan_awal[0], 1);

                            $month = $dt->formatLocalized('%B');
                            echo $month.", ".$bulan_awal[1];
                          @endphp
                        </td>
                        <td>
                          @php
                          $bulan_akhir = explode('-', $key->bulan_akhir);
                          $dt = \Carbon\Carbon::create($bulan_akhir[1], $bulan_akhir[0], 1);

                          $month = $dt->formatLocalized('%B');
                          echo $month.", ".$bulan_akhir[1];
                          @endphp
                        </td>
                        <td>{{ $key->diff_bulan }} Bulan</td>
                        <td>
                          @if ($key->flag_processed==0)
                            <span class="badge">Belum Diproses</span>
                          @else
                            <span class="badge bg-green">Sudah Diproses</span>
                          @endif
                        </td>
                        <td>
                          <span data-toggle="tooltip" title="Lihat Detail">
                            <a href="{{route('thr.detail', $key->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="#" class="btn btn-xs btn-warning {{$key->flag_processed==1 ? 'disabled' : ''}} edit" data-toggle="modal" data-target="#myModalEdit" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a href="#" class="btn btn-xs btn-danger {{$key->flag_processed==1 ? 'disabled' : ''}} hapus" data-toggle="modal" data-target="#myModal" data-value="{{$key->id}}"><i class="fa fa-remove"></i></a>
                          </span>
                        </td>
                      </tr>
                    @endforeach
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
                  {{-- {{ $getbatch->links() }} --}}
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
  <script type="text/javascript">
    $(document).ready(function(){
        $(".bulanthr").datepicker({
          format: "mm-yyyy",
          startView: "months",
          minViewMode: "months",
          autoclose: true,
        });

        $('.hapus').click(function(){
          var a = $(this).data('value');
          $('#sethapus').attr('href', "{{url('/')}}/batch-thr/destroy/"+a);
        });

        $('.edit').click(function(){
          var a = $(this).data('value');
          $.ajax({
            url: "{{url('/')}}/batch-thr/bind/"+a,
            success: function(data) {
              $('#periode' + data.tanggal).attr('selected', true);
              $('#edit_bulan_awal').val(data.bulan_awal);
              $('#edit_bulan_akhir').val(data.bulan_akhir);
              $('#formedit').attr('action', "{{url('/')}}/batch-thr/update/" + a);
            }
          })
        });
    });
  </script>
@stop
