<!DOCTYPE html>
<html>
  <head>
    @include('includes.head')
    @yield('title')

    <style media="screen">
      #goTop {
        display: none;
        position: fixed;
        bottom: 35px;
        right: 15px;
        z-index: 99;
        border: none;
        outline: none;
        background-color: black;
        color: white;
        cursor: pointer;
        padding: 7px;
        border-radius: 10px;
      }

      #goTop:hover {
        background-color: navy;
      }
    </style>
  </head>
  <body class="hold-transition skin-blue-light sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        @include('includes.header')
      </header>
      <aside class="main-sidebar">
        @include('includes.sidebar')
      </aside>


      <div class="content-wrapper">
        <section class="content-header">
          @yield('breadcrumb')
        </section>

        <section class="content">

          <div class="modal fade bs-example-modal-sm" id="modalTunggu" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                      <span class="glyphicon glyphicon-time"></span> Mohon Tunggu
                    </h4>
                </div>
                <div class="modal-body">
                  <div class="progress">
                      <div class="progress-bar progress-bar-info progress-bar-striped active" style="width: 100%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @yield('content')
        </section>
        <button onclick="topFunc()" id="goTop" title="Go to top">Top</button>
      </div>

      <footer class="main-footer">
        @include('includes.footer')
      </footer>

    </div>

    <script type="text/javascript">
      window.onscroll = function() {scrollFunction()};

      function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("goTop").style.display = "block";
        } else {
            document.getElementById("goTop").style.display = "none";
        }
      }

      function topFunc() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>

    <script type="text/javascript">
      $(function () {
          $('#modalTunggu').modal('show');
          $.ajax({
              success: function () {
                  $('#modalTunggu').modal('hide');
                  // console.log('Berhasil');
              },
              error: function () {
                  $('#modalTunggu').modal('hide');
                  // console.log('Gagal');
              }
          });
      });
    </script>

  </body>
</html>
