@extends('layouts.admin')
@section('content')

  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  
<div class="container">
<!--Profile Card-->
  
    <div class="row mt-4">
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card card-danger card-outline card-outline-danger">
					<div class="card-header">
						<h4 class="card-title">PROFILE</h4>
					</div>
       
@foreach($users as $user)
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4">
		            <div class="col-lg-8">
									<div class="position-relative">
                    @if($user->user_image==null)
                      <img src="images/dashboard/user.png" class="w-100" alt="">
                    @else
                      <img src="{{asset('uploads/kyc/'.$user->user_image)}}" class="w-100" alt=""><br><br>
                    @endif	
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<h4 class="card-title">Basic Details</h4><br>
									<div class="row">
                    <div class="col-sm-12">
											<ul class="graphl-legend-rectangle">
												<li><span class="bg-danger"></span><b>Name </b>:{{$user->name}} </li>
												<li><span class="bg-warning"></span><b>Email </b>: {{$user->email}}</li>
                        <li><span class="bg-info"></span><b>Phone Number</b> : {{$user->phone}}</li>
                        @if($user->address==null)
                        <li><span class="bg-info"></span><b>Address</b> : <font color="red"> Not Provided yet</font></li> 
                        @else
                        <li><span class="bg-info"></span><b>Address</b> : {{$user->address}}</li>  
                        @endif    
                        <li><span class="bg-info"></span><b>Created Date</b> : {{$user->created_at}}</li>          
                      </ul>
									  </div>
                  </div>
							</div>
						</div>
             <!--Commission Requests Card-->
               
							    <div class="card-header">
								    <h4 class="card-title">Commission Requests</h4>
                                </div>
								  <div class="card-body">
                    <div class="table-responsive">
                    @if($commission_requests==null)
                      <center><b><font color="red">{{__("No Other Accounts Found !!")}}</font></b></center>
                    @else

                    <h3><b>Total Wallet Balance : 	&#x20B9; {{$total_wallet_balance}}</b></h3>
                      <table class="table table">
                        <thead>
                        @php $no = 1; @endphp
                          <tr>
                          
                            <th><b>ID</b></th>
                            <th> <b>Date</b></th>
                            <th><b>Amount</b></th>
                            <th> <b>Approve</b></th>
                            <th> <b>Reject</b></th>
                            @if($remark==null)
                            <th style="display:none"><b>Remarks</b></th>
                            @else
                            <th><b>Remarks</b></th>
                            @endif
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($commission_requests as $requests)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{\App\Helper\PaymentHelper::convert_date_format($requests->date)}}</td>
                            <td>	&#x20B9;{{$requests->amount}}</td>
                            @if($requests->status=='Approved')
                            <td><label class="badge badge-success">Approved</label><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changecommissionstatus',$requests->request_id)}}">Cancel</a></td> 
                            <td><button type="button" disabled class="btn btn-danger">Reject</button></td>  
                                                       
                            @elseif($requests->status=='Requested')
                            <td><a href="{{route('approve_commission_request',$requests->request_id)}}" onclick="return confirm('Are you sure,want to approve the request??')" >
                            <button type="button" class="btn btn-success">Approve</button></td>
                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Reject</button></td>
                    <br>

<!-- Modal Content-->
<form class="forms-sample" action="{{route('reject_commission_remarks',$requests->request_id)}}" method="POST" >
                    @csrf
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Rejection Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
                      <label for="exampleInputName1">Reason</label>
                      <input type="text" class="form-control" id="reason" name ="reason" placeholder="Enter the reason.." required  >
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
</form>
@endif
                        @if($requests->status=='Rejected')
                            <td><button type="button" disabled class="btn btn-success">Approve</button></a></td>  
                            <td><label class="badge badge-warning">Rejected</label></a><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changecommissionstatus',$requests->request_id)}}">Cancel</a></td>
                            <td><label>{{$requests->remarks}}</label></a></td>
                            @endif 
                           
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      @endif
                    </div>
                </div>
            </div>
</div></div></div></div>
@endforeach
                        
               
        
@endsection