<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Axis Cheque & MR</title>
    <link rel="icon" href="{{asset('img/favicon.png')}}">

    <link href="{{asset('lib/font-awesome/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/Ionicons/css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('lib/jquery-switchbutton/jquery.switchButton.css')}}" rel="stylesheet">
    <link href="{{asset('lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/chartist/chartist.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/bracket.css')}}">

  </head>

  <body>

    <div class="br-logo"><a href="#"><img src="{{asset('img/logo2.png')}}" height="40"/></a></div>

    <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
      <div class="br-sideleft-menu">

        <a  class="br-menu-link {{ (request()->is('dashboard')) ? 'active' : '' }}" href="{{url('dashboard')}}">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-home tx-22"></i>
            <span class="menu-item-label">Dashboard</span>
          </div>
        </a>

        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Company</span>
            <i class="menu-item-arrow fas fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="#" class="nav-link">Information</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Site Offices</a></li>
        </ul>
        
        <a class="br-menu-link {{ (request()->is('customer*')) ? 'active' : '' }}" href="{{url('customer')}}">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-people tx-22"></i>
            <span class="menu-item-label">Customers</span>
          </div>
        </a>

        <a  class="br-menu-link  {{ (request()->is('supplier*')) ? 'active' : '' }} " href="{{url('supplier')}}">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-person tx-22"></i>
            <span class="menu-item-label">Suppliers</span>
          </div>
        </a>

        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Bank</span>
            <i class="menu-item-arrow fas fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="#" class="nav-link">Bank List</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Bank Accounts</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Check Books</a></li>
        </ul>

        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Transaction</span>
            <i class="menu-item-arrow fas fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="#" class="nav-link">Money Receipt</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Cheque</a></li>
        </ul>

        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Reports</span>
            <i class="menu-item-arrow fas fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="#" class="nav-link">Issued MR</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Void MR</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Issued Cheque</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Void Cheque</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Audit Trail</a></li>
        </ul>
        
        <a  href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Users</span>
          </div>
        </a>

        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Configuration</span>
            <i class="menu-item-arrow fas fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
        <li class="nav-item"><a href="{{url('currency')}}" class="nav-link">Currency</a></li>
          <li class="nav-item"><a href="{{url('paymentmethod')}}" class="nav-link">Payment Method</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Settings</a></li>
        </ul>
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
              <span class="logged-name hidden-md-down">Katherine</span>
              <img src="{{asset('img/img1.jpg')}}" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                <li><a href="#"><i class="icon ion-ios-person"></i> Edit Profile</a></li>
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
          <div class="mg-b-2">&copy; {{ date('Y') }}. Axis Cheque & MR. All Rights Reserved.</div>
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


    <script src="{{asset('js/bracket.js')}}"></script>
    <script src="{{asset('js/ResizeSensor.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
    
  </body>

</html>
