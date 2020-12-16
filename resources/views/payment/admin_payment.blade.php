@extends('layouts.admin')
@section('content')

    <!-- partial -->
    <head>
    <title> RazorPay Integration in PHP - phpexpertise.com </title>
    <meta name="viewport" content="width=device-width">
    <style>
      .razorpay-payment-button {
        margin-top: 10px;
        color: #fff;
    background-color: #464dee;
    border-color: #464dee;
    
      }
    </style>
  </head>

<div class="container">
    <div class="row mt-4">
		<div class="col-lg-12 grid-margin ">
			<div class="card card-danger card-outline card-outline-danger">
				<div class="card-header">
						<h4 class="card-title">Total Cash</h4>
        </div>
        @csrf
				<div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" >
                      <thead>
                        <tr>
                        <th><b> Date</th>
                          <th><b> Name</th>
                          <th><b> Accounts Selected</th>
                          <th> <b> Subscription Fee</th>
                          <th><b>  GST %</th>
                          <th><b>  KFC %</th>
                          <th><b>  Total Amount Given By User</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td>{{App\Helper\PaymentHelper::convert_date_format($subscription_data['date'])}}</td>
                        <td>{{$subscription_data['name']}}</td>
                        <td>{{\App\Helper\PaymentHelper::bind_account_number($subscription_data['accountvalues'])}}</td>
                        <td>&#x20B9;{{$subscription_data['subscription_fee']}}</td>
                        <td>{{$subscription_data['gst_percentage']}}</td>
                        <td>{{$subscription_data['cess_amount']}}</td>
                        <td>&#x20B9;{{$subscription_data['total_amount']}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>  
                    </div>
                </div>
            </div>
        </div>
  

	<div class="row">				
		<div class="col-lg-6 d-flex grid-margin stretch-card">
			<div class="card sale-diffrence-border">
                <div class="card-body">
					<h2 class="text-dark mb-2 font-weight-bold">Cash</h2>
                   
                    <a href="{{route('cashconfirmation',$id)}}">
                    <button class='form-control btn btn-primary submit-button'  type='submit' style="margin-top: 10px;">Paid Via Cash >></button>
                    </a>
                 
                    </div>

			</div>
        </div>
        
		<div class="col-lg-6 d-flex grid-margin stretch-card">
			<div class="card sale-visit-statistics-border">    
                <div class="card-body">
                    <h2 class="text-dark mb-2 font-weight-bold">Bank</h2>
					<a href="{{route('bankconfirmation',$id)}}">
                    <button class='form-control btn btn-primary submit-button'  type='submit' style="margin-top: 10px;">Paid Via Bank >></button>
                    </a>
					
					
				 
               
               
                    </div>
            </div>
		</div>
    
 

 </div>

    </div>
</div>
</div>
@endsection			