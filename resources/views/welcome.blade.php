@extends('layouts.app')
@section('content')

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
          <div>
            <h1>AFPA GENERAL TRADERS (OPC) PVT LTD</h1>
            <h2><b>Subscriptions</b></h2>
            <h4><font style="font-family:Comic Sans MS">Encourage Others, Earn More..!!</font></h4><br>
            <a href="{{ route('login') }}" class="download-btn" title="Already have an account ? Click here to Sign In !!"><i class="bx bxs-log-in"></i> Sign In</a>
            <a href="{{ route('register') }}" class="download-btn" title="New user ? Click here to register!!"><i class="bx bxs-user-check"></i> Sign Up</a>
          </div>
        </div>
        <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
          <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/hero-img.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= App Features Section ======= -->
    <section id="features" class="features">
      <div class="container">

        <div class="section-title">
          <h2>Subscription Payment Features</h2>
          <p>Recurring payments which automate payments on a schedule.</p>
        </div>

        <div class="row no-gutters">
          <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
            <div class="content d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="bx bx-receipt"></i>
                  <h4>Create And Manage Multiple Subscriptions</h4>
                  <p align="justify">No more worrying about managing multiple subscriptions. 
                      You can simplify the process and even send a consolidated invoice to a customer who has multiple product service subscription.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-cube-alt"></i>
                  <h4>Automate Your Payments</h4>
                  <p align="justify">Fully automated and online payment mode via your wallet balance and card.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-notification"></i>
                  <h4>Notifications</h4>
                  <p align="justify">Notify the users about the payment through phone, e-mail and through our website.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                  <i class="bx bx-shield"></i>
                  <h4>Membership Benefits</h4>
                  <p align="justify">Promoting a high income earning opportunity for its subscribed members.
                  The subscribed members will avail special discounts on their shopping from the company's E- Commerce shopping portal.
                  <br>The subscribed members will earn a monthly commission by referring new members and thereby also promoting company's sales from its shopping portal.
                  </p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                  <i class="bx bx-wallet"></i>
                  <h4>Multiple Payout</h4>
                  <p align="justify">This feature helps to make transactions more simpler. It supports multiple payment modes like e-wallet payment, credit card and others.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                  <i class="bx bx-grid-alt"></i>
                  <h4>User-Friendly Dashboard</h4>
                  <p align="justify">This feature allows easy navigation and simple operations.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/features.svg" class="img-fluid" alt="">
          </div>
        </div>

      </div>
    </section><!-- End App Features Section -->

    <!-- ======= Details Section ======= -->
    <section id="details" class="details">
      <div class="container">

        <div class="row content">
          <div class="col-md-4" data-aos="fade-right">
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/details-1.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-4" data-aos="fade-up">
            <h3>How it Works??</h3>
            <p class="font-italic" align="justify">
            This Software is a web application that helps to manage subscription referral networks such as to keep track on downline’s incomes.
            </p>
            <ul>
              <li><i class="icofont-check"></i> Register and Login as a single person or a company.</li>
              <li><i class="icofont-check"></i> Pay a small amount as their product purchase subscription program.</li>
              <li><i class="icofont-check"></i> Make a person join the subscription referral program and get &#x20B9;8 for each person. </li>
              <li><i class="icofont-check"></i> You can add any number of people to this product purchase subscription program.</li>
              <li><i class="icofont-check"></i> Earn by joining others and get paid for each active members.</li>
            </ul>
            <p align="justify"> 
            The company build and manage their sales force by motivating online and offline independent shoppers.
             </p>
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/details-2.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-4" data-aos="fade-up">
            <h3>Benefits of using AFPA Subscriptions</h3>
            <p class="font-italic" align="justify">
            This is a strategy of E-commerce shopping portal, where normal public can utilise for online shopping for their day to day use of various consumer oriented goods and services with offers and discounts. 
            The subscribed members are entitled with special discounts and income earning opportunity. 
            The website also encourage various Vendors to enlist their products to the company database through separate portal  for promoting their product's purchase and sales.</p>
            <ul>
              <li><i class="icofont-check"></i> Huge potential income.</li>
              <li><i class="icofont-check"></i> Low operating cost.</li>
              <li><i class="icofont-check"></i> Earn Discounts and other benefits.</li>
              <li><i class="icofont-check"></i> There would be attractive incentives and bonus plans for those who excel.</li>
              <li><i class="icofont-check"></i> Work as owner.</li>
            </ul>
            <p align="justify">
            The system is a compensation model for moving a product or service that involves performance-based incentives.</p>
          </div>
        </div>
    </section><!-- End Details Section -->


    

   
    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container">

        <div class="section-title">

          <h2>Frequently Asked Questions</h2>
          <p>Got a question ? We are here to answer.! If you don't see your question here,drop us a line on our contact page..!!</p>
        </div>

        <div class="accordion-list">
          <ul>
            <li data-aos="fade-up" >
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse" href="#accordion-list-1" class="collapsed">
              What company is into and it's profile ?
              <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-1" class="collapse show" data-parent=".accordion-list">
                <p>
                Company is a private limited company with one person as Director, registered under ministry of corporate affairs India.
                Company is into general trading of various consumer oriented goods and services. 
                It's into whole sale trade , retail trade and also into commission trade 
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-2" class="collapsed">
              When is company formed or registered ?
               <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-2" class="collapse" data-parent=".accordion-list">
                <p>
                Company is registered and incorporated on 18 th day  of July 2020.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-3" class="collapsed">
              Where is the office address of the company ?
               <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-3" class="collapse" data-parent=".accordion-list">
                <p>
                Company office is in City named Changanacherry which is in Kottayam District in Kerala State, India.
                Address is Ameera Mahal (Parre Cottage ), A&A Apartments, Ground floor, Fire Station West Road, Changanacherry-686101.
                  </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-4" class="collapsed">
              Does Company is into online sales and trading ?
              <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-4" class="collapse" data-parent=".accordion-list">
                <p>
                Yes. The company is also into direct sales and trading through its E-Commerce Web portal which is very user friendly for the customers.
                   </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-5" class="collapsed">
              Does company provides online opportunity for various Vendors ?
               <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-5" class="collapse" data-parent=".accordion-list">
                <p>
                Yes. Companys Web portal provides excellent facility for various vendors or merchants to enlist their products to the company database.
                Company is into whole sale and retail trade which helps the vendors to sell out their products through our company's purchase channel.
                  </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="500">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-6" class="collapsed">
              Does company has any special compensation plan for the shoppers? 
               <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-6" class="collapse" data-parent=".accordion-list">
                <p>
                Yes.Company has excellent opportunities for its customers who uses its Web portal. 
                Company promotes various offers and discounts for the product  case by case.
                Apart from that company has an amazing income earning compensation plan for its customers who is registered as a paid shopping  subscriber of the company.
                Subscribers are entitled with special discounts on online purchases as well as entitled to receive monthly commissions for referring new subscribed customers for the company there by promoting company's sales and business in various angles.</p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="600">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-7" class="collapsed">
              Does company has branches outside India?
               <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-7" class="collapse" data-parent=".accordion-list">
                <p>
                No. At the moment company is operating only in India. </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="700">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-8" class="collapsed">
              Does the company has other branch offices within India?
               <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-8" class="collapse" data-parent=".accordion-list">
                <p>
                No. At the moment company is operating only from a single office located in Kerala state, India at the mentioned address. </p>
              </div>
            </li>
            <li data-aos="fade-up" data-aos-delay="800">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-9" class="collapsed">
              Does Company has any new ventures proposed for future ?
               <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-9" class="collapse" data-parent=".accordion-list">
                <p>
                Yes. Company is yet to concentrate in the manufacture and supply of various equipment and goods in perspective of electrical, electronics, textiles, metals, furniture and house holds, media, food and beverages etc.,.
                </p>
              </div>
            </li><li data-aos="fade-up" data-aos-delay="900">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-10" class="collapsed">
              Does company is into charity ?
               <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-10" class="collapse" data-parent=".accordion-list">
                <p>
                Yes. Company is in the vision to promotes charity for the poor and needy from the part of its earnings.</p>
              </div>
            </li>

          </ul>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Get in touch with Us..</p>
          <p>Have some questions? Feel free to contact us..</p> </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="row">
              <div class="col-lg-6 info" data-aos="fade-up">
                <i class="bx bx-map"></i>
                <h4>Address</h4>
                Ameera Mahal  (A & A Apartments ), <br>
                Ground floor, Fire Station West Road <br>
                Changanassery, Kerala, India 686101 <br>
              </div>
              <div class="col-lg-6 info" data-aos="fade-up" data-aos-delay="100">
                <i class="bx bx-phone"></i>
                <h4>Call Us</h4>
                <p>+91 9605082808</p>
              </div>
              <div class="col-lg-6 info" data-aos="fade-up" data-aos-delay="200">
                <i class="bx bx-envelope"></i>
                <h4>Email Us</h4>
                <p>info@afpageneraltraders.com</p>
              </div>
              <div class="col-lg-6 info" data-aos="fade-up" data-aos-delay="300">
                <i class="bx bx-time-five"></i>
                <h4>Working Hours</h4>
                <p>Mon - Sat : 8 AM to 8 PM<br>Sunday : Closed</p>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <form action="{{route('enquiry')}}" method="post"  data-aos="fade-up">
            @csrf
              <div class="form-group">
                <input placeholder="Your Name" type="text" name="name" class="form-control" id="name" required data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                <div class="php-email-form validate"></div>
              </div>
              <div class="form-group">
                <input placeholder="Your Email" type="email" class="form-control" name="email" id="email" required data-rule="email" data-msg="Please enter a valid email" />
                <div class="php-email-form validate"></div>
              </div>
              <div class="form-group">
                <input placeholder="Subject" type="text" class="form-control" name="subject" id="subject" required data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="php-email-form validate"></div>
              </div>
              <div class="form-group">
                <textarea placeholder="Message" class="form-control" name="message" rows="5" required data-rule="required" data-msg="Please write something for us"></textarea>
                <div class="php-email-form validate"></div>
              </div>
              <div class="mb-3">
              @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
              </div>
              <div class="text-center"><button type="submit" class="btn btn-primary">Send Message</button></div>
             
            </form>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->


  @endsection
