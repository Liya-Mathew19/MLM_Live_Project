@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="{{env('APP_URL')}}/vendors/tree/css/hierarchy-view.css">
<link rel="stylesheet" href="{{env('APP_URL')}}/vendors/tree/css/main.css">
<style>
.red{
  border: 5px solid red;
  border-radius: 5px;
}
.green{
  border: 5px solid green;
  border-radius: 5px;
}
.orange{
  border: 5px solid orange;
  border-radius: 5px;
}
.blue{
  border: 5px solid blue;
  border-radius: 5px;
}
.violet{
  border: 5px solid violet;
  border-radius: 5px;
}
.management-hierarchy .person > p.name{
	white-space: nowrap;
	color:black;
}
.management-hierarchy .person > img {
    height: 110px;
    border: 5px solid #FFF;
   border-radius: 1% !important; 
    overflow: hidden;
    background-color: #fff;
}
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
	$(document).ready(function(){ 
	   $(document).on("click",".hv-item-parent",function(){
		   	var this_ref=$(this);
		   	var parentid= this_ref.attr("data-accountid");
		  	$.ajax({
				url:"{{ route('getchild')}}",
				data:{id:parentid},
				type:'GET',
				dataType:'html',
				success:function(responds){	
					this_ref.siblings().remove();
					this_ref.after(responds);
				},
				error:function(x,y,z){
					alert(z);
				}
		  });   
	   });
	});
</script>

<div class="row mt-4">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card card-danger card-outline card-outline-danger">
			<div class="card-header">
				<h4 class="card-title">Network</h4>
				<button type="button"  class="btn btn-warning" data-toggle="modal" data-target="#myModaltree" style="float:right" title="Downline Report">Report</button>
                    <form class="forms-sample" action="{{route('get_full_network_tree')}}" target="_blank" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal fade" id="myModaltree" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
							                <h4 class="card-title">DOWNLINE REPORT</h4><br>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
							
                            <div class="modal-body">
                            
                              <div class="form-group">
                                
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
			</div>
      <style>
.list {
    float:left; 
    padding: 10px;
}
</style>
  <ul class="graphl-legend-rectangle"style="float:right">
  <li class="list"><span class="green"></span><b>Active Users</b></li>
	<li class="list"><span class="red"></span><b>Inactive Users</b></li>
	<li class="list"><span class="orange"></span><b>Registration under progress</b></li>
  <li class="list"><span class="blue"></span><b>Cancelled Users</b></li>
  <li class="list"><span class="violet"></span><b>Rejected Users</b></li>
</ul>
            <div class="card-body">
            
				<section class="management-hierarchy"  >
					<!--Management Hierarchy-->
     				<div class="hv-container">
            			<div class="hv-wrapper">
                			<!-- Key component -->
                			<div class="hv-item ">

					 			@foreach($member as $a)
                    				<div class="hv-item-parent" data-accountid="{{$a['acct']->acct_id}}">
									
                        				<div class="person ">
                          					@if($a['acct']->user_image==null)
                    							<img src="{{env('APP_URL')}}/vendors/admin/images/dashboard/user.png"   width="100" height="100" alt="">
                   		 					<div><b>Level : {{$a['acct']->position - $a['pos']}}</b></div>
                                  @else
                    							<img src="{{asset('uploads/kyc/'.$a['acct']->user_image)}}"  width="100" height="100"  alt=""><br><br>
                                  <div><b>Level : {{$a['acct']->position - $a['pos']}}</b></div>
                              	@endif
											
                                @if($a['color']=='green')
							<p class="name green">AFPA-{{$a['acct']->acct_id}} <b>/ {{$a['acct']->name}}</b> </p>
						@elseif($a['color']=='red')
							<p class="name red">AFPA-{{$a['acct']->acct_id}} <b>/ {{$a['acct']->name}}</b></p>
						@elseif($a['color']=='orange')
							<p class="name orange">AFPA-{{$a['acct']->acct_id}} <b>/ {{$a['acct']->name}}</b></p>
						@elseif($a['color']=='blue')
							<p class="name blue">AFPA-{{$a['acct']->acct_id}} <b>/ {{$a['acct']->name}}</b></p>
              @elseif($a['color']=='violet')
							<p class="name violet">AFPA-{{$a['acct']->acct_id}} <b>/ {{$a['acct']->name}}</b></p>
						
						@endif
											
                        				</div>
                    				</div>
					  			@endforeach
                     		</div>
                		</div>
            		</div>
    			</section>		
            </div>
        </div>                 
	</div>
</div>
@endsection