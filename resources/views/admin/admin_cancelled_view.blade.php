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
							<h4 class="card-title">Cancelled Accounts</h4>
						</div>
                <div class="card-body">
                
                @if($users->isEmpty())
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
                            <th> <b>Action</b></th>
                            <th> <b>Link</b></th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $accounts)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($accounts->acct_id)}}</td>
                            <td><a href="{{route('adminuserview',$accounts->id)}}">{{$accounts->name}}</a></td>
                            <td>{{$accounts->email}}</td>
                            <td>{{$accounts->phone}}</td>
                            <td>{{\App\Helper\PaymentHelper::convert_date_format($accounts->created_at)}}</td>
                            @if($accounts->status=='Cancelled')
                            <td><label class="badge badge-danger">Cancelled</label><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changeaccountstatustoapprove',$accounts->acct_id)}}" title="Change status to approved!!">Revert</a></td> 
                            @elseif($accounts->status=='Terminated')
                            <td><label class="badge badge-dark">Terminated</label><br><br>
                            <!-- <i class="mdi mdi-close-box"></i><a href="{{route('changeaccountstatustoapprove',$accounts->acct_id)}}" title="Change status to approved!!">Revert</a></td>  -->
                            @endif
                            @php
                                $parameter = $accounts->acct_id;
                                $parameter= \Crypt::encrypt($parameter);
                            @endphp
                            <td>
                            <a href="{{URL::temporarySignedRoute('new_register', now() -> addHour(), [$parameter])}}" target='_blank'><button title="Create a new registration link !!" type="button" class="btn btn-primary">Create Link</button></a>
                               </td>
                            
                           
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <script>
    function myFunction() 
    {
        var copyText = document.getElementById("link");
        copyText.select();
        copyText.setSelectionRange(0, 9999999999)
        document.execCommand("copy");
        alert("Copied the referral link !!!");
    }
</script>
                      @endif
        </div>
      </div>
    </div>              
  </div>
 
@endsection