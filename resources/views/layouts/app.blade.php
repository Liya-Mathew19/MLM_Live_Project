<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>AFPA General Traders (OPC) Pvt Ltd</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/img/logo.png" rel="icon">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
 
  <!-- Vendor CSS Files -->
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/css/style.css" rel="stylesheet">
  <script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/jquery/jquery.min.js"></script>

  <!-- =======================================================
  * Template Name: Appland - v2.2.0
  * Template URL: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
<header id="header"class="fixed-top  header-transparent ">
    <div class="container d-flex align-items-center">
        <a href="/"><img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/logo.png" height="100px" alt=""></a>
      <div class="logo mr-auto">
      </div>
      <nav class="nav-menu d-none d-lg-block">
        <ul>
            <li class="active"><a href="{{env('APP_URL')}}/">Home</a></li>
            <li><a href="{{env('APP_URL')}}#features">Subscription Features</a></li>
            <li><a href="{{env('APP_URL')}}#faq">F.A.Q</a></li>
            <li><a href="{{env('APP_URL')}}#contact">Contact Us</a></li>
            
        </ul>
      </nav><!-- .nav-menu -->
    </div>
  </header><!-- End Header -->
    <!-- ======= Breadcrumbs Section ======= -->
    
  
        @yield('content')
 
  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span>AFPA</span></strong>. All Rights Reserved
      </div>
      <i class="bx bx-chevron-right"></i> <a href="{{route('terms_of_service')}}">Terms of service</a>
      <i class="bx bx-chevron-right"></i> <a href="{{route('privacy_policy')}}">Privacy policy</a>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/ -->
            Developed by <a href="http://faithinfosoft.com/" target="_blank">@ Faith Infosoft</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
 
  <script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/php-email-form/validate.js"></script>
  <script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/venobox/venobox.min.js"></script>
  <script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="{{env('APP_URL')}}/vendors/mainpage/assets/js/main.js"></script>

</body>

</html>