@extends('layouts.user')
@section('content')
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
<div class="container">
    <div class="row mt-4">
		<div class="col-lg-12 ">
			<div class="card card-danger card-outline card-outline-danger">
				<div class="card-header">
					<h4 class="card-title">Commission Payout Reports</h4>
                </div>
				<div class="card-body">
                <div class="row content">
        <div class="col-md-4 order-1 order-md-2 "><br><br>
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/download.jpg" class="img-fluid" alt="">
        </div>
        <div class="col-md-7 pt-0" data-aos="fade-up">
                    <form action="{{route('user_commission_report')}}" target="_blank" method="POST">
                    @csrf
                        <fieldset class="scheduler-border col-lg-10">
                            <legend class="scheduler-border ">Start Date</legend>
                                <input type="date" class="col-lg-6" name="start_date" id="start_date" required>    
                        </fieldset>
                
                        <fieldset class="scheduler-border col-lg-10" >
                            <legend class="scheduler-border ">End Date</legend>
                                <input type="date" class="col-lg-6" name="end_date"  id="end_date" required>  
                        </fieldset>
                        <button class='form-control btn btn-primary col-lg-2'  type='submit' style="float:center">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection