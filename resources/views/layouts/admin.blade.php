<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/admin/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{env('APP_URL')}}/vendors/mainpage/assets/img/logo.png" />
    <script src="{{env('APP_URL')}}/vendors/base/vendor.bundle.base.js"></script>
    
  </head>
  <body>
    <div class="container-scroller">	 
		<!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
            <ul class="navbar-nav navbar-nav-left">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <i class="mdi mdi-account"></i><font size="4px" color="white"><b>{{\App\Helper\PaymentHelper::bind_account_number(Auth::user()->name)}}</b></font>
            </div>
            </ul>
           
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="/user">
                <img src="{{env('APP_URL')}}/vendors/admin/images/mlm.png" style="height:50px; width:80px;"><font color="white">AFPA Subscriptions</font></img></a>
            </div>
            
            <ul class="navbar-nav navbar-nav-right">
    
              <li class="nav-item nav-profile dropdown">  
				        <a class="btn btn-danger btn-sm" href="#" data-toggle="dropdown" id="profileDropdown">
                  <i class="mdi mdi-apps"> </i> 
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <span class="dropdown-item dropdown-header bg-danger text-white">ACCOUNTS</span>
                    <div class="dropdown-divider"></div>   
                    <a class="dropdown-item" href="{{ route('admin_change_password')}}"><i class="mdi mdi-key-change text-primary"></i>Change Password</a>              
                                     
                      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                      </form>  
                  </div>
                </li>
            </ul>

            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </div>
      </nav>
      @if(Auth::user()->user_type=='admin')
      <nav class="bottom-navbar">

        <div class="">
          <ul class="nav page-navigation">

            <li class="nav-item {{ Request::segment(1) === 'admin_dashboard' ? 'active' : null }}">
              <a class="nav-link" href="{{route('admin_dashboard')}}">
                <i class="mdi mdi-file-document-box menu-icon"></i>
                <span class="menu-title">Dashboard <i class="mdi mdi-arrow-down"></i></span>
              </a>
            </li>

            <li class="nav-item {{ Request::segment(1) === 'customerrequests'|| Request::segment(1) === 'approvedrequests'
              ||Request::segment(1) === 'rejectedrequests'||Request::segment(1) === 'blockedusers' ? 'active' : null }}">
              <a href="#" class="nav-link ">
                <i class="mdi mdi-cube-outline menu-icon"></i>
                  <span class="menu-title">Customers  </span> 
              </a>
              <div class="submenu">
                <ul>
                  <li class="nav-item"><a class="nav-link" href="{{route('customerrequests')}}">User Requests</a></li>
						      <li class="nav-item"><a class="nav-link" href="{{route('approvedrequests')}}">Approved Users</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('rejectedrequests')}}">Rejected Users</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('blockedusers')}}">Blocked Users</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item {{ Request::segment(1) === 'network_view' ? 'active' : null }}">
              <a href="{{route('network_view')}}" class="nav-link">
                <i class="mdi mdi-account-network menu-icon"></i>
                  <span class="menu-title">Networks </span> 
              </a>
              </li>

            <li class="nav-item {{ Request::segment(1) === 'admin_commission_request_view' ? 'active' : null }}">
              <a href="#" class="nav-link">
                <i class="mdi mdi-cash-100 menu-icon"></i>
                  <span class="menu-title">Commission Requests </span> 
              </a>
              <div class="submenu">
                <ul>
                  <li class="nav-item"><a class="nav-link" href="{{route('admin_commission_request_view')}}">View Requests</a></li>
                </ul>
              </div>
            </li>
            
            <li class="nav-item {{ Request::segment(1) === 'admin_enquiry_view' ? 'active' : null }}">
              <a class="nav-link" href="{{route('admin_enquiry_view')}}">
                <i class="mdi mdi-comment-processing-outline menu-icon"></i>
                <span class="menu-title">Enquiries </span>
              </a>
            </li>

            <li class="nav-item {{ Request::segment(1) === 'admin_payment_history' ? 'active' : null }}">
              <a href="#" class="nav-link">
                <i class="mdi mdi-cash-100 menu-icon"></i>
                  <span class="menu-title">Payments</span> 
              </a>
              <div class="submenu">
                <ul>
                  <li class="nav-item"><a class="nav-link" href="{{route('admin_payment_history')}}">Subscription Payment History</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item {{ Request::segment(1) === 'admin_payment_report_view' ||Request::segment(1) === 'admin_commission_report_view' ? 'active' : null }}">
              <a href="#" class="nav-link">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                  <span class="menu-title">Reports </span> 
              </a>
              <div class="submenu">
                <ul>
                <li class="nav-item"><a class="nav-link" href="{{route('admin_payment_report_view')}}">Subscription Payment Reports</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('admin_commission_report_view')}}">Commission Payout Reports</a></li>
	<li class="nav-item"><a class="nav-link" href="{{route('customer_bank_report')}}">Customer Bank Report</a></li>					      
                </ul>
              </div>
              
            </li>
        </div>
      </nav>
      @endif
</div>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
			<div class="main-panel">
				<div class="content-wrapper">
   
          @yield('content')
          
        </div>
      </div>
    </div>
            <!-- content-wrapper ends -->
				<!-- partial:partials/_footer.html -->
				<footer class="footer">
          <div class="footer-wrap">
              <div class="w-100 clearfix">
                <span class="d-block text-center text-sm-left d-sm-inline-block">Developed By <a href="http://faithinfosoft.com/" target="_blank"><b>Faith Infosoft</b></a>.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> All rights reserved. <i class="mdi mdi-heart-outline"></i></span>
              </div>
          </div>
        </footer>
				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
    </div>
		<!-- container-scroller -->
    <!-- base:js -->
    
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
   
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->
    <script src="{{env('APP_URL')}}/vendors/admin/js/template.js"></script>
    <script src="{{env('APP_URL')}}/vendors/chart.js/Chart.min.js"></script>
    <script src="{{env('APP_URL')}}/vendors/progressbar.js/progressbar.min.js"></script>
		<script src="{{env('APP_URL')}}/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js"></script>
		<script src="{{env('APP_URL')}}/vendors/justgage/raphael-2.1.4.min.js"></script>
		<script src="{{env('APP_URL')}}/vendors/justgage/justgage.js"></script>
    <!-- Custom js for this page-->
    <script src="{{env('APP_URL')}}/vendors/admin/js/dashboard.js"></script>
    <!-- End custom js for this page-->
  </body>
</html>