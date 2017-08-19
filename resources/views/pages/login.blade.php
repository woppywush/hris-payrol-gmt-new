<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PT. Ganda Mady Pratama | Human Resources & Payroll System</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/bootstrap/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/custom9tins.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue-light hold-transition login-page">
    <div class="login-box">
      <div class="login-logo-custom">
        <div class="logo-custom">
          <img style="float:right;" src="{{asset('images/logo-gmt.png')}}" alt="" />
        </div>
        <div class="logo-name-custom">
          <div class="head-logo-name">
            PT. Ganda Mady Indotama
          </div>
          <div>
            @if(Auth::check())
              @if(session('level') == 1)
                Human Resources
              @elseif(session('level') == 2)
                Payroll System
              @else
                Direktur Operasional
              @endif
            @else
              Human Resources & Payroll System
            @endif
          </div>
        </div>
      </div>


      @if(Auth::check())
        @if(Auth::user())
          @if(session('level') == 1)
          <div class="register-box-body">
            <div class="social-auth-links text-center">
              <p>Hello, {{ Auth::user()->nama }}</p>
              <a href="{{ url('/dashboard') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-bitbucket"><i class="fa fa-dashboard"></i></i> Dashboard</a>
              <a href="{{ url('masterclient') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-dropbox"><i class="fa fa-building-o"></i> Master Client</a>
              <a href="{{ route('masterpegawai.index') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-google"><i class="fa fa-users"></i> Master Pegawai</a>
              <a href="{{ route('masterjabatan.create') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-instagram"><i class="fa fa-briefcase"></i> Master Jabatan</a>
              <a href="{{url('pkwt')}}" class="btn btn-block btn-social btn-maroon btn-flat btn-twitter"><i class="fa fa-file-text"></i> Manajemen PKWT</a>
              <a href="{{ route('logout') }}" class="btn btn-block btn-social btn-flat btn-vk" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </div>
          </div>
          @elseif(session('level') == 2)
          <div class="register-box-body">
            <div class="social-auth-links text-center">
              <p>Hello, {{ Auth::user()->nama }}</p>
              <a href="{{ url('/dashboard') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-bitbucket"><i class="fa fa-dashboard"></i></i> Dashboard</a>
              <a href="{{ route('periodegaji.index') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-dropbox"><i class="fa fa-building-o"></i> Periode Gaji</a>
              <a href="{{ route('komgaji.index') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-google"><i class="fa fa fa-cogs"></i> Komponen Gaji</a>
              <a href="{{ route('komgaji.index') }}" class="btn btn-block btn-social btn-grey btn-flat btn-github"><i class="fa fa fa fa-money"></i> Proses Payroll</a>
              <a href="{{ route('logout') }}" class="btn btn-block btn-social btn-flat btn-vk" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </div>
          </div>
          @elseif(session('level') == 3)
          <div class="register-box-body">
            <div class="social-auth-links text-center">
              <p>Hello, {{ Auth::user()->nama }}</p>
              <a href="{{ url('/dashboard') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-bitbucket"><i class="fa fa-dashboard"></i></i> Dashboard</a>
              <a href="{{ url('masterclient') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-dropbox"><i class="fa fa-building-o"></i> Master Client</a>
              <a href="{{ route('masterpegawai.index') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-google"><i class="fa fa-users"></i> Master Pegawai</a>
              <a href="{{ route('masterjabatan.create') }}" class="btn btn-block btn-social btn-maroon btn-flat btn-instagram"><i class="fa fa-briefcase"></i> Master Jabatan</a>
              <a href="{{ route('batchpayroll.index') }}" class="btn btn-block btn-social btn-grey btn-flat btn-github"><i class="fa fa fa fa-money"></i> Proses Payroll</a>
              <a href="{{ route('logout') }}" class="btn btn-block btn-social btn-flat btn-vk" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </div>
          </div>
          @endif
        @endif
      @else
        <div class="login-box-body">
          <p class="login-box-msg">Silahkan lakukan proses login</p>
          @if(Session::has('failedLogin'))
            <p class="login-box-msg">{{ Session::get('failedLogin') }}</p>
          @endif
          <form action="{{ route('login') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }} has-feedback">
              <input name="username" type="text" class="form-control" placeholder="Username" value="{{ old('username') }}">
              <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input name="password" type="password" class="form-control" placeholder="Password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group {{ Session::has('error') ? 'has-error' : ''}}">
              @if(Session::has('error'))
                <span class="help-block">
                  <i>* {{ Session::get('error') }}</i>
                </span>
              @endif
            </div>
            <div class="row">
              <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
              </div>
            </div>
          </form>
        </div>
      @endif
    </div>

    <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  </body>
</html>
