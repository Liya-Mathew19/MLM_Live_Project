@extends('layouts.admin')
@section('content')

  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

@php
$accounts=$results['account'];
$kyc=$results['kyc'];
@endphp
<div class="container">
<!--Profile Card-->
  
    <div class="row mt-4">
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card card-danger card-outline card-outline-danger">
					<div class="card-header">
						<h4 class="card-title">PROFILE</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4">
		            <div class="col-lg-8">
									<div class="position-relative">
                  @if($users->user_image==null)
                    <img src="images/dashboard/user.png" class="w-100" alt="">
                    @else
                    <img src="{{asset('uploads/kyc/'.$users->user_image)}}" class="w-100" alt=""><br><br>
                    @endif
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<h4 class="card-title">Basic Details</h4><br>
									<div class="row">
                    <div class="col-sm-12">
											<ul class="graphl-legend-rectangle">
												<li><span class="bg-danger"></span><b>Name </b>:{{$users->name}} </li>
												<li><span class="bg-warning"></span><b>Email </b>: {{$users->email}}</li>
                                                
                        <li><span class="bg-info"></span><b>Phone Number</b> : {{$users->phone}}</li>
                        @if($users->address==null)
                        <li><span class="bg-info"></span><b>Address</b> : <font color="red"> Not Provided yet</font></li> 
                        @else
                        <li><span class="bg-info"></span><b>Address</b> : {{$users->address}}</li>  
                        @endif
                                    
                      </ul>
										</div>
                  </div>
							</div>
						</div>
					</div>
				</div>
			</div>
    </div>


<!--Documents Card-->
          <div class="row mt-0">
						<div class="col-lg-12 grid-margin stretch-card">
						  <div class="card card-danger card-outline card-outline-danger">
							    <div class="card-header">
											<h4 class="card-title">DOCUMENTS</h4>
                  </div>

								<div class="card-body">
                  <div class="table-responsive">
                  @if($kycs==null)
                      <center><b><font color="red">{{__("No Files uploaded yet !!")}}</font></b></center>
                    @else
                    <table class="table table">
                      <thead>
                        @php $no = 1; @endphp
                        
                        <tr>
                          <th><b>ID</b></th>
                          <th><b> Name</b></th>
                          <th> <b>Identification Number</b></th>
                          <th><b> Document</b></th>
                          <th><b>Status</b></th>
                          @if($kyc ==null)
                          <th><b>Remarks</b></th>
                            
                            @else
                            <th style="display:none;"><b>Remarks</b></th>
                            @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($kycs as $kyc)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{$kyc->type}}</td>
                            <td>{{$kyc->identification_number}}</td>
                            <td><button type="button" class="btn btn-outline-info">
                            <a href ="{{url('/uploads/kyc/'.$kyc->path)}}" target="_blank">View file</a>
                          </button></td>
                            @if($kyc->status=='Activated')
                            <td><label class="badge badge-success">Approved</label><br><br> 
                                                       
                            @elseif($kyc->status=='Pending')
                            <td><label class="badge badge-warning">Pending</label><br><br> 
                            @elseif($kyc->status=='Deactivated')
                            <td><label class="badge badge-danger">Rejected</label></a><br><br>
                            <td><label>{{$kyc->remarks}}</label></a></td>
                            @endif 
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>



            <!--Bank Card-->
            <div class="row mt-0">
						  <div class="col-lg-12 grid-margin stretch-card">
							  <div class="card card-danger card-outline card-outline-danger">
							    <div class="card-header">
								    <h4 class="card-title">Bank Details</h4>
                  </div>
								  <div class="card-body">
                    <div class="table-responsive">
                    @if($users->bank_name==null)
                      <center><b><font color="red">{{__("No bank details uploaded yet !!")}}</font></b></center>
                    @else
                      <table class="table table">
                        <thead>
                        @php $no = 1; @endphp
                          <tr>
                            <th><b>ID</b></th>
                            <th><b> Account Holder</b></th>
                            <th><b> Bank Name</b></th>
                            <th><b> Branch Name</b></th>
                            <th> <b>Account Number</b></th>
                            <th><b> IFSC Code</b></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{$users->account_holder_name}}</td>
                            <td>{{$users->bank_name}}</td>
                            <td>{{$users->branch_name}}</td>
                            <td>{{$users->acct_no}}</td>
                            <td>{{$users->ifsc_code}}</td>
                          </tr>
                        </tbody>
                      </table>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>



            
