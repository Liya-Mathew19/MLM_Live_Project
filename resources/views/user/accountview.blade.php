@extends('layouts.user')
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
<script type="text/javascript">
function AlertIt() {
var answer = alert ("Under Maintenence !!!");
}
</script>
<style>
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 1.5em 1.5em 0 !important;
   
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }
    </style>
<div class="row mt-4">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card card-danger card-outline card-outline-danger">
						<div class="card-header">
							<h4 class="card-title">Your Accounts</h4>
						</div>
                <div class="card-body">
                
          
            @if($accountview==null)
              <center><b><font color="red">{{__('No Accounts Found !!')}}</font></b></center>
            @else
            <div class="table-responsive" >
              <table class="table table-bordered">

                  <tr>
                    <th>Sl.No.</th>
                    <th> Created Date</th>
                    <th> Account ID</th>
                    <th> Name</th>
                    <th> Email</th>
                    <th> Phone</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Cancel</th>
                    <th>Report</th>
                  </tr>
                
                  <tbody>
                    @php $no = 1; @endphp
                      <tbody>
                        @foreach($accountview as $account)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{\App\Helper\PaymentHelper::convert_date_format($account->created_at)}}</td>
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($account->acct_id)}}<br><br>
                              @if($account->acct_type=='Primary')
                              <center><label class="badge badge-success">{{$account->acct_type}}</label></center>
                              @elseif($account->acct_type=='Secondary')
                              <center><label class="badge badge-danger">{{$account->acct_type}}</label></center>
                              @endif
                            </td>

                            <td>{{Auth::user()->name}}</td>
                            <td>{{Auth::user()->email}}</td>
                            <td>{{Auth::user()->phone}}</td>
                            @if($account->status=='Progress')
                            <td><label class="badge badge-warning">{{$account->status}}</label></td>
                            <td><a href="{{route('viewaccount',$account->acct_id)}}"><button type="button"  class="btn btn-primary">View</button></a></td>
                            <td><a href="{{route('cancelaccount',$account->acct_id)}}" onclick="return confirm('Do you want to delete the account??')"><button type="button"  class="btn btn-danger">Cancel</button></a></td>
                          
                            @elseif($account->status=='requested')
                            <td><label class="badge badge-primary">{{$account->status}}</label></td>
                            <td><a href="{{route('viewaccount',$account->acct_id)}}"><button type="button"  class="btn btn-primary">View</button></a></td>
                            <td><a href="{{route('cancelaccount',$account->acct_id)}}" onclick="return confirm('Do you want to delete the account??')"><button type="button"  class="btn btn-danger">Cancel</button></a></td>
                          
                            @elseif($account->status=='Activated')
                            <td><label class="badge badge-success">{{$account->status}}</label></td>
                            <td><a href="{{route('viewaccount',$account->acct_id)}}"><button type="button"  class="btn btn-primary">View</button></a></td>
                            <td><button type="button" disabled class="btn btn-danger" title="Activated accounts cannot be cancelled !!">Cancel</button></a></td>
                          
                            @elseif($account->status=='Deactivated')
                            <td><label class="badge badge-danger">{{$account->status}}</label></td>
                            <td><a href="{{route('viewaccount',$account->acct_id)}}"><button type="button"  class="btn btn-primary">View</button></a></td>
                            <td><a href="{{route('cancelaccount',$account->acct_id)}}" onclick="return confirm('Do you want to delete the account??')"><button type="button"  class="btn btn-danger">Cancel</button></a></td>
                          
                            @endif

                            <td> 
                            <!-- <button type="button" onclick="javascript:AlertIt();" class="btn btn-warning" title="Downline Report">View Tree Report</button> -->
               
                            <button type="button"  class="btn btn-warning" data-toggle="modal" data-target="#myModaltree-{{ $account->acct_id }}" title="Downline Report">View Tree Report</button>
               </td>
                    <form class="forms-sample" action="{{route('get_user_network_tree',$account->acct_id)}}" target="_blank" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal fade" id="myModaltree-{{ $account->acct_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="card-title">Network Tree Report</h4><br>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            
                              <div class="form-group">
                                
                                <input type="hidden" value="{{ $account->acct_id }}" class="form-control" id="exampleInputName1" name="id">
                                <div class="form-group">
                                  <fieldset class="scheduler-border col-lg-10">
                                    <legend class="scheduler-border ">Date</legend>
                                    <select name="month" id="month" required>
                                    <option value="">--Select Month--</option>
                                      <option value="1">January</option>
                                      <option value="2">February</option>
                                      <option value="3">March</option>
                                      <option value="4">April</option>
                                      <option value="5">May</option>
                                      <option value="6">June</option>
                                      <option value="7">July</option>
                                      <option value="8">August</option>
                                      <option value="9">September</option>
                                      <option value="10">October</option>
                                      <option value="11">November</option>
                                      <option value="12">December</option>
                                    </select>

                                    <select id="year" name="year" required>
                                      <option value="">--Select Year--</option>
                                          {{ $year = date('Y') }}
                                      @for ($y = $year; $y <= $year; $y++)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                           @endfor
                                      </select>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary" >Submit</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>  
                      </div> 
                    </form>
                            </tr>
                        @endforeach
                      </tbody>
              </table>
            </div>
            @endif
        </div>
      </div>
    </div>              
  </div>

@endsection