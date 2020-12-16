@extends('layouts.admin')
@section('content')
    <!-- partial -->
					 <div class="row mt-4">
						<div class="col-lg-8 grid-margin stretch-card">
							<div class="card card-danger card-outline card-outline-danger">
								<div class="card-header">
									<h4 class="card-title">Accounts Requests</h4>
								</div>
								<div class="card-body">
									<div class="col-sm-12">
										<ul class="graphl-legend-rectangle">
											<li><span class="bg-danger"></span><a href="{{route('customerrequests')}}">New User Requests  ({{$count}})</a></li>
											<li><span class="bg-warning"></span><a href="{{route('accountrequests')}}">New Account Requests({{$counts}})</a></li>
											<li><span class="bg-success"></span><a href="{{route('admin_enquiry_view')}}">New Enquires({{$enquiry_count}})</a></li>
											<li><span class="bg-primary"></span><a href="{{route('admin_progress_view')}}">Users requests on Progress({{$progress_count}})</a></li>
											<li><span class="bg-dark"></span><a href="{{route('admin_cancelled_view')}}">Cancelled Accounts({{$cancel_count}})</a></li>
											<li><span class="bg-info"></span><a href="{{route('pending_document')}}">Pending Document Approvals  ({{$pending_count}})</a></li>
										
										</ul>
									</div>
								</div>	
							</div>
						</div>
					
							
						<div class="col-lg-4 grid-margin stretch-card">
							<div class="card congratulation-bg text-center">
								<div class="card-body pb-0">
									<img src="{{env('APP_URL')}}/vendors/admin/images/dashboard/user.png"   width="150px" height="150px" alt="">  
									<h2 class="mt-3 text-white mb-3 font-weight-bold">Welcome
									<font color="red">{{ Auth::user()->name }}</font><br>
									</h2>
									<h3><b>You are logged In..!!</b></h3>
									
								</div>
							</div>
						</div>
					</div>
					</div>			</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					
						
						
						
						
						
					

				@endsection
				