<section class="sidebar">
  <div class="user-panel">
    <div class="pull-left image">
      @if(Auth::user()->url_foto!="")
        <img src="{{url('images')}}/{{Auth::user()->url_foto}}" class="img-circle" alt="User Image">
      @else
        <img src="{{url('images')}}/user-not-found.png" class="img-circle" alt="User Image">
      @endif
    </div>
    <div class="pull-left info">
      <p>
        {{ Auth::user()->nama }}
      </p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      <br>
        @if (session('level') == 1)
          <span class="label label-info">Human Resources</span>
        @elseif (session('level') == 2)
          <span class="label label-success">Payroll System</span>
        @elseif (session('level') == 3)
          <span class="label label-danger">Direktur Operasional</span>
        @endif
    </div>
  </div>
  <ul class="sidebar-menu">
    <li class="header">NAVIGASI UTAMA</li>
    <li class="{{ Route::currentRouteNamed('dashboard') ? 'active' : '' }}">
      <a href="{{ url('/dashboard') }}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>
    @if (session('level')=="1")
      <li class="treeview {{ Route::currentRouteNamed('masterpegawai.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterpegawai.show') ? 'active' : '' }}{{ Route::currentRouteNamed('masterpegawai.create') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Master Pegawai</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('masterpegawai.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterpegawai.show') ? 'active' : '' }}{{ Route::currentRouteNamed('masterpegawai.create') ? 'active' : '' }}"><a href="{{ route('masterpegawai.index') }}"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('uploaddocument.create') ? 'active' : '' }}{{ Route::currentRouteNamed('import') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-newspaper-o"></i>
          <span>Dokumen Pegawai</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('uploaddocument.create') ? 'active' : '' }}"><a href="{{ route('uploaddocument.create') }}"><i class="fa fa-circle-o"></i> Kelola Dokumen Pegawai</a></li>
          <li class="{{ Route::currentRouteNamed('import') ? 'active' : '' }}"><a href="{{ url('import') }}"><i class="fa fa-circle-o"></i> Import Data Pegawai</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('masterjabatan.create') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-briefcase"></i>
          <span>Master Jabatan</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('masterjabatan.create') ? 'active' : '' }}"><a href="{{ route('masterjabatan.create') }}"><i class="fa fa-circle-o"></i>Data Jabatan</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('masterbank.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterbank.ubah') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-bank"></i>
          <span>Master Bank</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('masterbank.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterbank.ubah') ? 'active' : '' }}"><a href="{{ route('masterbank.index') }}"><i class="fa fa-circle-o"></i> Data Bank</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('masterclient.*') ? 'active' : '' }}{{ Route::is('clientcabang.*') ? 'active' : '' }}{{ Route::is('departemen.*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-building-o"></i>
          <span>Master Client</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('masterclient.*') ? 'active' : '' }}{{ Route::is('clientcabang.*') ? 'active' : '' }}{{ Route::is('departemen.*') ? 'active' : '' }}"><a href="{{ url('masterclient') }}"><i class="fa fa-circle-o"></i> Data Client</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('pkwt*') ? 'active' : '' }}{{ Route::is('supervisi*') ? 'active' : '' }}{{ Route::is('getSupervisi') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-file-text"></i>
          <span>Manajemen PKWT</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('pkwt*') ? 'active' : '' }}">
            <a href="{{ route('pkwt.index') }}"><i class="fa fa-circle-o"></i>Data PKWT</a>
          </li>
          <li class="{{ Route::is('supervisi*') ? 'active' : '' }}">
            <a href="{{ route('supervisi.index') }}"><i class="fa fa-circle-o"></i>Manajement Supervisi</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('useraccount*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-laptop"></i>
          <span>Manajemen Akun</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('useraccount*') ? 'active' : '' }}">
            <a href="{{ route('useraccount.index') }}"><i class="fa fa-circle-o"></i> Akun User</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('laporanpegawai*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-file-text-o"></i>
          <span>Laporan</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('laporanpegawai*') ? 'active' : '' }}">
            <a href="{{ route('laporanpegawai.index') }}"><i class="fa fa-circle-o"></i> Laporan Pegawai</a></li>
        </ul>
      </li>
    @endif

    @if (session('level')=="2")
      <li class="treeview {{ Route::is('periodegaji*') ? 'active' : '' }}{{ Route::is('periodepegawai*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-calendar-minus-o"></i>
          <span>Periode</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('periodegaji*') ? 'active' : '' }}">
            <a href="{{route('periodegaji.index')}}"><i class="fa fa-circle-o"></i> Periode Gaji</a>
          </li>
          <li class="{{ Route::is('periodepegawai*') ? 'active' : '' }}">
            <a href="{{ route('periodepegawai.index') }}"><i class="fa fa-circle-o"></i> Periode Pegawai</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('komgajitetap.index') ? 'active' : '' }}{{ Route::currentRouteNamed('komgajitetapclient.index') ? 'active' : '' }}{{ Route::currentRouteNamed('komgaji.index') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-cogs"></i>
          <span>Komponen Gaji</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('komgajitetap.index') ? 'active' : '' }}{{ Route::currentRouteNamed('komgajitetapclient.index') ? 'active' : '' }}"><a href="{{route('komgajitetap.index')}}"><i class="fa fa-circle-o"></i> Gaji Tetap</a></li>
          <li class="{{ Route::currentRouteNamed('komgaji.index') ? 'active' : '' }}"><a href="{{route('komgaji.index')}}"><i class="fa fa-circle-o"></i> Gaji Variable</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('hari.libur*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-child"></i>
          <span>Manajemen Hari Libur</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('hari.libur*') ? 'active' : '' }}">
            <a href="{{route('hari.libur.index')}}"><i class="fa fa-circle-o"></i> Set Hari Libur</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('bpjs*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-ambulance"></i>
          <span>Manajemen BPJS</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('bpjs*') ? 'active' : '' }}">
            <a href="{{route('bpjs.index')}}"><i class="fa fa-circle-o"></i> Set BPJS</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('pengecualian.client*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-unlink"></i>
          <span>Pengecualian Hari Libur</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('pengecualian.client*') ? 'active' : '' }}">
            <a href="{{ route('pengecualian.client.index') }}"><i class="fa fa-circle-o"></i> Set Pengecualian</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('harikerja*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-user-secret"></i>
          <span>Hari Kerja</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('harikerja*') ? 'active' : '' }}">
            <a href="{{ route('harikerja.index') }}"><i class="fa fa-circle-o"></i> Set Hari Kerja</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('historygajipokok*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-building-o"></i>
          <span>Gaji Pokok</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('historygajipokok*') ? 'active' : '' }}">
            <a href="{{ route('historygajipokok.index') }}"><i class="fa fa-circle-o"></i> Set Gaji Pokok</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('batchpayroll*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-money"></i>
          <span>Proses Payroll</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('batchpayroll*') ? 'active' : '' }}">
            <a href="{{ route('batchpayroll.index') }}"><i class="fa fa-circle-o"></i> Generate Batch</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('rapelgaji*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-heart-o"></i>
          <span>Rapel Gaji</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('rapelgaji.index') ? 'active' : '' }}">
            <a href="{{ route('rapelgaji.index') }}"><i class="fa fa-circle-o"></i> Perhitungan Rapel Gaji</a>
          </li>
          <li class="{{ Route::is('rapelgaji.list') ? 'active' : '' }}">
            <a href="{{ route('rapelgaji.list') }}"><i class="fa fa-circle-o"></i> Lihat Data Rapel Gaji</a>
          </li>
        </ul>
      </li>
      <li class="treeview {{ Route::is('thr*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-star"></i>
          <span>Proses THR</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::is('thr*') ? 'active' : '' }}">
            <a href="{{route('thr.index')}}"><i class="fa fa-circle-o"></i> Perhitungan THR</a>
          </li>
        </ul>
      </li>
    @endif

    @if (session('level')=="3")
    <li class="treeview {{ Route::currentRouteNamed('masterpegawai.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterpegawai.show') ? 'active' : '' }}{{ Route::currentRouteNamed('masterpegawai.create') ? 'active' : '' }}">
      <a href="#">
        <i class="fa fa-users"></i>
        <span>Master Pegawai</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="{{ Route::currentRouteNamed('masterpegawai.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterpegawai.show') ? 'active' : '' }}{{ Route::currentRouteNamed('masterpegawai.create') ? 'active' : '' }}"><a href="{{ route('masterpegawai.index') }}"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
      </ul>
    </li>
    <li class="treeview {{ Route::currentRouteNamed('masterjabatan.create') ? 'active' : '' }}">
      <a href="#">
        <i class="fa fa-briefcase"></i>
        <span>Master Jabatan</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="{{ Route::currentRouteNamed('masterjabatan.create') ? 'active' : '' }}"><a href="{{ route('masterjabatan.create') }}"><i class="fa fa-circle-o"></i>Data Jabatan</a></li>
      </ul>
    </li>
    <li class="treeview {{ Route::currentRouteNamed('masterbank.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterbank.ubah') ? 'active' : '' }}">
      <a href="#">
        <i class="fa fa-bank"></i>
        <span>Master Bank</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="{{ Route::currentRouteNamed('masterbank.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterbank.ubah') ? 'active' : '' }}"><a href="{{ route('masterbank.index') }}"><i class="fa fa-circle-o"></i> Data Bank</a></li>
      </ul>
    </li>
    <li class="treeview {{ Route::is('masterclient*') ? 'active' : '' }}{{ Route::is('cabangclient*') ? 'active' : '' }}">
      <a href="#">
        <i class="fa fa-building-o"></i>
        <span>Master Client</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="{{ Route::is('masterclient*') ? 'active' : '' }}{{ Route::is('cabangclient*') ? 'active' : '' }}"><a href="{{ url('masterclient') }}"><i class="fa fa-circle-o"></i> Data Client</a></li>
      </ul>
    </li>
    <li class="treeview {{ Route::is('laporanpegawai*') ? 'active' : '' }}{{ Route::is('proseslaporan*') ? 'active' : '' }}">
      <a href="#">
        <i class="fa fa-file-text-o"></i>
        <span>Laporan</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="{{ Route::is('laporanpegawai*') ? 'active' : '' }}{{ Route::is('proseslaporan*') ? 'active' : '' }}"><a href="{{ route('laporanpegawai') }}"><i class="fa fa-circle-o"></i> Laporan Data Pegawai</a></li>
      </ul>
    </li>
    <li class="treeview {{ Route::is('batchpayroll*') ? 'active' : '' }}">
      <a href="#">
        <i class="fa fa-money"></i>
        <span>Proses Payroll</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="{{ Route::is('batchpayroll*') ? 'active' : '' }}"><a href="{{ route('batchpayroll.index') }}"><i class="fa fa-circle-o"></i> Generate Batch</a></li>
      </ul>
    </li>
    @endif
  </ul>
</section>
