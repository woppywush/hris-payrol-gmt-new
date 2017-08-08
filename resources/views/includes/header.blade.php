<a href="{{ url('')}}" class="logo">
  <span class="logo-mini"><b>GMT</b></span>
  <span class="logo-lg" style="font-size:18px;"><b>GMT</b>
    @if (session('level') == 1)
      Human Resources
    @elseif (session('level') == 2)
      Payroll System
    @elseif (session('level') == 3)
      Direktur Operasional
    @endif
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
          @if(Auth::check())
          @if(Auth::user()->url_foto!="")
            <img src="{{url('images')}}/{{Auth::user()->url_foto}}" class="user-image" alt="User Image">
          @else
            <img src="{{url('images')}}/user-not-found.png" class="user-image" alt="User Image">
          @endif
            <span class="hidden-xs">
              @if(Auth::user())
                {{ Auth::user()->username }}
              @endif
          @endif
            </span>
        </a>
        <ul class="dropdown-menu">
          <li class="user-header">
            @if(Auth::check())
            @if(Auth::user()->url_foto!="")
              <img src="{{url('images')}}/{{Auth::user()->url_foto}}" class="img-circle" alt="User Image">
            @else
              <img src="{{url('images')}}/user-not-found.png" class="img-circle" alt="User Image">
            @endif
            <p>
              @if(Auth::user())
                {{ Auth::user()->username}}
                <small>{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d-M-y')}}</small>
              @endif
            @endif
            </p>
          </li>

          <li class="user-footer">
            <div class="pull-left">
              @if(Auth::check())
              <a href="{{ url('useraccount/kelola-profile') }}/{{Auth::user()->id}}" class="btn btn-default btn-flat">Profile</a>
              @endif
            </div>
            <div class="pull-right">
              <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
