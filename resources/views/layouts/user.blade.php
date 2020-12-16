<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/admin/css/style.css">
    <link rel="shortcut icon" href="{{env('APP_URL')}}/vendors/mainpage/assets/img/logo.png" />
    
    
    <script src="{{env('APP_URL')}}/vendors/base/vendor.bundle.base.js"></script>
    
  </head>
  <body>

		<!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
            <ul class="navbar-nav navbar-nav-left">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <i class="mdi mdi-account"></i><font size="4px" color="white"><b>{{\App\Helper\PaymentHelper::bind_account_number($acct_id)}}</b></font>
            </div>
            </ul>
           
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="{{route('user')}}">
                <img src="{{env('APP_URL')}}/vendors/admin/images/mlm.png" style="height:50px; width:80px;"><font color="white">AFPA Subscriptions</font></img></a>
            </div>
            
            <ul class="navbar-nav navbar-nav-right">
            
            
              <li class="nav-item nav-profile dropdown">  
				        <a class="btn btn-danger btn-sm" href="#" data-toggle="dropdown" id="profileDropdown">
                  <i class="mdi mdi-apps" title="Switch accounts !"> </i> 
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <span class="dropdown-item dropdown-header bg-danger text-white">AFPA ACCOUNTS</span>
                    <div class="dropdown-divider"></div>  
                    @foreach($accounts as $account)   
                    <a class="dropdown-item" href="{{ route('accountdashboard',$account->acct_id)}}" >
                    <i class="mdi mdi-logout text-primary"></i>{{\App\Helper\PaymentHelper::bind_account_number($account->acct_id)}}</a>
                      <form action="{{ route('user') }}" method="POST" class="d-none">
                        @csrf
                      </form> 
                      @endforeach              
                </li>
                <li class="nav-item nav-profile dropdown">  
				        <a class="btn btn-danger btn-sm" href="#" data-toggle="dropdown" id="profileDropdown">
                  <i class="mdi mdi-settings"> </i> 
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <span class="dropdown-item dropdown-header bg-danger text-white">SETTINGS</span>
                    <div class="dropdown-divider"></div>      
                    <a class="dropdown-item" href="{{ route('change_password') }}"><i class="mdi mdi-key-change text-primary"></i>Change Password</a>              
              
                      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="mdi mdi-logout text-primary"></i>Logout</a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                      </form>  
                      
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </div>
      </nav>
      @if(Auth::user()->user_type=='User')
      <nav class="bottom-navbar">
      
        <div class="">
            <ul class="nav page-navigation">
            <li class="nav-item {{ Request::segment(1) === 'user' ? 'active' : null }}">
                <a class="nav-link" href="{{route('user')}}">
                  <i class="mdi mdi-home menu-icon"></i>
                  <span class="menu-title">Home </span>
                </a>
              </li>

              <li class="nav-item {{ Request::segment(1) === 'accountdashboard' ? 'active' : null }}" >
                <a class="nav-link " href="{{route('accountdashboard',$acct_id)}}">
                  <i class="mdi mdi-file-document-box menu-icon"></i>
                  <span class="menu-title">Dashboard <i class="mdi mdi-arrow-down"></i></span>
                </a>
              </li>

              <li class="nav-item {{ Request::segment(1) === 'usernetworktree' ? 'active' : null }}">
                <a class="nav-link" href="{{route('usernetworktree',$acct_id)}}">
                  <i class="mdi mdi-file-tree menu-icon"></i>
                  <span class="menu-title">Network</span>
                </a>
              </li>
              
              <li class="nav-item {{ Request::segment(1) === 'subscriptionpayment' || Request::segment(1) === 'payment_history' ? 'active' : null }}">
                <a class="nav-link" href="#">
                  <i class="mdi mdi-account-card-details menu-icon"></i>
                  <span class="menu-title">Subscription Payment</span>
                </a>
                <div class="submenu">
                      <ul>
                          <li class="nav-item "><a class="nav-link" href="{{route('subscriptionpayment')}}">New Payment</a></li>
                          <li class="nav-item "><a class="nav-link" href="{{route('payment_history')}}">Payment History</a></li>
                      </ul>
                  </div>
              </li>
        @if(Auth::user()->user_status=='Activated')
              <li class="nav-item {{ Request::segment(1) === 'addnewaccount' || Request::segment(1) === 'addaccount' || Request::segment(1) === 'accountview'? 'active' : null }} ">
                  <a href="#" class="nav-link">
                    <i class="mdi mdi-account-multiple-plus menu-icon"></i>
                    <span class="menu-title">Accounts <i class="mdi mdi-arrow-down"></i></span>
                  </a>
                  <div class="submenu">
                      <ul>
                          <li class="nav-item "><a class="nav-link" href="{{route('addnewaccount')}}" onclick="return confirm('Do you want to create a new account ?')">Add Account</a></li>
                          <li class="nav-item "><a class="nav-link" href="{{route('accountview')}}">View Accounts</a></li>
                      </ul>
                  </div>
              </li>
              @else
              <li hidden class="nav-item {{ Request::segment(1) === 'addnewaccount' || Request::segment(1) === 'addaccount' || Request::segment(1) === 'accountview'? 'active' : null }} ">
                  <a href="#" class="nav-link">
                    <i class="mdi mdi-account-multiple-plus menu-icon"></i>
                    <span class="menu-title">Accounts <i class="mdi mdi-arrow-down"></i></span>
                  </a>
                  <div class="submenu">
                      <ul>
                          <li class="nav-item "><a class="nav-link" href="{{route('addnewaccount')}}" onclick="return confirm('Do you want to create a new account ?')">Add Account</a></li>
                          <li class="nav-item "><a class="nav-link" href="{{route('accountview')}}">View Accounts</a></li>
                      </ul>
                  </div>
              </li>
              @endif

              <li class="nav-item {{ Request::segment(1) === 'receiptview' ? 'active' : null }}">
                  <a href="#" class="nav-link">
                    <i class="mdi mdi mdi-receipt menu-icon"></i>
                    <span class="menu-title">Receipts <i class="mdi mdi-arrow-down"></i></span>
                  </a>
                  <div class="submenu">
                      <ul>
                          <li class="nav-item"><a class="nav-link" href="{{route('receiptview')}}">View Receipts</a></li>
                      </ul>
                  </div>
              </li>

              <li class="nav-item {{ Request::segment(1) === 'commission_requests' || Request::segment(1) === 'income_details' ? 'active' : null }}">
                <a class="nav-link" href="">
                  <i class="mdi mdi-cash-100 menu-icon"></i>
                  <span class="menu-title">Commissions</span>
                </a>
                <div class="submenu">
                <ul>
                <li style="display:none;" class="nav-item"><a class="nav-link" href="{{route('income_details')}}">Income Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('commission_requests')}}">Commission Withdrawals</a></li>
						      
                </ul>
              </div>
              </li>

              <li class="nav-item {{ Request::segment(1) === 'user_payment_report_view' ||  Request::segment(1) === 'user_commission_report_view' ? 'active' : null }}">
              <a href="#" class="nav-link">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                  <span class="menu-title">Reports </span> 
              </a>
              <div class="submenu">
                <ul>
                <li class="nav-item"><a class="nav-link" href="{{route('user_payment_report_view')}}">Subscription Payment Reports</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('user_commission_report_view')}}">Commission Payout Reports</a></li>
						      
                </ul>
              </div>
              
            </li>
            </ul>
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
   
    <script src="{{env('APP_URL')}}/vendors/admin/js/template.js"></script>
    <!-- <script src="{{env('APP_URL')}}/js/client.js"></script> -->
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->
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