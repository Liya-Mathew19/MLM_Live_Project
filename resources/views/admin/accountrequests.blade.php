@extends('layouts.admin')
@section('content')
@if (session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
@endif	
<div class="row mt-4">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card card-danger card-outline card-outline-danger">
						<div class="card-header">
							<h4 class="card-title">Account Requests</h4>
						</div>
                <div class="card-body">
                
                @if($account->isEmpty())
                      <center><b><font color="red">{{__("No Accounts Found !!")}}</font></b></center>
                    @else
                      <table class="table table">
                        <thead>
                        @php $no = 1; @endphp
                          <tr>
                            <th><b>Sl.No.</b></th>
                            <th><b>Account ID</b></th>
                            <th><b>User Name</b></th>
                            <th><b>Email</b></th>
                            <th><b>Phone</b></th>
                            <th><b>Created On</b></th>
                            <th><b>Cancel</b></th>
                            <th> <b>Approve</b></th>
                            <th> <b>Reject</b></th>
                            <th style="display:none;" id="remarkhead1"><b>Remarks</b></th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($account as $accounts)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($accounts->acct_id)}}</td>
                            <td><a href="{{route('adminuserview',$accounts->id)}}">{{$accounts->name}}</a></td>
                            <td>{{$accounts->email}}</td>
                            <td>{{$accounts->phone}}</td>
                            <td>{{\App\Helper\PaymentHelper::convert_date_format($accounts->created_at)}}</td>
                            @if($accounts->status=='Activated')
                            <td><a href="{{route('admincancelaccount',$accounts->acct_id)}}" onclick="return confirm('Are you sure,want to cancel the request??')" ><button type="button" class="btn btn-warning">Cancel</button></td>
                            <td><label class="badge badge-success">Approved</label><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changeaccountstatus',$accounts->acct_id)}}">Revert</a></td> 
                            <td><button type="button" disabled class="btn btn-danger">Reject</button></td>  
                            @elseif($accounts->status=='Cancelled')
                            <td><label class="badge badge-warning">Cancelled</label><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changeaccountstatus',$accounts->acct_id)}}">Revert</a></td> 
                            <td><a href="{{route('approveaccount',$accounts->acct_id)}}" onclick="return confirm('Are you sure,want to approve the request??')" ><button type="button" class="btn btn-success">Approve</button></td>
                            <td><button type="button" disabled class="btn btn-danger">Reject</button></td>  
                                                         
                            @elseif($accounts->status=='requested')
                            <td><a href="{{route('admincancelaccount',$accounts->acct_id)}}" onclick="return confirm('Are you sure,want to cancel the request??')" ><button type="button" class="btn btn-warning">Cancel</button></td>
                            <td><a href="{{route('approveaccount',$accounts->acct_id)}}" onclick="return confirm('Are you sure,want to approve the request??')" ><button type="button" class="btn btn-success">Approve</button></td>
                            <td><button type="button" onclick="myFunction1()" class="btn btn-danger">Reject</button></td>
                            <form class="forms-sample" action="{{route('updateaccountremarks',$accounts->acct_id)}}" method="POST" >
                            @csrf
                            <td><input id="remarks1" style="display: none;" type="text" class="form-control " name="remarks1"  placeholder="Reason for rejection"></td>
                            <td><button type="submit" onclick="return confirm('Are you sure, want to reject the request??')" style="display: none;" id="submit1" name="submit" class="btn btn-primary mr-2">Submit</button></td>
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
  <script>
  function myFunction1() {
  var x1 = document.getElementById("remarks1");
  var y1 = document.getElementById("submit1");
  var z1 = document.getElementById("remarkhead1");
  if (x1.style.display === "none") {
    x1.style.display = "block";
    y1.style.display = "block";
    z1.style.display = "block";
  } else {
    x1.style.display = "none";
    y1.style.display = "none";
    z1.style.display = "none";
  }
}
</script>
@endsection