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

    <!-- partial -->
              <div class='container'>
					 <div class="row mt-4">
						<div class="col-lg-12 grid-margin stretch-card">
        				<div class="card card-danger card-outline card-outline-danger">                
               <div class="card-header">
                  <h4 class="card-title">Account Details</h4><br>
                  </div>
                  <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                    @foreach($accountview as $view)
                      <tr><th width="30%"><b> Account ID</th><td >
                          {{\App\Helper\PaymentHelper::bind_account_number($view->acct_id)}}
                          </td></tr>
                        <tr><th><b> Name</th><td>
                          {{(Auth::user()->name)}}
                          </td></tr>
                        <tr><th><b> Email</th><td>
                          {{(Auth::user()->email)}}
                          </td></tr>
                        <tr><th> <b> Phone Number</th><td>
                          {{(Auth::user()->phone)}}
                          </td></tr>
                          <tr><th><b> Spill Over ID </th>
                        @if($view->fk_parent_id != null)
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($view->fk_parent_id)}}<br><br>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-placement="right" title="Account ID / Referral ID of the person whom you want as your parent !!" data-target="#myModal"><i class="mdi mdi-plus"></i>Update Spill Over Id</button>
                            
                            @else
                          <td><button type="button" class="btn btn-warning" data-toggle="modal" data-placement="right" title="Account ID / Referral ID of the person whom you want as your parent !!" data-target="#myModal"><i class="mdi mdi-plus"></i>Update Spill Over Id</button>
                    <br>
<!-- Modal Content-->
<form class="forms-sample" action="{{route('updatespill_over_id',$view->acct_id)}}" method="POST" >
                    @csrf
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Spill Over ID</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
                      <label for="exampleInputName1">ID Number</label>
                      <input type="text" class="form-control" id="spill_over_id" name ="spill_over_id" placeholder="Enter the Account ID.." required  >
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
</td></tr>
                        <tr><th><b>  Created Date</th><td>
                          {{\App\Helper\PaymentHelper::convert_date_format($view->created_at)}}
                          </td></tr>
                      </thead>
                          
                          @if($view->status=='requested')
                          <td><a href="{{route('cancelaccount',$view->acct_id)}}" onclick="return confirm('Do you want to delete the account??')"><button type="button" class="btn btn-danger mr-2">Cancel</button></a></td>
                         <td> <button type="submit" disabled class="btn btn-success mr-2">Requested</button></td>
                         @elseif($view->status=='Activated')
                         <td><button type="button" disabled title ="Activated accounts cannot be cancelled !!" class="btn btn-danger mr-2">Cancel</button></a></td>
                         <td> <button type="submit" disabled class="btn btn-success mr-2">Activated</button></td>
                          @else
                        <td><a href="{{ route('sendaccountrequest',$view->acct_id) }}"><button type="submit" class="btn btn-primary mr-2">Send Request</button> </a></td>
                        @endif
                      </form>
                        </tr>

                    @endforeach
                      
                    </table>
                  </div>


                 

                </div>
              </div>
            </div>
							</div>
						</div>
					</div>
          </div>
          <script>
$(document).ready(function(){
  $('[data-toggle="modal"]').tooltip();   
});
</script>
@endsection			