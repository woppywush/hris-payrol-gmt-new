@extends('layouts.master')

@section('title')
  <title>Kelola Profile</title>
@stop

@section('breadcrumb')
  <h1>
    Profile
    <small>Kelola Profile</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Profile</li>
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

    <div class="col-md-3">
      <div class="box box-primary">
        <div class="box-body box-profile">
          @if(Auth::user()->url_foto!="")
            <img class="profile-user-img img-responsive img-circle" src="{{url('images')}}/{{Auth::user()->url_foto}}" alt="User profile picture">
          @else
            <img class="profile-user-img img-responsive img-circle" src="{{url('images')}}/user-not-found.png" alt="User profile picture">
          @endif

          <h3 class="profile-username text-center">{{Auth::user()->username}}</h3>

          <p class="text-muted text-center">
            @if($getuser->level=="1")
              Akses HR
            @elseif($getuser->level=="2")
              Akses Payroll
            @elseif($getuser->level=="3")
              Akses Dirops
            @endif
          </p>


          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Jumlah Login</b> <a class="badge bg-green pull-right">{{ Auth::user()->login_count}}</a>
            </li>
          </ul>

        </div>
      </div>
    </div>

    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li><a href="#settings" data-toggle="tab">Profile Pengguna</a></li>
          <li><a href="#password" data-toggle="tab">Ubah Password</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="settings">
            <form class="form-horizontal" action="{{route('useraccount.edit')}}" enctype="multipart/form-data" method="post">
              {{csrf_field()}}
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="{{Auth::user()->id}}">
                  <input type="text" class="form-control" name="name" value="{{ $getuser->nama}}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" name="username" readonly value="{{$getuser->username}}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Hak Akses</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="hakakses" readonly
                    @if($getuser->level=="1")
                      value="Akses HR"
                    @elseif($getuser->level=="2")
                      value="Akses Payroll"
                    @elseif($getuser->level=="3")
                      value="Akses Dirops"
                    @endif
                  >
                </div>
              </div>
              <div class="form-group">
                <label for="inputExperience" class="col-sm-2 control-label">Upload Foto</label>
                <div class="col-sm-10">
                  <input type="file" name="url_foto" class="form-control">
                  <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-success btn-flat">Simpan</button>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="password">
            <form class="form-horizontal" action="{{route('useraccount.editpassword')}}" method="post">
              {{csrf_field()}}
              <div class="form-group {{ $errors->has('oldpassword') ? 'has-error' : '' }}">
                <label for="inputName" class="col-sm-2 control-label">Password Lama</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="{{Auth::user()->id}}">
                  <input type="password" class="form-control" name="oldpassword" value="{{ old('oldpassword') }}">
                  @if($errors->has('oldpassword'))
                    <span class="help-block">
                      <strong>{{ $errors->first('oldpassword')}}
                      </strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="inputEmail" class="col-sm-2 control-label">Password Baru</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="password">
                  @if($errors->has('password'))
                    <span class="help-block">
                      <strong>{{ $errors->first('password')}}
                      </strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                <label for="inputEmail" class="col-sm-2 control-label">Konfirmasi Password Baru</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="password_confirmation">
                  @if($errors->has('password_confirmation'))
                    <span class="help-block">
                      <strong>{{ $errors->first('password_confirmation')}}
                      </strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-success btn-flat">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>

  @if($errors->has('oldpassword') || $errors->has('password') || $errors->has('password_confirmation'))
  <script type="text/javascript">
    $('#password').tab('show');
  </script>
  @endif

@stop
