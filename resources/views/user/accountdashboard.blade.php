@extends('layouts.user')
@section('content')

<div class="row">
	<div class="col-sm-12 flex-column d-flex stretch-card">
		<div class="row">
			<div class="col-lg-4 d-flex grid-margin stretch-card">
				<div class="card sale-diffrence-border">
					<div class="card-body">
						<h2 class="text-dark mb-2 font-weight-bold">Total Earnings</h2>
						<small><b>Total earnings from {{\App\Helper\PaymentHelper::bind_account_number($acct_id)}}</b></small><br><br>
						<h4 class="card-title mb-2">&#x20B9; {{\App\Helper\PaymentHelper::total_earnings($acct_id)}}</h4>
						As on {{date('d-M, Y')}}
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
				
<!-- partial -->
<!--<div class="row mt-0">
	<div class="col-lg-7 grid-margin stretch-card">
		<div class="card card-danger card-outline card-outline-danger">
			<div class="card-header">
				<h4 class="card-title">Earnings Graph</h4>
            </div>
			<div class="card-body">	 
            <ul class="nav nav-tabs tab-no-active-fill" role="tablist">
									<li class="nav-item">
										<a class="nav-link active pl-2 pr-2" id="revenue-for-last-month-tab" data-toggle="tab" href="#revenue-for-last-month" role="tab" aria-controls="revenue-for-last-month" aria-selected="true">Revenue for last month</a>
									</li>
									<li class="nav-item">
										<a class="nav-link pl-2 pr-2" id="server-loading-tab" data-toggle="tab" href="#server-loading" role="tab" aria-controls="server-loading" aria-selected="false">Server loading</a>
									</li>
									<li class="nav-item">
										<a class="nav-link pl-2 pr-2" id="data-managed-tab" data-toggle="tab" href="#data-managed" role="tab" aria-controls="data-managed" aria-selected="false">Data managed</a>
									</li>
									<li class="nav-item">
										<a class="nav-link pl-2 pr-2" id="sales-by-traffic-tab" data-toggle="tab" href="#sales-by-traffic" role="tab" aria-controls="sales-by-traffic" aria-selected="false">Sales by traffic</a>
									</li>
								</ul>

                                <div class="tab-content tab-no-active-fill-tab-content">
									<div class="tab-pane fade show active" id="revenue-for-last-month" role="tabpanel" aria-labelledby="revenue-for-last-month-tab">
										<div class="d-lg-flex justify-content-between">
											<p class="mb-4">+5.2% vs last 7 days</p>
											<div id="revenuechart-legend" class="revenuechart-legend">f
											</div>
										</div>
										<canvas id="revenue-for-last-month-chart"></canvas>
									</div>

									<div class="tab-pane fade" id="server-loading" role="tabpanel" aria-labelledby="server-loading-tab">
										<div class="d-flex justify-content-between">
											<p class="mb-4">+5.2% vs last 7 days</p>
											<div id="serveLoading-legend" class="revenuechart-legend">f
											</div>
										</div>
										<canvas id="serveLoading"></canvas>
									</div>	

									<div class="tab-pane fade" id="data-managed" role="tabpanel" aria-labelledby="data-managed-tab">
										<div class="d-flex justify-content-between">
											<p class="mb-4">+5.2% vs last 7 days</p>
											<div id="dataManaged-legend" class="revenuechart-legend">f
											</div>
										</div>
										<canvas id="dataManaged"></canvas>
									</div>

									<div class="tab-pane fade" id="sales-by-traffic" role="tabpanel" aria-labelledby="sales-by-traffic-tab">
										<div class="d-flex justify-content-between">
											<p class="mb-4">+5.2% vs last 7 days</p>
											<div id="salesTrafic-legend" class="revenuechart-legend">f
										</div>
									</div>
									<canvas id="salesTrafic"></canvas>
								</div>
		    </div></div>
	    </div>  -->

	<div class="col-lg-12">
		<div class="card card-success card-outline card-outline-danger">
			<div class="card-header">
				<h4 class="card-title">Your Account</h4>
            </div>
			@php $no = 1; @endphp
			<div class="card-body">						
				@foreach($accounts as $account)
					<div class="alert alert-danger "><font color="black"><b><u>{{__('Account ')}}{{$no++}} </u></b> <br><br>
                        <b>Account Number :</b> {{\App\Helper\PaymentHelper::bind_account_number($account->acct_id)}}<br>
						<b>Account Type :</b> {{$account->acct_type}}<br>
						<b>Created On :</b> {{\App\Helper\PaymentHelper::convert_date_format($account->created_at)}}<br></font>	
						@if($account->status=='requested')
						<font color="red"><b>Status :</b>Your account is waiting for admin approval..!!</font><br><br>
						@elseif($account->status=='Progress')
						<font color="red"><b>Status :</b>Incomplete account creation..!!</font><br><br>
						@elseif($account->status=='Deactivated')
						<font color="red"><b>Status :</b>Account request Rejected !!</font><br><br>
						@endif
						@if($account->status=="Progress" && $account->acct_type !="Primary" )
							<a href="{{ route('sendaccountrequest',$account->acct_id) }}"><button type="button" class="btn btn-primary">Send request for approval</button></a>
						@endif
					</div>
				@endforeach
			</div>
            <div class="col-lg-12">
		<div class="alert alert-success">
			<b>{{__('Your Referral link : ')}} </b> 
			<br><br>
			<div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
									<button onclick=myFunction() class=" btn btn-outline-danger btn-fw" title="Copy your referral link !!"><i class="mdi mdi-content-copy"></i>  </button>
                                </div>
								@foreach($accounts as $account)
                                <input id="referral" type="text" class="form-control col-md-12" name="referral" readonly="readonly" value="{{ url('/register?ref=' . $account->acct_id) }}">
                            @endforeach
                            </div>
                        </div>		
		</div>
	</div>
		</div>	
	</div>
    
</div>

</div>

		</div>	
			
			

				

					
			
				
	

<script>
    function myFunction() 
    {
        var copyText = document.getElementById("referral");
        copyText.select();
        copyText.setSelectionRange(0, 9999999999)
        document.execCommand("copy");
        alert("Copied the referral link !!!");
    }
</script>

@endsection