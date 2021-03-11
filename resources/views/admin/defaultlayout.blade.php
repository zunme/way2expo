<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Way2 Admin</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Noto+Sans+KR:100,300,400,500,600,700,900|Material+Icons">
  <link rel="stylesheet" href="/admin_assets/stisla/node_modules/ionicons201/css/ionicons.min.css">


    <!-- CSS Libraries -->
  <!--<link rel="stylesheet" href="/admin_assets/stisla/node_modules/jqvmap/dist/jqvmap.min.css">-->
  <!--link rel="stylesheet" href="/admin_assets/stisla/node_modules/summernote/dist/summernote-bs4.css">
  <link rel="stylesheet" href="/admin_assets/stisla/node_modules/owl.carousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="/admin_assets/stisla/node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="/admin_assets/stisla/node_modules/ionicons201/css/ionicons.min.css"-->
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="/admin_assets/stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/admin_assets/stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">

  <link rel="stylesheet" href="/admin_assets/stisla/node_modules/bootstrap-daterangepicker/daterangepicker.css">
   <link rel="stylesheet" href="/admin_assets/stisla/node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
   <link rel="stylesheet" href="/admin_assets/stisla/node_modules/select2/dist/css/select2.min.css">
   <link rel="stylesheet" href="/admin_assets/stisla/node_modules/selectric/public/selectric.css">
   <link rel="stylesheet" href="/admin_assets/stisla/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
   <link rel="stylesheet" href="/admin_assets/stisla/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="/admin_assets/stisla/node_modules/izitoast/dist/css/iziToast.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="/admin_assets/stisla/assets/css/style.css">
  <link rel="stylesheet" href="/admin_assets/stisla/assets/css/components.css">
  <style>
  .mb-0{margin-bottom: 0px !important;}
  .mb-5{margin-bottom: 5px !important;}
  .mb-10{margin-bottom: 10px !important;}
  .mb-15{margin-bottom: 15px !important;}
  .mb-20{margin-bottom: 20px !important;}
  .splitline{border-bottom: 1px solid rgba(0,0,0,.125);}
  .chocolat-wrapper{z-index: 1000 !important;}
  .dataTables_length label select {
    padding-right: 30px !important;
  }
  .inline-select{
    width: auto;
    display: inline-block;
  }
  .form-control-sm {
    height: calc(1.5em + .5rem + 2px) !important;
    padding: .25rem .5rem !important;
    font-size: .875rem !important;
    line-height: 1.5;
    border-radius: .2rem;
 }
  </style>
  @yield('css')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <!--li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li-->
          </ul>

        </form>
        <ul class="navbar-nav navbar-right">

          <!--li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
              <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">

                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-icon bg-primary text-white">
                    <i class="fas fa-code"></i>
                  </div>
                  <div class="dropdown-item-desc">
                    Template update is available now!
                    <div class="time text-primary">2 Min Ago</div>
                  </div>
                </a>

              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li-->

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="https://ui-avatars.com/api/?name={{auth()->user()->email}}&background=0D8ABC&color=fff" class="rounded-circle mr-1" style="width:42px;">
            <div class="d-sm-none d-lg-inline-block">Hi, {{auth()->user()->email}}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

              <a href="#" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">Way2Expo</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">W2E</a>
          </div>
          <ul class="sidebar-menu">

            <!-- 메뉴 -->
            <li class="menu-header">User</li>
            <li class="{{ (request()->is('admin/user')) ? 'active' : '' }}">
              <a class="nav-link" href="/admin/user"><i class="far fa-user"></i> <span>사용자</span></a>
            </li>
            <li class="{{ (request()->is('admin/company')) ? 'active' : '' }}">
              <a class="nav-link" href="/admin/company"><i class="far fa-building"></i> <span>기업</span></a>
            </li>
            <li class="menu-header">Expo & Booth</li>
              <li class="{{ (request()->is('admin/expo')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/expo">
                  @if (request()->is('admin/expo'))
                  <img alt="image" src="https://ui-avatars.com/api/?name=expo&background=6777ef&color=fff" class="rounded-circle" style="width:24px;    margin-right: 20px;">
                  @else
                  <img alt="image" src="https://ui-avatars.com/api/?name=expo&background=666&color=fff" class="rounded-circle" style="width:24px;    margin-right: 20px;">
                  @endif
                  <span>박람회</span></a>
              </li>
              <li class="{{ (request()->is('admin/booth')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/booth"><i class="fas fa-door-open"></i> <span>부스</span></a>
              </li>
              <li class="{{ (request()->is('/admin/entry')) ? 'active' : '' }}">
                  <a class="nav-link" href="/admin/entry"><i class="fas fa-list"></i> <span>출품신청내역</span></a>
              </li>
              <li class="{{ (request()->is('admin/product')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/product"><i class="fas fa-person-product"></i> <span>상품</span></a>
              </li>
              <li class="menu-header">ETC</li>

              <li class="{{ (request()->is('admin/banner')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/banner"><i class="fas fa-ad"></i> <span>배너</span></a>
              </li>
              <li class="{{ (request()->is('admin/config')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/config"><i class="fas fa-ad"></i> <span>config</span></a>
              </li>

              <li class="{{ (request()->is('admin/vod')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/vod">
					<i class="fas fa-ad"></i> <span>VOD</span></a>
              </li>

              <li class="{{ (request()->is('admin/meeting')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/meeting"><i class="fas fa-video"></i> <span>1:1 리스트</span></a>
              </li>

              <li class="{{ (request()->is('admin/category')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/category"><i class="fas fa-tags"></i> <span>카테고리 관리</span></a>
              </li>

              <li class="{{ (request()->is('admin/contact')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/contact"><i class="fas fa-list"></i> <span>제휴문의</span></a>
              </li>

              <li class="{{ (request()->is('admin/posts')) ? 'active' : '' }}">
                <a class="nav-link" href="/admin/posts"><i class="fas fa-list"></i> <span>공지사항</span></a>
              </li>

              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Auth</span></a>
                <ul class="dropdown-menu">
                  <li><a href="auth-forgot-password.html">Forgot Password</a></li>
                  <li><a href="auth-login.html">Login</a></li>
                  <li><a class="beep beep-sidebar" href="auth-login-2.html">Login 2</a></li>
                  <li><a href="auth-register.html">Register</a></li>
                  <li><a href="auth-reset-password.html">Reset Password</a></li>
                </ul>
              </li>
              <!-- /메뉴 -->
            </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content main-wrapper-1">
        <section class="section">
          @yield('main')
        </section>
      </div>

    </div>
  </div>

  <div class="overlay" id="ajaxloading" style="display:none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>

  <div class="modal fade" id="modal-sm" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" id="modal-sm-area">
    </div>
  </div>
  <div class="modal fade" id="modal-lg" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" id="modal-lg-area">
    </div>
  </div>

  <div class="modal fade" id="modal-xl" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" id="modal-xl-area">

    </div>
  </div>

  <div class="modal fade" id="modal-default" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" id="modal-default-area">
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.31/moment-timezone.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.31/moment-timezone-utils.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.31/moment-timezone-with-data-10-year-range.js"></script>

  <script src="/admin_assets/stisla/assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="/admin_assets/stisla/node_modules/prismjs/prism.js"></script>
  <!--script src="/admin_assets/stisla/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/summernote/dist/summernote-bs4.js"></script>
  <script src="/admin_assets/stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script-->
  <script src="/admin_assets/stisla/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/cleave.js/dist/cleave.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/cleave.js/dist/addons/cleave-phone.us.js"></script>
  <!--<script src="/admin_assets/stisla/node_modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>-->
  <script src="/admin_assets/stisla/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="/admin_assets/stisla/node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/select2/dist/js/select2.full.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/select2/dist/js/i18n/ko.js"></script>
  <script src="/admin_assets/stisla/node_modules/selectric/public/jquery.selectric.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/izitoast/dist/js/iziToast.min.js"></script>
  <script src="/admin_assets/stisla/node_modules/sweetalert/dist/sweetalert.min.js"></script>
  <!-- Template JS File -->
  <script src="/admin_assets/stisla/assets/js/scripts.js"></script>
  <script src="/admin_assets/stisla/assets/js/custom.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>

  <script>

  $(function() {
      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      $(document).ajaxStart( function() {
        $("#ajaxloading").show();
      })
      $(document).ajaxStop( function() {
        $("#ajaxloading").hide();
      })
    });
  Handlebars.registerHelper('isEqual', function (expectedValue, value) {
      return value === expectedValue;
  });
  Handlebars.registerHelper('isNotEqual', function (expectedValue, value) {
      return value !== expectedValue;
  });
  Handlebars.registerHelper('checkempty', function(value) {
      if ( typeof value == 'undefined') return true;
      if (value === null) return true;
      else if (value === '') return true;
      else return false;
  });
  Handlebars.registerHelper('checknotempty', function(value) {
      if ( typeof value == 'undefined') return false;
      if (value === null) return false;
      else if (value === '') return false;
      else return true;
  });
  Handlebars.registerHelper('gt', function(a, b) {
      return (a > b);
  });
  Handlebars.registerHelper('gte', function(a, b) {
      return (a >= b);
  });
  Handlebars.registerHelper('lt', function(a, b) {
      return (a < b);
  });
  Handlebars.registerHelper('lte', function(a, b) {
      return (a <= b);
  });
  Handlebars.registerHelper('ne', function(a, b) {
      return (a !== b);
  });
  Handlebars.registerHelper('json', function(context) {
      return JSON.stringify(context);
  });
  function pop_tpl(size, id, data) {
      if (typeof id == 'undefined') return false;
      var availsize = ['sm', 'lg', 'xl']
      if (!availsize.includes(size)) size = 'default';
      var template = Handlebars.compile($("#" + id).html());
      $("#modal-" + size + "-area").html(template(data));

      $("#modal-" + size).modal('handleUpdate')
      $("#modal-" + size).modal('show')
  }

  function ajaxError(jqXHR) {

      if(jqXHR.status != 422 && jqXHR.status != 500 ) {
          alert('잠시후에 이용해주세요');
          console.log ( jqXHR  )
          return;
      }

      var msg;
      var exception;
      if (jqXHR.responseJSON) {
          msg = jqXHR.responseJSON.errors;
          exception = jqXHR.responseJSON.exception;
      }

      if (msg) {
          for (key in msg) {
              if (msg.hasOwnProperty(key)) {
                  if (key.indexOf('.') < 0) {
                      $('input[name=' + key + ']').focus();
                  }

                  if ($.isNumeric(key)) {
                      toastr.error(msg);
                  } else {
                      swal({
                          toast: false,
                          text: msg[key][0],
                          position: 'center',
                          button: true,
                          timer: 3000,
                          icon: "error",
                          // timerProgressBar: true,
                          didOpen: function (toast) {
                              toast.addEventListener('mouseenter', swal.stopTimer)
                              toast.addEventListener('mouseleave', swal.resumeTimer)
                          }
                      });
                      // toastr.error(msg[key][0]);
                  }
                  break;
              }
          }
      } else {
          iziToast.error({
              message: '시스템 오류입니다',
              position: 'topRight'
          });
      }
  }

  </script>
  <!-- Page Specific JS File -->
  @yield('script')
</body>
</html>
