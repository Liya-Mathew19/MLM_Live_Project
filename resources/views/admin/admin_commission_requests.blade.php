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
<div class='container-fluid'>
					 <div class="row mt-4">
						<div class="col-lg-12 grid-margin stretch-card">
        				<div class="card card-danger card-outline card-outline-danger">                
               <div class="card-header">
                  <h4 class="card-title">Commission Requests</h4><br>
                  </div>
                  <div class="card-body">
                  <a href="{{route('approved_commission_requests')}}"><button type="button" class="btn btn-primary">Approved Commission Requests</button></a><br><br>
                  @foreach($commission_requests as $requests)
                  @endforeach
                @if(empty($requests))
                    <center><font color="red"><h3>No Requests Found..!!</h3></font></center>
                @else
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th><b> Sl.No.</th>
                          <th><b> Date</th>
                          <th><b> Amount</th>
                          <th><b>  Actions </th>
                        </tr>
                      </thead>
                      <tbody>
                      @php 
                        $no=1 ;
                    @endphp
              @foreach($commission_requests as $requests)
                        <tr>
                          <td >{{$no++}}</td>
                          <td>{{\App\Helper\PaymentHelper::convert_date_format($requests->date)}}</td>
                          <td>	&#x20B9;{{$requests->amount}}</td>
                          <td> <a href="{{route('commission_detailed_view',$requests->request_id)}}"><button type="button" class="btn btn-primary">View</button></a></td></td>
                         @endforeach 
                      </form>
                 
                        </tr>
                      </tbody>
                    </table>
                  </div>
@endif

                 

                </div>
              </div>
            </div>
							</div>
						</div>
					</div>
          </div>


          <script>
function myFunction1() {
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