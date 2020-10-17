<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@if(!isset(app()->view->getSections()['title'])) Axis QB Voucher @else {{ app()->view->getSections()['title'] }} @endif</title>
    <link rel="icon" href="{{asset('img/favicon.png')}}">

    <link href="{{asset('lib/font-awesome/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/Ionicons/css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('lib/jquery-switchbutton/jquery.switchButton.css')}}" rel="stylesheet">
    <link href="{{asset('lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/chartist/chartist.css')}}" rel="stylesheet">
    <link href="{{asset('lib/datatables/jquery.dataTables.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/bracket.css')}}">

  </head>

  <body>
    <div class="br-logo text-center" style="padding-left:70px"><a href="#"><img src="{{asset('img/logo.png')}}" height="38"/></a></div>

    <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
      <div class="br-sideleft-menu">

        <a  class="br-menu-link {{ (request()->is('dashboard')) || (request()->is('/')) || (request()->is('home')) ? 'active' : '' }}" href="{{url('dashboard')}}">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-md-home tx-22"></i>
            <span class="menu-item-label">Dashboard</span>
          </div>
        </a>

        @if(roles() != "" && in_array(100, json_decode(roles(),false)))
        <a  class="br-menu-link {{ (request()->is('subscription')) || (request()->is('company-register')) ? 'active' : '' }}" href="{{url('subscription')}}">
          <div class="br-menu-item">
            <i class="menu-item-icon fa fa-id-card tx-15"></i>
            <span class="menu-item-label">Subscription</span>
          </div>
        </a>
        @endif

        @if(roles() != "" && !in_array(100, json_decode(roles(),false)))
        
        @endif

      </div>

      <br>
    </div>

    <div class="br-header">

      <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="fa fa-bars"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i class="fa fa-bars"></i></a></div>
      </div>

      <div class="br-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down">{{ Auth::user()->name }}</span>
              @if(Auth::user()->avatar != "")
                  <img src="{{asset('storage/'.Auth::user()->avatar)}}" class="wd-32 rounded-circle" alt="">
              @else
                  <img src="{{asset('img/user.png')}}" class="wd-32 rounded-circle" alt="">
              @endif
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                <li><a href="{{ url('user/profile/'.Auth::user()->id) }}"><i class="icon ion-ios-person"></i> Edit Profile</a></li>
                <li><a href="{{ url('logout') }}"><i class="icon ion-md-power"></i> Sign Out</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>
    
    <div class="br-mainpanel">
      @yield('content')

      <footer class="br-footer">
        <div class="footer-left">
          <div class="mg-b-2">&copy; {{ date('Y') }}. Axis QB & Voucher. All Rights Reserved.</div>
        </div>
      </footer>
    </div>
    
    <script src="{{asset('lib/jquery/jquery.js')}}"></script>
    <script src="{{asset('lib/popper.js/popper.js')}}"></script>
    <script src="{{asset('lib/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
    <script src="{{asset('lib/moment/moment.js')}}"></script>
    <script src="{{asset('lib/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('lib/jquery-switchbutton/jquery.switchButton.js')}}"></script>
    <script src="{{asset('lib/peity/jquery.peity.js')}}"></script>
    <script src="{{asset('lib/chartist/chartist.js')}}"></script>
    <script src="{{asset('lib/jquery.sparkline.bower/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('lib/d3/d3.js')}}"></script>
    <script src="{{asset('lib/rickshaw/rickshaw.min.js')}}"></script>

    <script src="{{asset('lib/datatables/jquery.dataTables.js')}}"></script>

    <script src="{{asset('js/bracket.js')}}"></script>
    <script src="{{asset('js/ResizeSensor.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
    
    <script>
        $('#datatable').DataTable();

        $(".form-layout .form-control").on("focusin", function () {
          $(this).closest(".form-group").addClass("form-group-active");
        });

        $(".form-layout .form-control").on("focusout", function () {
          $(this).closest(".form-group").removeClass("form-group-active");
        });

        var i;
        for(i = 1; i <= 100; i++){
          $('#dtpick'+i).datepicker({ dateFormat: 'dd-mm-yy' });
        }
    </script>
  </body>

</html>
