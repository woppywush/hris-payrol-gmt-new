@extends('layouts.master')

@section('title')
  <title>Detail Batch Payroll</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Detail Batch Payroll
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('batchpayroll.index')}}"> Kelola Batch Payroll</a></li>
    <li class="active">Detail Batch Payroll</li>
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

  @if(Session::has('gagal'))
  <script>
  window.setTimeout(function() {
    $(".alert-danger").fadeTo(1500, 0).slideUp(1500, function(){
      $(this).remove();
    });
  }, 8000);
  </script>

  <div class="col-md-12">
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Gagal!</h4>
        <p>{{ Session::get('gagal') }}</p>
      </div>
  </div>
  @endif

  @if (session('level') == 2)
  <div class="modal modal-default fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width:700px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Set Komponen Gaji</h4>
        </div>
          <div class="modal-body">
            <div class="col-sm-12" style="margin-bottom:10px;">
              <div class="form-group">
                <label class="col-sm-2 control-label">Komponen Gaji</label>
                <div class="col-sm-8">
                  <input type="hidden" name="name" id="idpegawaigaji">
                  <select class="form-control" id="idkomponengaji">
                    <option>-- Pilih --</option>
                    @foreach ($getkomponengaji as $key)
                      <option value="{{$key->id}}">
                        @if ($key->tipe_komponen=="D")
                          [Penerimaan]
                        @else
                          [Potongan]
                        @endif
                        - {{$key->nama_komponen}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-2"></div>
              </div>
            </div>
            <div class="col-sm-12" style="margin-bottom:40px;">
              <div class="form-group">
                <label class="col-sm-2 control-label">Nilai</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="nilaikomponengaji">
                </div>
                <div class="col-sm-2">
                  <button type="button" name="button" id="addkomponentopegawai" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <table class="table table-bordered" id="tabelkomponen">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Komponen Gaji</th>
                  <th>Tipe</th>
                  <th>Perhitungan</th>
                  <th>Nilai</th>
                  <th>Aksi</th>
                </tr>
              </table>
            </div>
          </div>
          <div class="modal-footer"></div>
      </div>
    </div>
  </div>

  <div class="modal modal-default fade" id="myModalSetAbsen" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('detailbatchpayroll.updateforabsen')}}" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Set Absensi</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">NIP Pegawai</label>
              <div class="col-sm-8">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" id="idforabsen" name="id">
                <input type="hidden" class="form-control" name="idperiode" value="{{$idbatch}}">
                <input type="text" class="form-control" id="nipforabsen" name="nip" readonly="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Pegawai</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="namaforabsen" name="nama" readonly="">
              </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Absensi</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="abstain" id="abstainforabsen" placeholder="Alpa">
                  <span class="pull-right" style="font-size:12px;">Alpa</span>
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="sick_leave" id="sickforabsen" placeholder="Sakit">
                  <span class="pull-right" style="font-size:12px;">Sakit</span>
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="permissed_leave" id="permissedforabsen" placeholder="Izin">
                  <span class="pull-right" style="font-size:12px;">Izin</span>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" value="Simpan Perubahan" class="btn btn-success">
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
    </div>
    <div class="col-md-12">
      @if(Session::has('messagefailed'))
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Terjadi Kesalahan!</h4>
          <p>{{ Session::get('messagefailed') }}</p>
        </div>
      @endif
    </div>

    @if ($getbatch->flag_processed==1)
      <div class="col-md-12">
        <div class="box box-warning box-solid">
          <div class="box-header">
            <span><i>Batch ini telah di proses.</i></span>
            <hr style="margin-top:5px;margin-bottom:15px;">
            <strong style="font-size:17px;">Download Laporan :</strong> &nbsp;&nbsp;
            <a href="{{ route('laporan.prosesAll', array('id' => $idbatch) ) }}" class="btn btn-default bg-blue">Laporan All Payroll</a>&nbsp;
            <a href="{{ route('laporan.prosesBank', array('id' => $idbatch)) }}" class="btn btn-default bg-maroon">Laporan Bank Transfer</a>&nbsp;
            {{-- <a href="#" class="btn btn-default bg-purple">Laporan Pembayaran Cash</a>&nbsp; --}}
            <a href="{{ route('laporan.prosesClient', array('id' => $idbatch)) }}" class="btn btn-default bg-green">Laporan Pembayaran Berdasarkan Client</a>&nbsp;
            <a href="{{ route('laporan.prosesSlipGaji', array('id' => $idbatch)) }}" class="btn btn-default bg-red">Cetak Slip Gaji</a>
          </div>
        </div>
      </div>
    @else
      <div class="col-md-12">
        <div class="box box-warning box-solid">
          <div class="box-header">
            <span><i>Batch ini belum di proses.</i></span>
            <hr style="margin-top:5px;margin-bottom:15px;">
            <strong style="font-size:17px;">Download Laporan :</strong> &nbsp;&nbsp;
            <a href="{{ route('laporan.prosesSPV', array('id' => $idbatch)) }}" class="btn btn-default bg-maroon">Cek SPV</a>&nbsp;
          </div>
        </div>
      </div>
    @endif

    @php
      if (session('level') != 2) {
        $onlyPayroll = 'disabled';
      }else {
        $onlyPayroll = '';
      }
    @endphp

    <div class="col-md-12">
      @if ($getbatch->flag_processed==1)
        <div class="box box-default box-solid">
      @else
        <div class="box box-primary box-solid">
      @endif
        <div class="box-header">
          <h3 class="box-title">
            @php
              $date = explode("-", $getbatch->tanggal_proses);
              $date2 = explode("-", $getbatch->tanggal_proses_akhir);
            @endphp
            @if($getbatch->tanggal_proses == null)
              Seluruh Penerima Gaji Untuk Periode Per Tanggal {{$getbatch->tanggal}} &nbsp;&nbsp;|&nbsp;&nbsp; Tanggal Proses : tanggal proses awal kosong s/d {{$date2[2]}}-{{$date2[1]}}-{{$date2[0]}}
            @elseif($getbatch->tanggal_proses_akhir == null)
              Seluruh Penerima Gaji Untuk Periode Per Tanggal {{$getbatch->tanggal}} &nbsp;&nbsp;|&nbsp;&nbsp; Tanggal Proses : {{$date[2]}}-{{$date[1]}}-{{$date[0]}} s/d tanggal proses akhir kosong
            @else
              Seluruh Penerima Gaji Untuk Periode Per Tanggal {{$getbatch->tanggal}} &nbsp;&nbsp;|&nbsp;&nbsp; Tanggal Proses : {{$date[2]}}-{{$date[1]}}-{{$date[0]}} s/d {{$date2[2]}}-{{$date2[1]}}-{{$date2[0]}}
            @endif
          </h3>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-bordered" id="tabelpegawai">
            <thead>
              <tr>
                <th rowspan="2">NIP</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Jabatan</th>
                <th colspan="3">Absensi</th>
                <th rowspan="2">Penerimaan Tetap</th>
                <th rowspan="2">Penerimaan Variable</th>
                <th rowspan="2">Potongan Tetap</th>
                <th rowspan="2">Potongan Variable</th>
                <th rowspan="2">Total</th>
                <th rowspan="2">Aksi</th>
              </tr>
              <tr>
                <th>Hari Normal</th>
                <th>Absen</th>
                <th>Hari Kerja</th>
              </tr>
            </thead>
            <tbody id="bodydata">
              @foreach ($rowdisplay as $key)
                <tr>
                  <td>{{$key['nip']}}</td>
                  <td>{{$key['nama']}}</td>
                  <td>{{$key['jabatan']}}</td>
                  @if ($getbatch->flag_processed==1)
                    <td>
                      <span class="badge">{{$key['harinormal']}}</span>
                    </td>
                    <td>
                      <span class="badge">Alpa: {{$key['abstain']}}</span>
                      <span class="badge">Sakit: {{$key['sick_leave']}}</span>
                      <span class="badge">Izin: {{$key['permissed_leave']}}</span>
                    </td>
                    <td>
                      <span class="badge">{{$key['totalkerja']}}</span>
                    </td>
                  @else
                    <td>
                      <span class="badge bg-navy">{{$key['harinormal']}}</span>
                    </td>
                    <td>
                      <span class="badge bg-red">Alpa: {{$key['abstain']}}</span>
                      <span class="badge bg-green">Sakit: {{$key['sick_leave']}}</span>
                      <span class="badge bg-blue">Izin: {{$key['permissed_leave']}}</span>
                    </td>
                    <td>
                      <span class="badge bg-purple">{{$key['totalkerja']}}</span>
                    </td>
                  @endif
                  <td>{{$key['gajitetap']}}</td>
                  <td>{{$key['gajivariable']}}</td>
                  <td>{{$key['potongantetap']}}</td>
                  <td>{{$key['potonganvariable']}}</td>
                  <td>{{$key['total']}}</td>
                  {{-- <td>{{number_format($key['gajitetap'], '0', ',', '.')}}</td>
                  <td>{{number_format($key['gajivariable'], '0', ',', '.')}}</td>
                  <td>{{number_format($key['potongantetap'], '0', ',', '.')}}</td>
                  <td>{{number_format($key['potonganvariable'], '0', ',', '.')}}</td>
                  <td>{{number_format($key['potonganvariable'], '0', ',', '.')}}</td> --}}
                  @if ($getbatch->flag_processed==1)
                    <td>
                      <span data-toggle="tooltip" title="Batch Telah Diproses">
                        <a href="#" class="btn btn-xs btn-default addkomponen disabled" data-toggle="modal" data-target="#myModal" data-value="{{$key['id']}}">
                          <i class="fa fa-list-ul"></i>
                        </a>
                      </span>
                      <span data-toggle="tooltip" title="Batch Telah Diproses">
                        <a href="#" class="btn btn-xs btn-default editabsen disabled" data-toggle="modal" data-target="#myModalSetAbsen" data-value="{{$key['iddetailbatch']}}">
                          <i class="fa fa-check"></i>
                        </a>
                      </span>
                    </td>
                  @else
                    <td>
                      <span data-toggle="tooltip" title="Set Komponen Gaji">
                        <a href="#" class="btn btn-xs btn-warning addkomponen {{ $onlyPayroll }}" data-toggle="modal" data-target="#myModal" data-value="{{$key['id']}}">
                          <i class="fa fa-list-ul"></i>
                        </a>
                      </span>
                      <span data-toggle="tooltip" title="Set Absensi">
                        <a href="#" class="btn btn-xs btn-success editabsen {{ $onlyPayroll }}" data-toggle="modal" data-target="#myModalSetAbsen" data-value="{{$key['iddetailbatch']}}">
                          <i class="fa fa-check"></i>
                        </a>
                      </span>
                    </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      @if ($getbatch->flag_processed==1)
        <div class="box box-default box-solid">
      @else
        <div class="box box-primary box-solid">
      @endif
        <div class="box-header">
          <h3 class="box-title"><strong>Summary</strong></h3>
          <hr style="margin-top:5px;margin-bottom:8px;">
          <ul>
            <table>
              <tr>
                <td width="180px;">
                  <li>Periode Penggajian
                </td>
                <td id="summary_periode">
                  :&nbsp;&nbsp; Per Tanggal {{$summary['periode_gaji']}}
                </td>
              </tr>
              <tr>
                <td>
                  <li>Tanggal Awal Cut Off Absen
                </td>
                <td id="summary_cutoff_awal">
                  :&nbsp;&nbsp; {{$summary['cutoff_awal']}}
                </td>
              </tr>
              <tr>
                <td>
                  <li>Tanggal Akhir Cut Off Absen
                </td>
                <td id="summary_cutoff_akhir">
                  :&nbsp;&nbsp; {{$summary['cutoff_akhir']}}
                </td>
              </tr>
              <tr>
                <td>
                  <li>Total Pegawai
                </td>
                <td id="summary_totalpegawai">
                  :&nbsp;&nbsp; {{$summary['totalpegawai']}}</li>
                </td>
              </tr>
              <tr>
                <td>
                  <li>Total Penerimaan
                </td>
                <td id="summary_totalpenerimaan">
                  :&nbsp;&nbsp; Rp {{number_format($summary['totalpenerimaan'], '0', ',', '.')}},-</li>
                </td>
              </tr>
              <tr>
                <td>
                  <li>Total Potongan
                </td>
                <td id="summary_totalpotongan">
                  :&nbsp;&nbsp; Rp {{number_format($summary['totalpotongan'], '0', ',', '.')}},-</li>
                </td>
              </tr>
              <tr>
                <td>
                  <li>Total Pengeluaran
                </td>
                <td id="summary_totalpengeluaran">
                  :&nbsp;&nbsp; Rp {{number_format($summary['totalpengeluaran'], '0', ',', '.')}},-</li>
                </td>
              </tr>
            </table>
          </ul>
          @if ($getbatch->flag_processed==1)
            <span data-toggle="tooltip" title="Batch Telah Diproses">
              <a href="#" class="btn btn-default disabled">Proses Payroll</a>
            </span>
          @else
            <a href="{{url('batch-payroll/process/'.$idbatch.'/'.http_build_query(array('data' => $summary)))}}" class="btn btn-warning {{ $onlyPayroll }}">Proses Payroll</a>
          @endif
        </div>
      </div>
    </div>

    <div class="col-md-3">
      @if ($getbatch->flag_processed==1)
        <div class="box box-default box-solid">
      @else
        <div class="box box-success box-solid">
      @endif
        <div class="box-header">
          <h3 class="box-title"><strong>Export Template</strong></h3>
          <hr style="margin-top:5px;margin-bottom:8px;">
          <div>
            Fitur ini digunakan untuk men-download template .xls guna melengkapi data payroll pegawai.
          </div><br>
          @if ($getbatch->flag_processed==1)
            <span data-toggle="tooltip" title="Batch Telah Diproses">
              <a href="#" class="btn btn-default disabled">Download Template XLS</a>
            </span>
          @else
            <a href="{{route('detailbatchpayroll.export', $idbatch)}}" class="btn btn-warning {{ $onlyPayroll }}">Download Template XLS</a>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-3">
      @if ($getbatch->flag_processed==1)
        <div class="box box-default box-solid">
      @else
        <div class="box box-warning box-solid">
      @endif
        <div class="box-header">
          <form class="form-horizontal" action="{{route('detailbatchpayroll.import')}}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <h3 class="box-title"><strong>Import Template</strong></h3>
            <hr style="margin-top:5px;margin-bottom:8px;">
            <div style="margin-bottom:5px;">
              Import data .xls anda disini:
            </div>
            <input type="file" name="filecsv" class="form-control" {{ $onlyPayroll }} required accept=".xls, .xlsx"
              @if ($getbatch->flag_processed==1)
                disabled
              @endif
            ><br>
            @if ($getbatch->flag_processed==1)
              <span data-toggle="tooltip" title="Batch Telah Diproses">
                <a href="#" class="btn btn-default disabled">Import Tempate XLS</a>
              </span>
            @else
              <input type="submit" class="btn btn-success {{ $onlyPayroll }}" value="Import Tempate XLS">
            @endif
          </form>
        </div>
      </div>
    </div>
  </div>   <!-- /.row -->


  <!-- jQuery 2.1.4 -->
  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <!-- DataTables -->
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <!-- SlimScroll -->
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>


  <script type="text/javascript">
    $(function() {

        $('#tabelpegawai').DataTable();

        // yajra datatable
        // $('#tabelpegawai').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: '{!! route('batchpayroll.getdata', $idbatch) !!}',
        //     column: [
        //       {data: 'id', name: 'id'},
        //       {data: '0', name: 'nip'},
        //       {data: '1', name: 'nama'},
        //       {data: '2', name: 'nama_jabatan'},
        //       {data: '3', name: 'status'},
        //       {data: '4', name: 'komponen_gaji'},
        //       {data: '5', name: 'action', orderable: false, searchable: false}
        //     ]
        // });

        // bind to table komponen in modal
        $('#tabelpegawai').DataTable().on('click', 'a.addkomponen[data-value]', function () {
          var idpegawai = $(this).data('value');
          $('#idkomponengaji').prop('selectedIndex', 0);
          $('#nilaikomponengaji').val("");
          $('#nilaikomponengaji').attr('readonly', false);

          $.ajax({
            url: "{{url('/')}}/batch-payroll-detail/bind-to-table/{{$idbatch}}/"+idpegawai,
            dataType: 'json',
            success: function(data){
              $('#idpegawaigaji').val(idpegawai);
              $("#tabelkomponen").find("tr:gt(0)").remove();
              if (data.length==0) {
                $('#tabelkomponen tr:last').after(
                  "<tr>"+
                  "<td colspan='5' align='center'><span class='text-muted'>Data tidak tersedia.</span></td>"+
                  "</tr>"
                );
              } else {
                var no = 1;
                $.each(data, function(index, value){
                  if (data[index].tipe_komponen=="D") {
                    $('#tabelkomponen tr:last').after(
                      "<tr>"+
                      "<td>"+no+"</td>"+
                      "<td>"+data[index].nama_komponen+"</td>"+
                      "<td><span class='label bg-green'>Penerimaan</span></td>"+
                      "<td>"+data[index].periode_perhitungan+"</td>"+
                      "<td id='nilai-for-id-"+data[index].id+"'>"+data[index].nilai+"</td>"+
                      "<td><span data-toggle='tooltip' title='Hapus Komponen'> <a class='btn btn-xs btn-danger hapuskomponen' data-value="+data[index].id+"><i class='fa fa-close'></i></a></span>"+
                      "<span data-toggle='tooltip' title='Edit Nilai'> <a class='btn btn-xs btn-warning editkomponen' data-value="+data[index].id+" data-nilai="+data[index].nilai+"><i class='fa fa-edit'></i></a></span></td>"+
                      "</tr>"
                    );
                  } else {
                    $('#tabelkomponen tr:last').after(
                      "<tr>"+
                      "<td>"+no+"</td>"+
                      "<td>"+data[index].nama_komponen+"</td>"+
                      "<td><span class='label bg-red'>Potongan</span></td>"+
                      "<td>"+data[index].periode_perhitungan+"</td>"+
                      "<td id='nilai-for-id-"+data[index].id+"'>"+data[index].nilai+"</td>"+
                      "<td><span data-toggle='tooltip' title='Hapus Komponen'> <a class='btn btn-xs btn-danger hapuskomponen' data-value="+data[index].id+"><i class='fa fa-close'></i></a></span>"+
                      "<span data-toggle='tooltip' title='Edit Nilai'> <a class='btn btn-xs btn-warning editkomponen' data-value="+data[index].id+" data-nilai="+data[index].nilai+"><i class='fa fa-edit'></i></a></span></td>"+
                      "</tr>"
                    );
                  }
                  no++;
                })
              }
            }
          });
        });

        $('body').on('click', 'a.editkomponen[data-value]', function (){
          var id = $(this).data('value');
          var nilai = $(this).data('nilai');
          $('#nilai-for-id-'+id).html("<div class='input-group input-group-sm'>"+
                                      "<input type='text' class='form-control' value='"+nilai+"' id='inputnilai"+id+"'>"+
                                      "<span class='input-group-btn'>"+
                                      "<a class='btn btn-xs btn-info btn-flat editnilai"+id+"' href='#' data-value='"+id+"'><i class='fa fa-check'></i></a>"+
                                      "</span>"+
                                      "</div>");

          $('a.editnilai'+id).click(function(){
            var _id = $(this).data('value');
            var _inputnilai = $('#inputnilai'+id).val();
            $.ajax({
              url: "{{url('/')}}/komponen-gaji/update-nilai/"+_id+"/"+_inputnilai,
              success: function(data){

                // load data for data tables;
                $.ajax({
                  url: "{{url('/')}}/batch-payroll/refreshrowdatatables/"+{{$idbatch}},
                  dataType: 'json',
                  success: function(data){
                    $('#bodydata').html("");
                    var periode_gaji, cutoff_awal, cutoff_akhir, total_pegawai, total_penerimaan, total_potongan, total_pengeluaran;
                    $.each(data, function(index, value){
                      total_penerimaan = data[1].totalpenerimaan;
                      total_potongan = data[1].totalpotongan;
                      total_pengeluaran = data[1].totalpengeluaran;
                      $('#bodydata').append(
                        "<tr>"+
                          "<td>"+data[0][index].nip+"</td>"+
                          "<td>"+data[0][index].nama+"</td>"+
                          "<td>"+data[0][index].jabatan+"</td>"+
                          "<td>"+
                            "<span class='badge bg-navy'>"+data[0][index].harinormal+"</span>"+
                          "</td>"+
                          "<td>"+
                            "<span class='badge bg-red'>Alpa: "+data[0][index].abstain+"</span>"+
                            "<span class='badge bg-green'>Sakit: "+data[0][index].sick_leave+"</span>"+
                            "<span class='badge bg-blue'>Izin: "+data[0][index].permissed_leave+"</span>"+
                          "</td>"+
                          "<td>"+
                            "<span class='badge bg-purple'>"+data[0][index].totalkerja+"</span>"+
                          "</td>"+
                          "<td>"+data[0][index].gajitetap+"</td>"+
                          "<td>"+data[0][index].gajivariable+"</td>"+
                          "<td>"+data[0][index].potongantetap+"</td>"+
                          "<td>"+data[0][index].potonganvariable+"</td>"+
                          "<td>"+data[0][index].total+"</td>"+
                          "<td>"+
                            "<span data-toggle='tooltip' title='Set Komponen Gaji'>"+
                              "<a href='#' class='btn btn-xs btn-warning addkomponen' data-toggle='modal' data-target='#myModal' data-value='"+data[0][index].id+"'>"+
                                "<i class='fa fa-list-ul'></i>"+
                              "</a>"+
                            "</span>"+
                            "<span data-toggle='tooltip' title='Set Absensi'>"+
                              "<a href='#' class='btn btn-xs btn-success editabsen' data-toggle='modal' data-target='#myModalSetAbsen' data-value='"+data[0][index].iddetailbatch+"'>"+
                                "<i class='fa fa-check'></i>"+
                              "</a>"+
                            "</span>"+
                          "</td>"+
                        "</tr>"
                      );
                      $("#summary_totalpenerimaan").html(":&nbsp;&nbsp; Rp "+total_penerimaan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
                      $("#summary_totalpotongan").html(":&nbsp;&nbsp; Rp "+total_potongan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
                      $("#summary_totalpengeluaran").html(":&nbsp;&nbsp; Rp "+total_pengeluaran.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
                    })
                  }
                });


                $('#nilai-for-id-'+id).html(_inputnilai);
              }
            })
          });
        });

        // save to database
        $('#addkomponentopegawai').click(function(){
          var idkomponen = $('#idkomponengaji').val();
          var nilai = $('#nilaikomponengaji').val();
          var idpegawai = $('#idpegawaigaji').val();

          $.ajax({
            url: "{{url('/')}}/batch-payroll-detail/add-to-komponen/{{$idbatch}}/"+idpegawai+"/"+idkomponen+"/"+nilai,
            dataType: 'json',
            success: function(data){
              $('#nilaikomponengaji').val("");
              $('#idkomponengaji').prop('selectedIndex', 0);
              $("#tabelkomponen").find("tr:gt(0)").remove();
              if (data.length==0) {
                $('#tabelkomponen tr:last').after(
                  "<tr>"+
                  "<td colspan='5' align='center'><span class='text-muted'>Data tidak tersedia.</span></td>"+
                  "</tr>"
                );
              } else {
                var no = 1;
                $.each(data, function(index, value){
                  if (data[index].tipe_komponen=="D") {
                    $('#tabelkomponen tr:last').after(
                      "<tr>"+
                      "<td>"+no+"</td>"+
                      "<td>"+data[index].nama_komponen+"</td>"+
                      "<td><span class='label bg-green'>Penerimaan</span></td>"+
                      "<td>"+data[index].periode_perhitungan+"</td>"+
                      "<td>"+data[index].nilai+"</td>"+
                      "<td><span data-toggle='tooltip' title='Hapus Komponen'> <a class='btn btn-xs btn-danger hapuskomponen' data-value="+data[index].id+"><i class='fa fa-close'></i></a></span>"+
                      "<span data-toggle='tooltip' title='Edit Nilai'> <a class='btn btn-xs btn-warning editkomponen' data-value="+data[index].id+" data-nilai="+data[index].nilai+"><i class='fa fa-edit'></i></a></span></td>"+
                      "</tr>"
                    );
                  } else {
                    $('#tabelkomponen tr:last').after(
                      "<tr>"+
                      "<td>"+no+"</td>"+
                      "<td>"+data[index].nama_komponen+"</td>"+
                      "<td><span class='label bg-red'>Potongan</span></td>"+
                      "<td>"+data[index].periode_perhitungan+"</td>"+
                      "<td>"+data[index].nilai+"</td>"+
                      "<td><span data-toggle='tooltip' title='Hapus Komponen'> <a class='btn btn-xs btn-danger hapuskomponen' data-value="+data[index].id+"><i class='fa fa-close'></i></a></span>"+
                      "<span data-toggle='tooltip' title='Edit Nilai'> <a class='btn btn-xs btn-warning editkomponen' data-value="+data[index].id+" data-nilai="+data[index].nilai+"><i class='fa fa-edit'></i></a></span></td>"+
                      "</tr>"
                    );
                  }
                  no++;
                })
              }

              // load data for data tables;
              $.ajax({
                url: "{{url('/')}}/batch-payroll/refreshrowdatatables/"+{{$idbatch}},
                dataType: 'json',
                success: function(data){
                  $('#bodydata').html("");
                  $.each(data, function(index, value){
                    $('#bodydata').html("");
                    var periode_gaji, cutoff_awal, cutoff_akhir, total_pegawai, total_penerimaan, total_potongan, total_pengeluaran;
                    $.each(data, function(index, value){
                      total_penerimaan = data[1].totalpenerimaan;
                      total_potongan = data[1].totalpotongan;
                      total_pengeluaran = data[1].totalpengeluaran;
                      $('#bodydata').append(
                        "<tr>"+
                          "<td>"+data[0][index].nip+"</td>"+
                          "<td>"+data[0][index].nama+"</td>"+
                          "<td>"+data[0][index].jabatan+"</td>"+
                          "<td>"+
                            "<span class='badge bg-navy'>"+data[0][index].harinormal+"</span>"+
                          "</td>"+
                          "<td>"+
                            "<span class='badge bg-red'>Alpa: "+data[0][index].abstain+"</span>"+
                            "<span class='badge bg-green'>Sakit: "+data[0][index].sick_leave+"</span>"+
                            "<span class='badge bg-blue'>Izin: "+data[0][index].permissed_leave+"</span>"+
                          "</td>"+
                          "<td>"+
                            "<span class='badge bg-purple'>"+data[0][index].totalkerja+"</span>"+
                          "</td>"+
                          "<td>"+data[0][index].gajitetap+"</td>"+
                          "<td>"+data[0][index].gajivariable+"</td>"+
                          "<td>"+data[0][index].potongantetap+"</td>"+
                          "<td>"+data[0][index].potonganvariable+"</td>"+
                          "<td>"+data[0][index].total+"</td>"+
                          "<td>"+
                            "<span data-toggle='tooltip' title='Set Komponen Gaji'>"+
                              "<a href='#' class='btn btn-xs btn-warning addkomponen' data-toggle='modal' data-target='#myModal' data-value='"+data[0][index].id+"'>"+
                                "<i class='fa fa-list-ul'></i>"+
                              "</a>"+
                            "</span>"+
                            "<span data-toggle='tooltip' title='Set Absensi'>"+
                              "<a href='#' class='btn btn-xs btn-success editabsen' data-toggle='modal' data-target='#myModalSetAbsen' data-value='"+data[0][index].iddetailbatch+"'>"+
                                "<i class='fa fa-check'></i>"+
                              "</a>"+
                            "</span>"+
                          "</td>"+
                        "</tr>"
                      );
                      $("#summary_totalpenerimaan").html(":&nbsp;&nbsp; Rp "+total_penerimaan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
                      $("#summary_totalpotongan").html(":&nbsp;&nbsp; Rp "+total_potongan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
                      $("#summary_totalpengeluaran").html(":&nbsp;&nbsp; Rp "+total_pengeluaran.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
                    })
                  })
                }
              });
            }
          });
        });

        $('body').on('click', 'a.hapuskomponen[data-value]', function (){
            var idpegawai = $('#idpegawaigaji').val();
            var a = $(this).data('value');
            $.ajax({
              url: "{{url('/')}}/batch-payroll-detail/delete-komponen-gaji/"+a,
              dataType: 'json',
              success: function(data){
                $.ajax({
                  url: "{{url('/')}}/batch-payroll-detail/bind-to-table/{{$idbatch}}/"+idpegawai,
                  dataType: 'json',
                  success: function(data){
                    $('#idpegawaigaji').val(idpegawai);
                    $("#tabelkomponen").find("tr:gt(0)").remove();
                    if (data.length==0) {
                      $('#tabelkomponen tr:last').after(
                        "<tr>"+
                        "<td colspan='5' align='center'><span class='text-muted'>Data tidak tersedia.</span></td>"+
                        "</tr>"
                      );
                    } else {
                      var no = 1;
                      $.each(data, function(index, value){
                        if (data[index].tipe_komponen=="D") {
                          $('#tabelkomponen tr:last').after(
                            "<tr>"+
                            "<td>"+no+"</td>"+
                            "<td>"+data[index].nama_komponen+"</td>"+
                            "<td><span class='label bg-green'>Penerimaan</span></td>"+
                            "<td>"+data[index].periode_perhitungan+"</td>"+
                            "<td id='nilai-for-id-"+data[index].id+"'>"+data[index].nilai+"</td>"+
                            "<td><span data-toggle='tooltip' title='Hapus Komponen'> <a class='btn btn-xs btn-danger hapuskomponen' data-value="+data[index].id+"><i class='fa fa-close'></i></a></span>"+
                            "<span data-toggle='tooltip' title='Edit Nilai'> <a class='btn btn-xs btn-warning editkomponen' data-value="+data[index].id+" data-nilai="+data[index].nilai+"><i class='fa fa-edit'></i></a></span></td>"+
                            "</tr>"
                          );
                        } else {
                          $('#tabelkomponen tr:last').after(
                            "<tr>"+
                            "<td>"+no+"</td>"+
                            "<td>"+data[index].nama_komponen+"</td>"+
                            "<td><span class='label bg-red'>Potongan</span></td>"+
                            "<td>"+data[index].periode_perhitungan+"</td>"+
                            "<td id='nilai-for-id-"+data[index].id+"'>"+data[index].nilai+"</td>"+
                            "<td><span data-toggle='tooltip' title='Hapus Komponen'> <a class='btn btn-xs btn-danger hapuskomponen' data-value="+data[index].id+"><i class='fa fa-close'></i></a></span>"+
                            "<span data-toggle='tooltip' title='Edit Nilai'> <a class='btn btn-xs btn-warning editkomponen' data-value="+data[index].id+" data-nilai="+data[index].nilai+"><i class='fa fa-edit'></i></a></span></td>"+
                            "</tr>"
                          );
                        }
                        no++;
                      })
                    }
                  }
                });

                // load data for data tables;
                $.ajax({
                  url: "{{url('/')}}/batch-payroll/refreshrowdatatables/"+{{$idbatch}},
                  dataType: 'json',
                  success: function(data){
                    $('#bodydata').html("");
                    $.each(data, function(index, value){
                      $('#bodydata').html("");
                      var periode_gaji, cutoff_awal, cutoff_akhir, total_pegawai, total_penerimaan, total_potongan, total_pengeluaran;
                      $.each(data, function(index, value){
                        total_penerimaan = data[1].totalpenerimaan;
                        total_potongan = data[1].totalpotongan;
                        total_pengeluaran = data[1].totalpengeluaran;
                        $('#bodydata').append(
                          "<tr>"+
                            "<td>"+data[0][index].nip+"</td>"+
                            "<td>"+data[0][index].nama+"</td>"+
                            "<td>"+data[0][index].jabatan+"</td>"+
                            "<td>"+
                              "<span class='badge bg-navy'>"+data[0][index].harinormal+"</span>"+
                            "</td>"+
                            "<td>"+
                              "<span class='badge bg-red'>Alpa: "+data[0][index].abstain+"</span>"+
                              "<span class='badge bg-green'>Sakit: "+data[0][index].sick_leave+"</span>"+
                              "<span class='badge bg-blue'>Izin: "+data[0][index].permissed_leave+"</span>"+
                            "</td>"+
                            "<td>"+
                              "<span class='badge bg-purple'>"+data[0][index].totalkerja+"</span>"+
                            "</td>"+
                            "<td>"+data[0][index].gajitetap+"</td>"+
                            "<td>"+data[0][index].gajivariable+"</td>"+
                            "<td>"+data[0][index].potongantetap+"</td>"+
                            "<td>"+data[0][index].potonganvariable+"</td>"+
                            "<td>"+data[0][index].total+"</td>"+
                            "<td>"+
                              "<span data-toggle='tooltip' title='Set Komponen Gaji'>"+
                                "<a href='#' class='btn btn-xs btn-warning addkomponen' data-toggle='modal' data-target='#myModal' data-value='"+data[0][index].id+"'>"+
                                  "<i class='fa fa-list-ul'></i>"+
                                "</a>"+
                              "</span>"+
                              "<span data-toggle='tooltip' title='Set Absensi'>"+
                                "<a href='#' class='btn btn-xs btn-success editabsen' data-toggle='modal' data-target='#myModalSetAbsen' data-value='"+data[0][index].iddetailbatch+"'>"+
                                  "<i class='fa fa-check'></i>"+
                                "</a>"+
                              "</span>"+
                            "</td>"+
                          "</tr>"
                        );
                        $("#summary_totalpenerimaan").html(":&nbsp;&nbsp; Rp "+total_penerimaan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
                        $("#summary_totalpotongan").html(":&nbsp;&nbsp; Rp "+total_potongan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
                        $("#summary_totalpengeluaran").html(":&nbsp;&nbsp; Rp "+total_pengeluaran.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
                      })
                    })
                  }
                });
              }
            });
        });

        $('#idkomponengaji').change(function(){
           var a = $(this).val();
           var idpegawai = $('#idpegawaigaji').val();

           // gaji pokok id in database is 1
           if (a==1) {
             $.ajax({
               url: "{{url('/')}}/batch-payroll-detail/get-gapok/"+idpegawai,
               dataType: 'json',
               success: function(data){
                 if (data!=0) {
                   $('#nilaikomponengaji').val(data);
                   $('#nilaikomponengaji').attr('readonly', true);
                 } else {
                   $('#nilaikomponengaji').val("");
                   $('#nilaikomponengaji').attr('readonly', false);
                 }
               }
             });
           } else {
             $('#nilaikomponengaji').val("");
             $('#nilaikomponengaji').attr('readonly', false);
           }
         });

         $('#tabelpegawai').DataTable().on('click', 'a.editabsen[data-value]', function () {
           var a = $(this).data('value');
           $.ajax({
             url: "{{ url('/') }}/batch-payroll-detail/bind-for-absen/"+a,
             dataType: 'json',
             success: function(data){
               // get
               var id = data.id;
               var nip = data.nip;
               var nama = data.nama;
               var alpa = data.abstain;
               var sakit = data.sick_leave;
               var izin = data.permissed_leave;

               // set
               $('#idforabsen').attr('value', id);
               $('#nipforabsen').attr('value', nip);
               $('#namaforabsen').attr('value', nama);
               $('#abstainforabsen').attr('value', alpa);
               $('#sickforabsen').attr('value', sakit);
               $('#permissedforabsen').attr('value', izin);
             }
           });
         });
      });
  </script>

@stop
