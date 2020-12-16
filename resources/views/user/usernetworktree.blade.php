@extends('layouts.user')
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
                <div class="hv-item">
					 @foreach($member as $a)
                    <div class="hv-item-parent" data-accountid="{{$a['acct']->acct_id}}">
                        <div class="person">
                           @if($a['acct']->user_image==null)
                    <img src="{{env('APP_URL')}}/vendors/admin/images/dashboard/user.png"     width="100" height="100" alt="">
					<div><b>Level : {{$a['acct']->position - $a['pos']}}</b></div>
						
				    @else
                    <img src="{{asset('uploads/kyc/'.$a['acct']->user_image)}}"   width="100" height="100"  alt=""><br><br>
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
        </div>
    </section>


						
						
						
              </div>
            </div>                 
</div>
</div>

 

@endsection