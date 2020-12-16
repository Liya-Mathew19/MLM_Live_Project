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

<div class="hv-item-children">
	@foreach($member as $a)
        <div class="hv-item-child" >
            <!-- Key component -->
            <div class="hv-item">
				<div class="hv-item-parent" data-accountid="{{$a['acct']->acct_id}}">
				
					<div class="person" >
					
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
			</div>
		</div>              
	@endforeach
	 
</div>

 
 