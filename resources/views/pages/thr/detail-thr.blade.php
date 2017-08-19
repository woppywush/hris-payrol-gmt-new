@extends('layouts.master')

@section('title')
  <title>Detail Batch THR</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Detail Batch THR
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('thr.index') }}"> Perhitungan THR</a></li>
    <li class="active">Detail Batch THR</li>
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
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Proses Batch THR</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin akan memproses batch THR ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="{{route('thr.process', $id_batch_thr)}}" class="btn btn-warning">Ya, saya yakin.</a>
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

    @if ($summarydata['status']==1)
      <div class="col-md-12">
        <div class="box box-warning box-solid">
          <div class="box-header">
            <span><i>Batch THR ini telah di proses.</i></span>
            <hr style="margin-top:5px;margin-bottom:15px;">
            <strong style="font-size:17px;">Download Laporan :</strong> &nbsp;&nbsp;
            <a href="{{ route('laporan.prosesThr', ['id' => $id_batch_thr]) }}" class="btn btn-default bg-blue">Laporan Batch THR</a>&nbsp;
          </div>
        </div>
      </div>
    @endif

    <div class="col-md-12">
      <div class="box {{ $summarydata['status']==1 ? 'box-default' : 'box-primary'}} box-solid">
        <div class="box-header">
          <h3 class="box-title">
            Detail Batch THR
          </h3>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-hover" id="tabelpegawai">
            <thead>
              <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Hitungan Bulan Kerja</th>
                <th>Nilai THR</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box {{ $summarydata['status']==1 ? 'box-default' : 'box-primary'}} box-solid">
        <div class="box-header">
          <h3 class="box-title"><strong>Summary Batch THR</strong></h3>
          <hr style="margin-top:5px;margin-bottom:8px;">
          <ul>
            <table>
              <tr>
                <td width="180px;">
                  <li>Periode Penggajian
                </td>
                <td>
                  :&nbsp;&nbsp; Per Tanggal {{ $summarydata["periode"] }}
                </td>
              </tr>
              <tr>
                <td width="180px;">
                  <li>Tanggal Generate Batch
                </td>
                <td>
                  :&nbsp;&nbsp; {{ $summarydata["tanggal_generate"] }}
                </td>
              </tr>
              <tr>
                <td width="180px;">
                  <li>Bulan Awal Perhitungan
                </td>
                <td>
                  :&nbsp;&nbsp; {{ $summarydata["bulan_awal"] }}
                </td>
              </tr>
              <tr>
                <td width="180px;">
                  <li>Bulan Akhir Perhitungan
                </td>
                <td>
                  :&nbsp;&nbsp; {{ $summarydata["bulan_akhir"] }}
                </td>
              </tr>
              <tr>
                <td width="180px;">
                  <li>Jumlah Hitung Bulan
                </td>
                <td>
                  :&nbsp;&nbsp; {{ $summarydata["jumlah_hitung"] }}
                </td>
              </tr>
              <tr>
                <td width="180px;">
                  <li>Jumlah Pegawai
                </td>
                <td>
                  :&nbsp;&nbsp; {{ $summarydata["jumlah_pegawai"] }}
                </td>
              </tr>
              <tr>
                <td width="180px;">
                  <li>Total Pengeluaran THR
                </td>
                <td>
                  :&nbsp;&nbsp; Rp {{ number_format($summarydata["total_pengeluaran"], 0, 0, '.') }},-
                </td>
              </tr>
            </table>
          </ul>
          <span>
            <a href="#" class="btn {{ $summarydata['status']==1 ? 'btn-default disabled' : 'btn-warning'}}" data-toggle="modal" data-target="#myModal">Proses Batch THR</a>
          </span>
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

    $(function() {
        $('#tabelpegawai').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('thr.detail-getdata', $id_batch_thr) !!}',
            column: [
              {data: 'id', name: 'id'},
              {data: '0', name: 'nip'},
              {data: '1', name: 'name'},
              {data: '2', name: 'bulan_kerja'},
              {data: '3', name: 'nilai_thr'},
              {data: '5', name: 'action', orderable: false, searchable: false}
            ]
        });
      });
  </script>

@stop
