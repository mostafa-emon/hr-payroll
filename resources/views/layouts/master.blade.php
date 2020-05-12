<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@if(!isset(app()->view->getSections()['title'])) Axis Cheque & MR @else {{ app()->view->getSections()['title'] }} @endif</title>
    <link rel="icon" href="{{asset('img/favicon.png')}}">

    <link href="{{asset('lib/font-awesome/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/Ionicons/css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('lib/jquery-switchbutton/jquery.switchButton.css')}}" rel="stylesheet">
    <link href="{{asset('lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/chartist/chartist.css')}}" rel="stylesheet">
    <link href="{{asset('lib/datatables/jquery.dataTables.css')}}" rel="stylesheet">
    <link href="{{asset('lib/datatables/buttons.dataTables.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/bracket.css')}}">

  </head>

  <body>
    <div class="br-logo text-center"><a href="#"><img src="{{asset('img/logo.png')}}" height="60"/></a></div>

    <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
      <div class="br-sideleft-menu">

        <a  class="br-menu-link {{ (request()->is('dashboard')) || (request()->is('/')) || (request()->is('home')) ? 'active' : '' }}" href="{{url('dashboard')}}">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-md-home tx-22"></i>
            <span class="menu-item-label">Dashboard</span>
          </div>
        </a>

        <a href="#" class="br-menu-link {{ (request()->is('company*')) || (request()->is('site-office*')) || (request()->is('customer*')) || (request()->is('supplier*')) || (request()->is('cheque-layouts*')) || (request()->is('bank*')) || (request()->is('cheque-books*')) || (request()->is('currency*')) || (request()->is('payment-method*')) || (request()->is('role*')) || (request()->is('user*')) ? 'active show-sub' : '' }}">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-settings tx-24"></i>
            <span class="menu-item-label">Master Setup</span>
            <i class="menu-item-arrow fas fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="{{ url('company') }}" class="nav-link {{ (request()->is('company')) ? 'active' : '' }}">Company Setup</a></li>
          <li class="nav-item"><a href="{{ url('site-office') }}" class="nav-link {{ (request()->is('site-office*')) ? 'active' : '' }}">Site Offices</a></li>
          <li class="nav-item"><a href="{{ url('customer') }}" class="nav-link {{ (request()->is('customer*')) ? 'active' : '' }}">Customers</a></li>
          <li class="nav-item"><a href="{{ url('supplier') }}" class="nav-link {{ (request()->is('supplier*')) ? 'active' : '' }}">Suppliers</a></li>
          <li class="nav-item"><a href="{{ url('cheque-layouts') }}" class="nav-link {{ (request()->is('cheque-layouts*')) ? 'active' : '' }}">Cheque Formats</a></li>
          <li class="nav-item"><a href="{{url('bank')}}" class="nav-link {{ (request()->is('bank')) || (request()->is('bank/add')) || (request()->is('bank/update*')) ? 'active' : '' }}">Bank</a></li>
          <li class="nav-item"><a href="{{url('bank-account')}}" class="nav-link {{ (request()->is('bank-account*')) ? 'active' : '' }}">Bank Accounts</a></li>
          <li class="nav-item"><a href="{{url('cheque-books')}}" class="nav-link {{ (request()->is('cheque-books*')) ? 'active' : '' }}">Cheque Books</a></li>
          <li class="nav-item"><a href="{{url('currency')}}" class="nav-link {{ (request()->is('currency*')) ? 'active' : '' }}">Currency</a></li>
          <li class="nav-item"><a href="{{url('payment-method')}}" class="nav-link {{ (request()->is('payment-method*')) ? 'active' : '' }}">Payment Method</a></li>
          <li class="nav-item"><a href="{{url('roles')}}" class="nav-link {{ (request()->is('roles*')) ? 'active' : '' }}">Roles</a></li>
          <li class="nav-item"><a href="{{url('user')}}" class="nav-link {{ (request()->is('user*')) ? 'active' : '' }}">Users</a></li>
        </ul>

        <a href="#" class="br-menu-link {{ (request()->is('cheque-transactions*')) || (request()->is('mr*')) ? 'active show-sub' : '' }}">
          <div class="br-menu-item">
            <i class="menu-item-icon fa fa-file-alt tx-19 pd-l-2"></i>
            <span class="menu-item-label">Transaction</span>
            <i class="menu-item-arrow fas fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="{{ url('mr') }}" class="nav-link  {{ (request()->is('mr*')) ? 'active' : '' }}">Money Receipt</a></li>
          <li class="nav-item"><a href="{{ url('cheque-transactions') }}" class="nav-link {{ (request()->is('cheque-transactions*')) ? 'active' : '' }}">Cheque</a></li>
        </ul>

        <a href="#" class="br-menu-link  {{ (request()->is('issued-*')) || (request()->is('void-*')) ? 'active show-sub' : '' || (request()->is('audits*')) ? 'active show-sub' : '' }}">
          <div class="br-menu-item">
            <i class="menu-item-icon fa fa-chart-bar tx-19"></i>
            <span class="menu-item-label">Reports</span>
            <i class="menu-item-arrow fas fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="{{ url('issued-mr') }}" class="nav-link {{ (request()->is('issued-mr*')) ? 'active' : '' }}">Issued MR</a></li>
          <li class="nav-item"><a href="{{ url('void-mr') }}" class="nav-link {{ (request()->is('void-mr*')) ? 'active' : '' }}">Void MR</a></li>
          <li class="nav-item"><a href="{{ url('issued-cheque') }}" class="nav-link {{ (request()->is('issued-cheque*')) ? 'active' : '' }}">Issued Cheque</a></li>
          <li class="nav-item"><a href="{{ url('void-cheque') }}" class="nav-link {{ (request()->is('void-cheque*')) ? 'active' : '' }}">Void Cheque</a></li>
          <li class="nav-item"><a href="{{ url('audits') }}" class="nav-link {{ (request()->is('audits*')) ? 'active' : '' }}">Audit Trail</a></li>
        </ul>

        <a href="#" class="br-menu-link {{ (request()->is('settings')) || (request()->is('printer*')) ? 'active show-sub' : '' }}">
          <div class="br-menu-item">
            <i class="menu-item-icon fa fa-tools tx-14"></i>
            <span class="menu-item-label">Configuration</span>
            <i class="menu-item-arrow fas fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="{{url('printer')}}" class="nav-link {{ (request()->is('printer*')) ? 'active' : '' }}">Printer</a></li>
          <li class="nav-item"><a href="{{url('settings')}}" class="nav-link {{ (request()->is('settings')) ? 'active' : '' }}">Settings</a></li>
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

    <script src="{{asset('lib/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('lib/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('lib/datatables/buttons.flash.min.js')}}"></script>
    <script src="{{asset('lib/datatables/jszip.min.js')}}"></script>
    <script src="{{asset('lib/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('lib/datatables/vfs_fonts.js')}}"></script>
    <script src="{{asset('lib/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('lib/datatables/buttons.print.min.js')}}"></script>

    <script src="{{asset('js/bracket.js')}}"></script>
    <script src="{{asset('js/ResizeSensor.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
    
    <script>
        $(".form-layout .form-control").on("focusin", function () {
          $(this).closest(".form-group").addClass("form-group-active");
        });

        $(".form-layout .form-control").on("focusout", function () {
          $(this).closest(".form-group").removeClass("form-group-active");
        });

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: ''
          },
          dom: 'Bfrtip',
          buttons: [
              {
                extend: 'excel'
              },
              {
                extend: 'pdf',
              },
              {
                extend: 'print',
                customize: function ( win ) {
                    $(win.document.body).find( 'h1' )
                    .css( 'font-size', '18px');

                    $(win.document.body).find( 'h1' )
                    .css( 'text-align', 'center');

                    $(win.document.body).find('table').css('font-size', '10pt');
                }
            }
          ],
        });

        $('#dtable').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: ''
          },
          dom: 'Bfrtip',
          buttons: [
              {
                extend: 'excel'
              }
          ],
        });

        $('#datatable2').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
          },
          "lengthChange": false
        });

        $('#dtpick1').datepicker({ dateFormat: 'dd-mm-yy' });
        $('#dtpick2').datepicker({ dateFormat: 'dd-mm-yy' });
    </script>
  </body>

</html>
