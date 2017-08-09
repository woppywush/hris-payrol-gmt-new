@extends('layouts.master')

@section('title')
  <title>Manajemen User</title>
  <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
@stop

@section('content')

  <div class="modal modal-default fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Akun</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data akun ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="" class="btn btn-primary" id="set">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    @if(Session::has('message'))
    <script>
      window.setTimeout(function() {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
      }, 7000);
    </script>

    <div class="col-md-12">
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
          <p>{{ Session::get('message') }}</p>
        </div>
    </div>
    @endif

    <div class="col-md-5">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Akun</h3>
        </div>
        <form class="form-horizontal" method="post" action="{{ route('useraccount.store') }}">
          {!! csrf_field() !!}
          <div class="box-body">
            <div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
              <label class="col-sm-3 control-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" name="nama" class="form-control" placeholder="Nama" value="{{ old('nama') }}">
                @if($errors->has('nama'))
                  <span class="help-block">
                    <strong>{{ $errors->first('nama')}}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
              <label class="col-sm-3 control-label">Email</label>
              <div class="col-sm-9">
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email')}}">
                @if($errors->has('email'))
                  <span class="help-block">
                    <strong>{{ $errors->first('email')}}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
              <label class="col-sm-3 control-label">Username</label>
              <div class="col-sm-9">
                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
                @if($errors->has('username'))
                  <span class="help-block">
                    <strong>{{ $errors->first('username')}}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
              <label class="col-sm-3 control-label">Password</label>
              <div class="col-sm-9">
                <input type="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}">
                @if($errors->has('password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password')}}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
              <label class="col-sm-3 control-label">Konfirmasi Password</label>
              <div class="col-sm-9">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" value="{{ old('password_confirmation') }}">
                @if($errors->has('password_confirmation'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation')}}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group {{ $errors->has('level') ? 'has-error' : '' }}">
              <label class="col-sm-3 control-label">Level Akses</label>
              <div class="col-sm-9">
                <select class="form-control" name="level">
                  <option></option>
                  <option value="1" {{old('level')=="1"?'selected':''}}>Akses HR</option>
                  <option value="2" {{old('level')=="2"?'selected':''}}>Akses Payroll</option>
                  <option value="3" {{old('level')=="3"?'selected':''}}>Akses Direktur Operasional</option>
                </select>
                @if($errors->has('level'))
                  <span class="help-block">
                    <strong>{{ $errors->first('level')}}</strong>
                  </span>
                @endif
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="reset" class="btn btn-danger">Reset Formulir</button>
            <button type="submit" class="btn btn-success pull-right">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-7">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Akun</h3>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Username</th>
                <th>Level Akses</th>
                <th>Tanggal Pembuatan Akun</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @if(count($getuser)!=0)
                @foreach($getuser as $key)
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$key->username}}</td>
                    <td>
                      @if($key->level=="1")
                        Akses HR
                      @elseif($key->level=="2")
                        Akses Payroll
                      @elseif($key->level=="3")
                        Akses Dirops
                      @endif
                    </td>
                    <td>{{$key->created_at}}</td>
                    <td>
                      @if(Auth::check())
                      @if(Auth::user()->pegawai_id==$key->pegawai_id)
                        <span data-toggle="tooltip" title="Anda sedang login menggunakan akun ini">
                          <a class="btn btn-xs btn-danger" disabled><i class="fa fa-remove"></i></a>
                        </span>
                      @else
                        <span data-toggle="tooltip" title="Hapus Data">
                          <a href="" class="btn btn-xs btn-danger hapus" data-toggle="modal" data-target="#myModal" data-value="{{$key->id}}"><i class="fa fa-remove"></i></a>
                        </span>
                      @endif
                      @endif
                    </td>
                  </tr>
                  <?php $i++; ?>
                @endforeach
              @else

              @endif
            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>


  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <script src="{{asset('dist/js/demo.js')}}"></script>
  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".select2").select2();
    });
  </script>

  <script type="text/javascript">
    $(function(){
      $('a.hapus').click(function(){
        var a = $(this).data('value');
        $('#set').attr('href', "{{ url('/') }}/useraccount/delete/"+a);
      });
    });
  </script>
@stop
