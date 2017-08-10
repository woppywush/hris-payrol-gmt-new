<!DOCTYPE html>
<html>
  <head>
    @include('includes.head')
    <title>GMT - {{ $proses[0]->nama_client }} </title>
  </head>
  <body class="hold-transition skin-blue-light sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <a href="" class="logo">
          <span class="logo-mini"><b>GMT</b></span>
          <span class="logo-lg" style="font-size:18px;"><b>GMT</b>
            Client
          </span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{url('images')}}/user-not-found.png" class="user-image" alt="User Image">
                  <span class="hidden-xs">
                    {{ $proses[0]->nama_client }}
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <aside class="main-sidebar">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image">
              @if(Auth::check())
              @if(Auth::user()->url_foto!="")
                <img src="{{url('images')}}/{{Auth::user()->url_foto}}" class="img-circle" alt="User Image">
              @else
                <img src="{{url('images')}}/user-not-found.png" class="img-circle" alt="User Image">
              @endif
              @else
                <img src="{{url('images')}}/user-not-found.png" class="img-circle" alt="User Image">
              @endif
            </div>
            <div class="pull-left info">
              <p>
                @if(Auth::check())
                @if(Auth::user())
                  {{ Auth::user()->nama }}
                @endif
                @else
                {{ $proses[0]->nama_client }}
                @endif
              </p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <ul class="sidebar-menu">
            <li class="header">NAVIGASI UTAMA</li>
            <li>
              <a href="{{ Request::url() }}">
                <i class="fa fa-dashboard"></i> <span>Report</span>
              </a>
            </li>
          </ul>
        </section>
      </aside>

      <div class="content-wrapper">
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary box-solid">
                <div class="box-header">
                  <div class="btn-group pull-right">
                    <button type="button" class="btn btn-round bg-red">Download</button>
                    <button type="button" class="btn btn-round bg-red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a style="color: black" href="{{ URL::to('laporan-pegawai/cetak/'.$idClient[0]->id) }}">Excel</a></li>
                    </ul>
                  </div>
                </div>
                <div class="box-body table-responsive">
                  <table class="table table-hover" id="tabellaporan">
                    <thead>
                      <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Kelompok Jabatan</th>
                        <th>Jabatan</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Masuk GMT</th>
                        <th>Tanggal Masuk Client</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($proses as $key)
                        <tr>
                          <td>{{ $key->nip }}</td>
                          <td>{{ $key->nama }}</td>
                          <td>{{ $key->nama_client }} - {{$key->nama_cabang}}</td>
                          <td>{{ $key->spv }}</td>
                          <td>{{ $key->nama_jabatan }}</td>
                          <td>{{ $key->jenis_kelamin }}</td>
                          <td>{{ $key->tanggal_masuk_gmt }}</td>
                          <td>{{ $key->tanggal_masuk_client }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="box-footer">
                  {{ $proses->links()}}
                </div>
              </div>
            </div>

          </div>
        </section>
      </div>

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="http://gmtclean.com"> PT Ganda Mady Indotama</a>.</strong> All rights reserved. By <a href="http://9tins.com">9Tins</a>
      </footer>

    </div>

  </body>

  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>
</html>