<!--Other Accounts Card-->
<div class="row mt-0">
						  <div class="col-lg-12 grid-margin stretch-card">
							  <div class="card card-danger card-outline card-outline-danger">
							    <div class="card-header">
								    <h4 class="card-title">Other Accounts</h4>
                  </div>
								  <div class="card-body">
                    <div class="table-responsive">
                    @if($account==null)
                      <center><b><font color="red">{{__("No Other Accounts Found !!")}}</font></b></center>
                    @else
                      <table class="table table">
                        <thead>
                        @php $no = 1; @endphp
                          <tr>
                            <th><b>ID</b></th>
                            <th><b>Account ID</b></th>
                            <th> <b>Name</b></th>
                            <th> <b>Status</b></th>
                            
                            @if($accounts !=null)
                            <th style="display:none;"><b>Remarks</b></th>
                            @else
                            <th><b>Remarks</b></th>
                            @endif
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($account as $accounts)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($accounts->acct_id)}}</td>
                            <td>{{$users->name}}</td>
                            @if($accounts->status=='Activated')
                            <td><label class="badge badge-success">Approved</label><br><br>                       
                            @elseif($accounts->status=='requested')
                            <td><label class="badge badge-warning">Requested</label></td>                        
                            @elseif($accounts->status=='Deactivated')
                            <td><label class="badge badge-danger">Rejected</label></td>   
                            <td><label>{{$accounts->remarks}}</label></a></td>
                            @endif 
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
     

    @if($users->user_status=='Activated')
      <td><button type="button" class="btn btn-success btn-rounded btn-fw col-lg-1 ">Approved</button></td>
      <button type="button" disabled class="btn btn-danger btn-rounded btn-fw col-lg-1 ">Reject</button>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-1 ">Edit</button></a></td>
      <td><a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-1 ">Terminate</button></a></td>
      <td><a href="{{route('deletecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to delete the user??')"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-1 ">Delete</button></a></td>
     
    @elseif($users->user_status=='requested')
      <td><a href="{{route('approvecustomer',$users->id)}}" onclick="return confirm('Approve the request??')" ><button type="button" class="btn btn-success btn-rounded btn-fw col-lg-1 ">Approve</button></a></td>
      <td><a href="{{route('rejectcustomer',$users->id)}}" onclick="return confirm('Reject the request??')"><button type="button"  class="btn btn-danger btn-rounded btn-fw col-lg-1 ">Reject</button></a></td>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-1 ">Edit</button></a></td>
      <td><a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-1 ">Terminate</button></a></td>
      <td><a href="{{route('deletecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to delete the user??')"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-1 ">Delete</button></a></td>
     
    

     @elseif($users->user_status=='Terminated')
      <td><button type="button" disabled class="btn btn-success btn-rounded btn-fw col-lg-1 ">Approve</button></td>
      <button type="button" disabled class="btn btn-danger btn-rounded btn-fw col-lg-1 ">Reject</button>
      <button type="button"  disabled class="btn btn-info btn-rounded btn-fw col-lg-1 ">Edit</button>
      <a href="{{route('unblockcustomer',$users->id)}}" onclick="return confirm('Are you sure,want to unblock the user??')"><button type="button" class="btn btn-dark btn-rounded btn-fw col-lg-1 ">Unblock</button></a>
      <button type="button" disabled  class="btn btn-warning btn-rounded btn-fw col-lg-1 ">Delete</button>
 

      @elseif($users->user_status=='Unblocked')
      <td><button type="button" disabled class="btn btn-success btn-rounded btn-fw col-lg-1 ">Approve</button></td>
      <td><a href="{{route('rejectcustomer',$users->id)}}" onclick="return confirm('Reject the request??')"><button type="button"  class="btn btn-danger btn-rounded btn-fw col-lg-1 ">Reject</button></a></td>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-1 ">Edit</button></a></td>
      <a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button" class="btn btn-dark btn-rounded btn-fw col-lg-1 ">Terminate</button></a>
      <a href="{{route('deletecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to delete the user??')"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-1 ">Delete</button></a>
     

    @elseif($users->user_status=='Deactivated')
      <td><button type="button" disabled class="btn btn-success btn-rounded btn-fw col-lg-1 ">Approve</button></td>
      <td><button type="button" class="btn btn-danger btn-rounded btn-fw col-lg-1 ">Rejected</button></td></td>
      <td><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-1 ">Edit</button></td>
      <td><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-1 ">Terminate</button></td>
      <td><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-1 ">Delete</button></td>
    @endif	

</div>





<script>
function myFunction() {
  var x = document.getElementById("remarks");
  var y = document.getElementById("submit");
  var z = document.getElementById("remarkhead");
  if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "block";
    z.style.display = "block";
  } else {
    x.style.display = "none";
    y.style.display = "none";
    z.style.display = "none";
  }
}

</script>
@endsection