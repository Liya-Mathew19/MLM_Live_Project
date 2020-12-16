@extends('layouts.admin')
@section('content')

  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif
  @php
            $kycflag=true;
            $accountflag=true;
            
            foreach($kycs as $kyc)
            {
              if($kyc->status != 'Activated')
              {
                $kycflag = false;
                break;
              }
           
            }
            foreach($account as $accounts)
            {
              if($accounts->status != 'Activated')
              {
                $accountflag = false;
                break;
              }
            }
            
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
                        <li><span class="bg-info"></span><b>Address</b> : <pre style="background: white;padding: 15px;font-size: .875rem;">{{$users->address}}</pre></li>  
                        @endif          
                      </ul>
										</div>
                  </div>
                  
              </div>
              
            </div>
            <hr style="height:1px;border-width:0;color:gray;background-color:gray">
            @if($users->user_status=='Activated')
      <td><button type="button" class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approved</button></td>
      <td><a href="{{route('rejectcustomer',$users->id)}}" onclick="return confirm('Reject the request??')"><button type="button" class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Reject</button></a></td>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></a></td>
      <td><a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></a></td>
      <td><a href="{{route('deletecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to delete the user??')"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button></a></td>
     

    @elseif($users->user_status=='requested')
    @if($kycflag == false|| $accountflag == false)
      <td><button type="button" disabled class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approve</button></td>
      <td><a href="{{route('rejectcustomer',$users->id)}}" onclick="return confirm('Reject the request??')"><button type="button" class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Reject</button></a></td>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></a></td>
      <td><a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></a></td>
      <td><a href="{{route('deletecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to delete the user??')"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button></a></td>
     @else
      <td><a href="{{route('approvecustomer',$users->id)}}" onclick="return confirm('Approve the request??')" ><button type="button" class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approve</button></a></td>
      <td><a href="{{route('rejectcustomer',$users->id)}}" onclick="return confirm('Reject the request??')"><button type="button"  class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Reject</button></a></td>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></a></td>
      <td><a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></a></td>
      <td><a href="{{route('deletecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to delete the user??')"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button></a></td>
     @endif
    
    

     @elseif($users->user_status=='Terminated')
      <td><button type="button" disabled class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approve</button></td>
      <button type="button" disabled class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Reject</button>
      <button type="button"  disabled class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button>
      <a href="{{route('unblockcustomer',$users->id)}}"><button type="button" class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Unblock</button></a>
      <button type="button" disabled  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button>
 

      @elseif($users->user_status=='Unblocked')
      <td><a href="{{route('approvecustomer',$users->id)}}" onclick="return confirm('Approve the request??')" ><button type="button" class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approve</button></a></td>
      <td><a href="{{route('rejectcustomer',$users->id)}}" onclick="return confirm('Reject the request??')"><button type="button"  class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Reject</button></a></td>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></a></td>
      <td><a href="{{route('terminatecustomer',$users->id)}}"><button type="button" class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></a></td>
      <td><a href="{{route('deletecustomer',$users->id)}}"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button></a></td>
     

    @elseif($users->user_status=='Deactivated')
      <td><button type="button" disabled class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approve</button></td>
      <td><button type="button" class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Rejected</button></td></td>
      <td><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></td>
      <td><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></td>
      <td><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button></td>
    @endif	
	
                
                </hr>
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
                @if (\App\Models\Kyc::where('type', '=', 'Pan Card Details')->where('fk_user_id','=',$users->id)->first()==null)
                <b><font color="red">{{__("PAN Card details not uploaded yet !!")}}</font></b>
                @endif
                  <div class="table-responsive">
                  @if($kycs==null)
                      <center><b><font color="red">{{__("No Files uploaded yet !!")}}</font></b></center>
                    @else
                    <table class="table table">
                      <thead>
                        @php $no = 1; @endphp
                        <tr>
                          <th><b>Sl.No.</b></th>
                          <th><b> Name</b></th>
                          <th> <b>Identification Number</b></th>
                          <th><b> Document</b></th>
                          <th><b>Approve</b></th>
                          <th><b>Reject</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($kycs as $kyc)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{$kyc->type}}</td>
                            <td>{{$kyc->identification_number}}</td>
                            <td>@php
                          $image=json_decode($kyc->path);
                          $nos=1;
                          @endphp
                          @foreach($image as $img)
                          <button type="button" class="btn btn-outline-info">
                          <a href ="{{env('APP_URL')}}/uploads/kyc/{{$img}}" target="_blank">View file {{$nos++}}</a>
                          </button>
                          
                          @endforeach</td>
                          
                            @if($kyc->status=='Activated')
                            <td><label class="badge badge-success">Approved</label><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changekycstatus',$kyc->id)}}">Cancel</a></td> 
                            <td><button type="button" disabled class="btn btn-danger">Reject</button></td>  
                                                       
                            @elseif($kyc->status=='Pending')
                            <td><a href="{{route('approvekyc',$kyc->id)}}" onclick="return confirm('Are you sure,want to approve the request??')" ><button type="button" class="btn btn-success">Approve</button></td>
                            
                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal2">Reject</button></td>
                   

