@extends('layouts.master')

@section('title')
    <title>Kelola Komponen Gaji Tetap</title>
@stop

@section('breadcrumb')
  <h1>
    Komponen Gaji Tetap
    <small>Kelola Komponen Gaji Tetap</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('komgajitetap.index')}}"> Komponen Gaji Tetap</a></li>
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
            <h4 class="modal-title">Hapus Komponen Gaji Tetap</h4>
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
      <form class="form-horizontal" action="{{route('komgajitetapclient.update')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Komponen Gaji Tetap Client</h4>
          </div>
          <div class="modal-body">
            <div class="form-group ">
              <label class="col-sm-3 control-label">Komponen Gaji</label>
              <div class="col-sm-9">
              <input type="hidden" name="id" class="form-control" id="id">
              <input type="hidden" name="id_komponen_client_edit" class="form-control" id="id_komponen_client_edit">
              <input type="text" name="nama_komponen_client_edit" class="form-control" placeholder="Nama Komponen" id="nama_komponen_client_edit" readonly="true" value="{{$getdataKomponenGaji->nama_komponen}}">
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Cabang Client</label>
              <div class="col-sm-9">
              <input type="hidden" name="id_cabang_client_edit" class="form-control" id="id_cabang_client_edit">
              <select class="form-control" disabled="true">
                <option selected="selected"></option>
                  @foreach($getcabangclient as $key)
                    <option value="{{ $key->id }}" id="cab{{$key->id}}">{{ $key->nama_cabang }} - {{ $key->alamat_cabang }}</option>
                  @endforeach
              </select>
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Nilai</label>
              <div class="col-sm-9">
              <input type="text" name="komgaj_tetap_dibayarkan_edit" class="form-control" id="komgaj_tetap_dibayarkan_edit" placeholder="Nilai" onkeypress="return isNumber(event)">
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Keterangan</label>
              <div class="col-sm-9">
              <input type="text" name="keterangan_edit" class="form-control" placeholder="Keterangan" id="keterangan_edit">
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

      <div class="col-md-8">
        <div class="box box-primary box-solid">
          <div class="box-header">
            <h3 style="text-align: center;"><b>Deskripsi Komponen Tetap</b></h3>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <tr>
                      <td style="color: white; width: 23%"><b>Nama Komponen</b></td>
                      <td>: &nbsp;&nbsp;{{$getdataKomponenGaji->nama_komponen}}</td>
                    </tr>
                    <tr>
                      <td style="color: white; width: 23%"><b>Tipe Komponen</b></td>
                      @if($getdataKomponenGaji->tipe_komponen=="D")
                        <td>: &nbsp;&nbsp;<span class="badge bg-green">Penerimaan</span></td>
                      @else
                        <td>: &nbsp;&nbsp;<span class="badge bg-red">Potongan</span></td>
                      @endif
                    </tr>
                    <tr>
                      <td style="color: white; width: 23%"><b>Periode Perhitungan</b></td>
                      <td>: &nbsp;&nbsp;{{$getdataKomponenGaji->periode_perhitungan}}</td>
                    </tr>
                    <tr><td></td><td></td></tr>
                  </table>

                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="info-box bg-yellow">
          <span class="info-box-icon"><i class="fa fa-building-o"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Jumlah Cabang Yang Tersedia</span>
            <span class="info-box-number"><?php echo $getcountCabang[0]->jmlcabnotexist ?></span>

            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
              <span class="progress-description">
                <i>Yang tersedia pada data cabang</i>
              </span>
          </div>
        </div>
        <div class="info-box bg-green">
          <span class="info-box-icon"><i class="fa fa-building"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Jumlah Cabang Sudah diisikan</span>
            <span class="info-box-number">{{$getcountCabangKom}}</span>

            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
                <span class="progress-description">
                  <i>Yang tersedia pada data cabang</i>
                </span>
          </div>
        </div>
      </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Formulir Tambah Komponen Gaji Tetap Pada Client</h3>
        </div>
        <form class="form-horizontal" action="{{route('komgajitetapclient.store')}}" method="post">
          {{csrf_field()}}
          <div class="box-body">
            <div class="form-group ">
              <label class="col-sm-3 control-label">Komponen Gaji</label>
              <div class="col-sm-6">
              <input type="hidden" name="id_komponen_client" class="form-control" id="id_komponen_client" value="{{$getdataKomponenGaji->id}}">
              <input type="text" name="nama_komponen_client" class="form-control" placeholder="Nama Komponen" id="nama_komponen_client" readonly="true" value="{{$getdataKomponenGaji->nama_komponen}}">
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label">Nilai</label>
              <div class="col-sm-6">
              <input type="text" name="komgaj_tetap_dibayarkan" class="form-control" id="komgaj_tetap_dibayarkan" placeholder="Nilai" id="komgaj_tetap_dibayarkan" onkeypress="return isNumber(event)">
              </div>
                @if($errors->has('komgaj_tetap_dibayarkan'))
                  <span class="help-block">
                    <strong style="color: red">{{ $errors->first('komgaj_tetap_dibayarkan')}}
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
            <div class="row">
              <div class="col-sm-12">

              <div class="col-md-6">
               <div class="box box-primary box-solid">
                  <div class="box-header">
                    <h3 class="box-title">Seluruh Client yang tersedia</h3>
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
                          </tr>
                           <tbody>
                           @if(isset($getlistClientNew))
                              @foreach($getlistClientNew as $key)
                              <tr>
                                <td><input type="checkbox" class="minimal" name="idcabangclient[]" value="{{$key->id}}"></td>
                                <td>{{ $key->nama_client }}</td>
                                <td>{{ $key->nama_cabang }}</td>
                                <td>{{ $key->alamat_cabang }}</td>
                              </tr>
                              @endforeach
                          @endif
                          </tbody>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="box box-primary box-solid">
                  <div class="box-header">
                    <h3 class="box-title">Seluruh Client yang Sudah Diisikan</h3>
                  </div>
                    <div class="box-body">
                        <table class="table table-bordered" id="tabelListClientOld">
                            <tr>
                              <th>No</th>
                              <th>Nama Client</th>
                              <th>Nama Cabang</th>
                              <th>Alamat</th>
                              <th>Nilai</th>
                              <th>Aksi</th>
                            </tr>
                            <tbody>
                             @if(isset($getlistClientOld))
                              @php
                                $pageget = 1;
                              @endphp
                                @foreach($getlistClientOld as $key)
                                <tr>
                                  <td>{{$pageget}}</td>
                                  <td>{{ $key->nama_client }}</td>
                                  <td>{{ $key->nama_cabang }}</td>
                                  <td>{{ $key->alamat_cabang }}</td>
                                  <td>
                                    Rp. {{ number_format($key->komgaj_tetap_dibayarkan,0,',','.') }},-
                                  </td>
                                  <td>
                                    <span data-toggle="tooltip" title="Edit Data">
                                      <a href="" class="btn btn-xs btn-warning edit" data-toggle="modal" data-target="#myModalEdit" data-value="{{$key->id_komponen_gaji_tetap}}"><i class="fa fa-edit"></i></a>
                                    </span>
                                    <span data-toggle="tooltip" title="Hapus Data">
                                      <a href="" class="btn btn-xs btn-danger hapus" data-toggle="modal" data-target="#myModal" data-value="{{$key->id_komponen_gaji_tetap}}/{{$key->id_komponen_gaji}}"><i class="fa fa-remove"></i></a>
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
                  </div>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right btn-sm">Simpan</button>
            <button type="reset" class="btn btn-danger btn-sm">Reset Formulir</button>
          </div>
        </div>
      </form>
      </div>
    </div>


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>

  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>

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
    function toggle(pilih) {
    checkboxes = document.getElementsByName('idcabangclient[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = pilih.checked;
    }
  }
  </script>
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
    $(function(){
       $('a.hapus').click(function(){
        var val = $(this).data('value');
        var strSplit = val.split("/");
        var a = strSplit[0];
        var b = strSplit[1];
          $('#sethapus').attr('href', "{{ url('/') }}/komponen-gaji-tetap-client/delete/"+a+"/"+b);
      });

      $('a.edit').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/komponen-gaji-tetap-client/bind-komponen-gaji-tetap-client/"+a,
          success: function(data){
            //get
            var id = data.id;
            var id_cabang_client_edit = data.id_cabang_client;
            var id_komponen_client_edit = data.id_komponen_gaji;
            var komgaj_tetap_dibayarkan_edit = data.komgaj_tetap_dibayarkan;
            var keterangan_edit = data.keterangan;
            //set
            $('#id').attr('value', id);

            $('option').attr('selected', false);
            $('option#cab'+id_cabang_client_edit).attr('selected', true);
            $(".select2").select2();
            $('#id_cabang_client_edit').attr('value', id_cabang_client_edit);
            $('#id_komponen_client_edit').attr('value', id_komponen_client_edit);
            $('#komgaj_tetap_dibayarkan_edit').attr('value', komgaj_tetap_dibayarkan_edit);
            $('#keterangan_edit').attr('value', keterangan_edit);
          }
        });
      });
    });
  </script>
@stop
