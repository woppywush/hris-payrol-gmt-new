@extends('layouts.master')

@section('title')
    <title>Kelola Komponen Gaji</title>
@stop

@section('breadcrumb')
  <h1>
    Rapel Gaji
    <small>List Rapel Gaji</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{route('rapelgaji.view')}}"> List Rapel Gaji</a></li>
    <li class="active">Detail Rapel Gaji</li>
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
          <h3 class="box-title">Seluruh Batch Rapel Gaji</h3>
        </div>
        <div class="box-body table-responsive">
          <table id="table_list" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Tanggal Proses Rapel</th>
                <th>Jumlah Bulan Selisih</th>
                <th>Jumlah Rapel Gaji</th>
              </tr>
            </thead>
            <tbody>
              @php
                $tanggalproses = null;
                $jumlahbulanselisih = 0;
                $totalrapelgaji = 0;
                $totalpegawai = 0;
              @endphp
              @foreach ($data as $key)
                @php
                  $tanggalproses = $key->tanggal_proses;
                  $jumlahbulanselisih = $key->jml_bulan_selisih;
                  $totalrapelgaji = $totalrapelgaji + $key->nilai_rapel;
                  $totalpegawai++;
                @endphp
                <tr>
                  <td>{{$totalpegawai}}</td>
                  <td>{{$key->nip}}</td>
                  <td>{{$key->nama}}</td>
                  <td>{{$key->tanggal_proses}}</td>
                  <td><span class="badge bg-green">{{$key->jml_bulan_selisih}}</span></td>
                  <td>{{$key->nilai_rapel}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="box-title"><strong>Summary Batch Rapel Gaji</strong></h3>
          <hr style="margin-top:5px;margin-bottom:8px;">
          <ul>
            <table>
              <tr>
                <td>
                  <li>Tanggal Proses
                </td>
                <td>
                  : &nbsp;&nbsp;{{$tanggalproses}} </li>
                </td>
              </tr>
              <tr>
                <td>
                  <li>Total Pegawai
                </td>
                <td>
                  : &nbsp;&nbsp;{{$totalpegawai}} Pegawai</li>
                </td>
              </tr>
              <tr>
                <td>
                  <li>Jumlah Bulan Selisih&nbsp;&nbsp;&nbsp;
                </td>
                <td>
                  : &nbsp;&nbsp;{{$jumlahbulanselisih}} Bulan</li>
                </td>
              </tr>
              <tr>
                <td>
                  <li>Total Pengeluaran
                </td>
                <td>
                  : &nbsp;&nbsp;{{$totalrapelgaji}} </li>
                </td>
              </tr>
            </table>
          </ul>
          <a href="#" class="btn btn-warning">Proses Rapel Gaji</a>
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
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
  <script>
  $("#table_list").DataTable();

  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
          });
  </script>
  <script type="text/javascript">
    function toggle(pilih) {
    checkboxes = document.getElementsByName('idpegawai[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = pilih.checked;
    }
  }
  </script>

@stop
