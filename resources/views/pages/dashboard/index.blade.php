@extends('layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Dashboard
    @if (session('level') == 1)
      <small>Human Resources</small>
    @elseif (session('level') == 2)
      <small>Payroll System</small>
    @elseif(session('level') == 3)
      <small>Direktur Operasional</small>
    @endif
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
@stop

@section('content')

  <div class="row">

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $jumlah_pegawai }}</h3>
          <p>Jumlah Pegawai Aktif</p>
        </div>
        <div class="icon">
          <i class="ion ion-ios-people"></i>
        </div>
        <a href="{{ route('masterpegawai.index') }}" class="small-box-footer">Lihat Data <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{$jumlah_pkwt_menuju_expired}}</h3>
          <p>PKWT Menuju Expired</p>
        </div>
        <div class="icon">
          <i class="ion ion-alert-circled"></i>
        </div>
        <a class="small-box-footer">
          <i>
          {{$jumlah_pkwt_menuju_expired}}
          Data PKWT Menuju Expired</i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{$jumlah_pkwt_expired}}</h3>
          <p>PKWT Expired</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-clipboard"></i>
        </div>
        <a class="small-box-footer">
          <i>
            {{$jumlah_pkwt_expired}}
            Data PKWT Expired</i>
        </a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $jumlah_client }}</h3>
          <p>Jumlah Client</p>
        </div>
        <div class="icon">
          <i class="fa fa-building-o"></i>
        </div>
        <a href="{{ url('masterclient') }}" class="small-box-footer">Lihat Data <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>

  @if (session('level') == 1)
    <div class="row">
      <section class="col-md-12">
        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Seluruh Data PKWT</h3>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-hover" id="tabelpkwt">
              <thead>
                <tr>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Tanggal Awal PKWT</th>
                  <th>Tanggal Akhir PKWT</th>
                  <th>Status Karyawan</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="box-footer">
            <a href="{{url('data-pkwt')}}" class="btn btn-success pull-right"><i class="fa fa-file"></i> &nbsp;&nbsp;Kelola Data PKWT</a>
          </div>
        </div>
      </section>
    </div>
  @endif

  @if (session('level') == 2 || session('level') == 3)
    <div class="row">
      <div class="col-md-8">
        <div class="box box-primary box-solid">
          <div class="box-header">
            <div class="box-title">
              Batch Payroll
            </div>
          </div>
          <div class="box-body table-responsive">
            <table class="table no-margin">
              <thead>
                <tr>
                  <th>Batch ID</th>
                  <th>Periode</th>
                  <th>Cut Off Absen</th>
                  <th>Total Pegawai</th>
                  <th>Total Pengeluaran</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @if (count($batchprocessed)!=0)
                  @foreach ($batchprocessed as $key)
                    <tr>
                      <td>{{$key->id}}</td>
                      <td>
                        <span class="label bg-blue">Per Tanggal {{$key->tanggal}}</span>
                      </td>
                      <td>
                        {{ \Carbon\Carbon::parse($key->tanggal_cutoff_awal)->format('d-M-y')}}
                         s/d {{ \Carbon\Carbon::parse($key->tanggal_cutoff_akhir)->format('d-M-y')}}
                      </td>
                      <td><span class="badge bg-orange">{{$key->total_pegawai}}</span></td>
                      <td>Rp. {{number_format($key->total_pengeluaran, '0', ',', '.')}},-</td>
                      <td>
                        <span class="label bg-green">Sudah Diproses</span>
                      </td>
                      <td>
                        <span data-toggle="tooltip" title="Lihat Batch Detail">
                          <a href="{{route('batchpayroll.detail', $key->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                        </span>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <div class="box-footer text-center">
            <a href="{{route('batchpayroll.index')}}" class="btn btn-xs btn-primary">Lihat Seluruh Batch Payroll</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box box-primary box-solid">
          <div class="box-header">
            <div class="box-title">
              Master Client
            </div>
          </div>
          <div class="box-body">
            <ul class="nav nav-pills nav-stacked">
              @php
                $color = ['bg-blue', 'bg-green', 'bg-yellow', 'bg-red', 'bg-maroon', 'bg-navy', 'bg-purple']
              @endphp
              @foreach ($getclient as $key)
                <li>
                  <a href="{{url('masterclient/cabang')}}/{{$key->id}}">{{$key->nama_client}}
                    <span class="badge {{$color[rand(0,6)]}} pull-right"> {{$key->jumlah_cabang}} Cabang</span>
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="box-footer text-center">
            <a href="{{url('masterclient')}}" class="btn btn-xs btn-primary">Lihat Seluruh Client</a>
          </div>
        </div>
      </div>
    </div>
  @endif

  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>

  @if (session('level') == 1)
    <script type="text/javascript">
    $(function() {
      $('#tabelpkwt').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('datatables.dash') !!}',
        column: [
          {data: 'id', name: 'id'},
          {data: '0', name: 'nip'},
          {data: '1', name: 'nama'},
          {data: '2', name: 'tanggal_awal_pkwt'},
          {data: '3', name: 'tanggal_akhir_pkwt'},
          {data: '4', name: 'status_karyawan_pkwt'},
          {data: '5', name: 'keterangan'}
        ]
      });
    });
    </script>
  @endif

@stop
