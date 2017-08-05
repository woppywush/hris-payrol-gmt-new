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
      <li class="treeview {{ Route::currentRouteNamed('masterclient.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterclient.tambah') ? 'active' : '' }}{{ Route::currentRouteNamed('masterclient.edit') ? 'active' : '' }}{{ Route::currentRouteNamed('masterclient.cabang') ? 'active' : '' }}{{ Route::currentRouteNamed('cabangclient.edit') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-building-o"></i>
          <span>Master Client</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('masterclient.index') ? 'active' : '' }}{{ Route::currentRouteNamed('masterclient.tambah') ? 'active' : '' }}{{ Route::currentRouteNamed('masterclient.edit') ? 'active' : '' }}{{ Route::currentRouteNamed('masterclient.cabang') ? 'active' : '' }}{{ Route::currentRouteNamed('cabangclient.edit') ? 'active' : '' }}"><a href="{{ url('masterclient') }}"><i class="fa fa-circle-o"></i> Data Client</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('kelola.pkwt') ? 'active' : '' }}{{ Route::currentRouteNamed('datapkwt.create') ? 'active' : '' }}{{ Route::currentRouteNamed('detail.pkwt') ? 'active' : '' }}{{ Route::currentRouteNamed('spv-manajemen') ? 'active' : '' }}{{ Route::currentRouteNamed('getClientSPV') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-file-text"></i>
          <span>Manajemen PKWT</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('kelola.pkwt') ? 'active' : '' }}{{ Route::currentRouteNamed('datapkwt.create') ? 'active' : '' }}{{ Route::currentRouteNamed('detail.pkwt') ? 'active' : '' }}"><a href="{{url('data-pkwt')}}"><i class="fa fa-circle-o"></i>Data PKWT</a></li>
          <li class="{{ Route::currentRouteNamed('spv-manajemen') ? 'active' : '' }}{{ Route::currentRouteNamed('getClientSPV') ? 'active' : '' }}"><a href="{{url('spv-manajemen')}}"><i class="fa fa-circle-o"></i>SPV Manajemen</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('useraccount.create') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-laptop"></i>
          <span>Manajemen Akun</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('useraccount.create') ? 'active' : '' }}"><a href="{{ route('useraccount.create') }}"><i class="fa fa-circle-o"></i> Tambah Akun Baru</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('laporanpegawai') ? 'active' : '' }}{{ Route::currentRouteNamed('proseslaporan') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-file-text-o"></i>
          <span>Laporan</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('laporanpegawai') ? 'active' : '' }}{{ Route::currentRouteNamed('proseslaporan') ? 'active' : '' }}"><a href="{{ route('laporanpegawai') }}"><i class="fa fa-circle-o"></i> Laporan Data Pegawai</a></li>
        </ul>
      </li>
    @endif

    @if (session('level')=="2")
      <li class="treeview {{ Route::currentRouteNamed('periodegaji.index') ? 'active' : '' }}{{ Route::currentRouteNamed('periodegaji.detail') ? 'active' : '' }}{{ Route::currentRouteNamed('periodepegawai.index') ? 'active' : '' }}{{ Route::currentRouteNamed('periodepegawai.proses') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-calendar-minus-o"></i>
          <span>Periode</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('periodegaji.index') ? 'active' : '' }}{{ Route::currentRouteNamed('periodegaji.detail') ? 'active' : '' }}"><a href="{{route('periodegaji.index')}}"><i class="fa fa-circle-o"></i> Periode Gaji</a></li>
          <li class="{{ Route::currentRouteNamed('periodepegawai.index') ? 'active' : '' }}{{ Route::currentRouteNamed('periodepegawai.proses') ? 'active' : '' }}"><a href="{{ route('periodepegawai.index') }}"><i class="fa fa-circle-o"></i> Periode Pegawai</a></li>
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
      <li class="treeview {{ Route::currentRouteNamed('hari.libur.index') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-child"></i>
          <span>Manajemen Hari Libur</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('hari.libur.index') ? 'active' : '' }}"><a href="{{route('hari.libur.index')}}"><i class="fa fa-circle-o"></i> Set Hari Libur</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('bpjs.index') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-ambulance"></i>
          <span>Manajemen BPJS</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('bpjs.index') ? 'active' : '' }}"><a href="{{route('bpjs.index')}}"><i class="fa fa-circle-o"></i> Set BPJS</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('pengecualian.client.index') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-unlink"></i>
          <span>Pengecualian Hari Libur</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('pengecualian.client.index') ? 'active' : '' }}"><a href="{{route('pengecualian.client.index')}}"><i class="fa fa-circle-o"></i> Set Pengecualian</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('harikerja.index') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-user-secret"></i>
          <span>Hari Kerja</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('harikerja.index') ? 'active' : '' }}"><a href="{{route('harikerja.index')}}"><i class="fa fa-circle-o"></i> Set Hari Kerja</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('historygajipokok.index') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-building-o"></i>
          <span>Gaji Pokok</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('historygajipokok.index') ? 'active' : '' }}"><a href="{{route('historygajipokok.index')}}"><i class="fa fa-circle-o"></i> Set Gaji Pokok</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('batchpayroll.index') ? 'active' : '' }}{{ Route::currentRouteNamed('batchpayroll.detail') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-money"></i>
          <span>Proses Payroll</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('batchpayroll.index') ? 'active' : '' }}{{ Route::currentRouteNamed('batchpayroll.detail') ? 'active' : '' }}"><a href="{{ route('batchpayroll.index') }}"><i class="fa fa-circle-o"></i> Generate Batch</a></li>
        </ul>
      </li>
      <li class="treeview {{ Route::currentRouteNamed('rapelgaji.index') ? 'active' : '' }}
        {{ Route::currentRouteNamed('rapelgaji.list') ? 'active' : '' }}
        {{ Route::currentRouteNamed('rapelgaji.getclienthistory') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-heart-o"></i>
          <span>Rapel Gaji</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Route::currentRouteNamed('rapelgaji.index') ? 'active' : '' }}
          {{ Route::currentRouteNamed('rapelgaji.getclienthistory') ? 'active' : '' }}"><a href="{{route('rapelgaji.index')}}"><i class="fa fa-circle-o"></i> Perhitungan Rapel Gaji</a></li>
          <li class="{{ Route::currentRouteNamed('rapelgaji.list') ? 'active' : '' }}"><a href="{{route('rapelgaji.list')}}"><i class="fa fa-circle-o"></i> Lihat Data Rapel Gaji</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-star"></i>
          <span>Proses THR</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-circle-o"></i> Perhitungan THR</a></li>
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