<!-- Modal Content-->
<form class="forms-sample" action="{{route('updateremarks',$kyc->id)}}" method="POST" >
                    @csrf
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <input type="text" class="form-control" id="remarks" name ="remarks" placeholder="Enter the reason.." required  >
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure, want to reject the request??')">Submit</button>
      </div>
    </div>
  </div>
</div>
</form>
                  
                            
                    
                            @endif
                        
                            @if($kyc->status=='Deactivated')
                            <td><button type="button" disabled class="btn btn-success">Approve</button></a></td>  
                            <td><label class="badge badge-warning">Rejected</label></a><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changekycstatus',$kyc->id)}}">Cancel</a></td>
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
                            <th><b>Sl.No.</b></th>
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
								    <h4 class="card-title">Your Subscription Accounts</h4>
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
                            <th><b>Sl.No.</b></th>
                            <th><b>Account ID</b></th>
                            <th> <b>Referral ID</b></th>
                            <th> <b>Parent ID</b></th>
                            <th> <b>Created On</b></th>
                            <th> <b>Approve</b></th>
                            <th> <b>Reject</b></th>
                            
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($account as $accounts)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($accounts->acct_id)}}<br><br>

                             @if($accounts->acct_type=='Primary')
                              <center><label class="badge badge-success">{{$accounts->acct_type}}</label></center>
                              @elseif($accounts->acct_type=='Secondary')
                              <center><label class="badge badge-danger">{{$accounts->acct_type}}</label></center>
                              @endif</td>

                              @if($accounts->fk_referral_id==null)
                            <td><font color="red">Referral ID not specified</font></td>
                            @else
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($accounts->fk_referral_id)}}</td>
                            @endif

                            
                            @if($accounts->fk_parent_id==null)
                            <td><font color="red">Parent ID not specified</font></td>
                            @else
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($accounts->fk_parent_id)}}</td>
                            @endif
                            
                            <td>{{\App\Helper\PaymentHelper::convert_date_format($accounts->created_at)}}</td>

                            @if($accounts->status=='Activated')
                            <td><label class="badge badge-success">Approved</label><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changeaccountstatus',$accounts->acct_id)}}">Cancel</a></td> 
                            <td><button type="button" disabled class="btn btn-danger">Reject</button></td>  
                                                       
                            @elseif($accounts->status=='requested')
                            <td><a href="{{route('approveaccount',$accounts->acct_id)}}" onclick="return confirm('Are you sure,want to approve the request??')" ><button type="button" class="btn btn-success">Approve</button></td>
                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal1">Reject</button></td>
                    <br>

<!-- Modal Content-->
<form class="forms-sample" action="{{route('updateaccountremarks',$accounts->acct_id)}}" method="POST" >
                    @csrf
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <input type="text" class="form-control" id="remarks1" name ="remarks1" placeholder="Enter the reason.." required  >
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure, want to reject the request??')">Submit</button>
      </div>
    </div>
  </div>
</div>
</form>
                            @endif
                        
                            @if($accounts->status=='Deactivated')
                            
                            <td><button type="button" disabled class="btn btn-success">Approve</button></a></td>  
                            <td><label class="badge badge-warning">Rejected</label></a><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changeaccountstatus',$accounts->acct_id)}}">Cancel</a></td>
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