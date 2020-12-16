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

<script>
$( document ).ready(function() {
    $(".request_select").change(function(){
        CalculateCommission();
    });
    
    function CalculateCommission(){

        var total_amount=0;
        var amount;
        var values = new Array();
        var row_values = new Array();
        $.each($(".request_select:checkbox:checked").closest("td").siblings("td"),function () {
            row_values.push($(this).text());
        });
        
        $.each($(".request_select:checkbox:checked").closest("td").siblings("#amount"),function () {
            values.push($(this).text());
        });
        for (i=0;i<values.length;i++){
            total_amount += parseInt(values[i]);
         }
        var no_of_requests = $(".request_select:checkbox:checked" ).val();      
        
        $("#total").val(total_amount);
    }
});
</script>
@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>   
@endif   

<form accept-charset="UTF-8" action="{{route('commission_payment_confirmation')}}"  id="payment-form" method="post">
                                    {{ csrf_field() }}
<div class='container-fluid'>
	<div class="row mt-4">
		<div class="col-lg-9 grid-margin stretch-card">
        	<div class="card card-danger card-outline card-outline-danger">                
               <div class="card-header">
                  <h4 class="card-title">Approved Commission Requests</h4>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2"  style="float:right">Print Data</button>
<!-- Modal Content-->
                </div>
                <div class="card-body">
                
                  @foreach($requests as $commission_requests)
                  @endforeach
                @if(empty($commission_requests))
                    <center><font color="red"><h3>No Requests Found..!!</h3></font></center>
                @else
                  <div class="table-responsive">
                    <table class="table table-striped" id="mytable">
                      <thead>
                        <tr>
                        <th></th>
                          <th><b> Sl.No.</th>
                          <th><b> Date</th>
                          
                          <th><b>  Customer Name </th>
                          <th><b> Amount</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      @php 
                        $no=1 ;
                    @endphp
                    @foreach($requests as $commission_requests)
                        <tr>
                        <td><input type="checkbox" name="request_select[]" id="request_select" value="{{$commission_requests->request_id}}" class="request_select"></td>
                       
                          <td>{{$no++}}</td>
                          <td>{{\App\Helper\PaymentHelper::convert_date_format($commission_requests->date)}}</td>
                          
                          <td>{{$commission_requests->name}}</td>
                          <td id="amount">	{{$commission_requests->amount}}</td>
                          
                         @endforeach 
                      </form>
                        </tr>
                      </tbody>
                    </table>
                        <br>
                  </div>            
                @endif
                </div>
                
                </div>
                <div class='col-lg-4 form-group required'>
                    <label class='control-label' style="font-size: 1.1rem;"><b>Total Amount</b></label> 
                    <input class='form-control' required readonly="readonly" style="font-size: 1.1rem;" value="" name="total" id="total" type='text'>
                    <br><button type="submit" class="btn btn-success">Proceed</button>
                </div>
            </div>
            
	</div>
</div>
</div>
</form>

<form class="forms-sample" action="{{route('admin_approved_requests_view')}}" target="_blank" method="POST" >
                    @csrf
                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <h4 class="card-title">Approved Commission Requests</h4><br>
                              <div class="form-group">
                                <div class="form-group">
                                  <fieldset class="scheduler-border col-lg-10">
                                    <legend class="scheduler-border ">Start Date</legend>
                                    <input type="date" class="col-lg-6" name="start_date" id="start_date" required>    
                                  </fieldset>
                
                                  <fieldset class="scheduler-border col-lg-10" >
                                    <legend class="scheduler-border ">End Date</legend>
                                    <input type="date" class="col-lg-6" name="end_date"  id="end_date" required>  
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
@endsection