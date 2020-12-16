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

<script>
$(document).ready(function(){
	
	$("#spilloverserach").click(function(){
		
		var spill_over_id= $("#spill_over_id").val();
		 
		$.ajax({
			url:"{{ route('searchspill_over_id')}}",
			data:{ spill_over_id: spill_over_id },
			type:'GET',
			dataType:'json',
			success:function(responds){
				var responds=$.parseJSON(responds);
				if(responds.status==true){
					$("#parent_id").val(responds.account.acct_id);
					$("#account_details").text(responds.account.acct_id +"( "+responds.user.name+" )");
					$("#myModal").modal('hide');
				}else{
					//alert(responds);
					alert(responds.message);
				}
			},
			error:function(x,y,z){
				
			}
		});
		
	});
	
});


</script>


    <!-- partial -->
              <div class='container-fluid'>
					 <div class="row mt-4">
						<div class="col-lg-12 grid-margin stretch-card">
        				<div class="card card-danger card-outline card-outline-danger">                
               <div class="card-header">
                  <h4 class="card-title">New Account Details</h4>
                  </div>
                  <div class="card-body">
                  <div class="table-responsive">
				   <form class="forms-sample" action="{{route('sendaccountrequest',$account->acct_id)}}" method="POST" >
                    @csrf
                    <table class="table table-striped" >
                        <tr> 
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
                        
                            <td>  <p id="account_details">  {{\App\Helper\PaymentHelper::bind_account_number($account->fk_parent_id)}} </p>  <br><br>
                       <button type="button" class="btn btn-warning" data-placement="right" id="spill" title="Account ID / Referral ID of the person whom you want as your parent !!"  data-toggle="modal" data-target="#myModal"><i class="mdi mdi-plus"></i>Update Spill Over Id</button>
                    <br>
<!-- Modal Content-->

 
</td></tr>
                        <tr><th><b>  Created Date</th><td>
                          {{\App\Helper\PaymentHelper::convert_date_format($account->created_at)}}
                          </td></tr>
                      </thead>
					  <th></th>
                           @if($account->status=='requested')
                         <th> <button type="submit" disabled class="btn btn-success mr-2">Requested</button></th>
                          @else
                        <th>
					
				 <button type="submit" class="btn btn-primary mr-2">Send Request</button> </th>
                        @endif
                      
					   <input type="hidden" class="form-control" value="{{$account->fk_referral_id}}" id="parent_id" name ="parent_id" placeholder="Enter the Account ID.." required  >
					  
					  
                        </tr>
                      </tbody>
                    </table></form>
                  </div>
                </div>
              </div>
			  
			  
			  <form class="forms-sample" action="" method="POST" >
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
        <button type="button" class="btn btn-primary"  id="spilloverserach">Submit</button>
      </div>
    </div>
  </div>
</div>
</form>
			  
			  
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