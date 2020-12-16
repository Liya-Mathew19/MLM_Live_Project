@extends('layouts.user')
@section('content')

  <div class="row mt-4">
		<div class="col-lg-12">
			<div class="card card-danger card-outline card-outline-danger">
				<div class="card-header">
					<h4 class="card-title">Income Details</h4>
				</div>
        @if(Auth::user()->user_status != 'Activated')
        <br><br><center><h3><font color="red">Your account is not activated.. Please wait for your approval !!!</font></h3></center>
                               
        @else
				<div class="card-body">
          <div class="col-lg-4">
						<div class="row">
              <div class="col-sm-12">
                <div class="card card-primary card-outline card-outline-primary">
                  <h4 style="padding: 17px;"><b>Total Commission Earned : 	&#x20B9;{{\App\Helper\PaymentHelper::total_commission_earned(Auth::user()->id)}}</b></h4>
                </div>
              </div>
            </div>
          </div><br>   

          <nav>
				    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
              @foreach($result['accounts'] as $account)
						    <a class="nav-item nav-link active" id="nav-home-tab-{{ $account->acct_id }}" data-toggle="tab" href="#nav-home-{{ $account->acct_id }}" role="tab" 
                            aria-controls="nav-home-{{ $account->acct_id }}" aria-selected="true">{{\App\Helper\PaymentHelper::bind_account_number($account->acct_id) }}</a>
              @endforeach
            </div>
				  </nav>

    <!-- Tab panes -->

    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
		  
            @foreach($result['incomes'] as $income=>$value)
              @foreach($value as $val)
              <div class="tab-pane fade show active" id="nav-home-{{ $val->fk_acct_id }}" role="tabpanel" 
            aria-labelledby="nav-home-tab">
                <div role="tabpanel" class="tab-pane active" class="tab-pane"  id="tab-{{ $val->fk_acct_id}}">
                  <h2>{{ $val->amount }}</h2>
                </div>
              @endforeach  
            @endforeach
      </div>
    </div>
  </div>

  </div>
  @endif
</div>

@endsection