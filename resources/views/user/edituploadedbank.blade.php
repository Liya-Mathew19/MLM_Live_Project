@extends('layouts.user')
@section('content')
<div class="row mt-4">
<div class="col-12 grid-margin stretch-card">
<div class="card card-danger card-outline card-outline-danger">
							<div class="card-header">
											<h4 class="card-title">Bank Information</h4>
											</div>
                <div class="card-body">
                @if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>   
@endif 
                  <h4 class="card-title">Update your Bank Details</h4><br>
                  @if(isset(Auth::user()->id))
                  <form class="forms-sample" method="POST" action="{{ route('edituploadedbankdetails',Auth::user()->id) }}">
                        @csrf
                        <div class="form-group">
                      <label for="exampleInputName1">Account Holder Name</label>
                      <input type="text" class="form-control" id="holder_name" name ="holder_name" class="form-control @error('holder_name') is-invalid @enderror" value="{{Auth::user()->account_holder_name}}" autocomplete="holder_name" autofocus  required  >
                      @error('holder_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <div class="form-group row">
                      <div class="col-lg-6">
                      <label for="exampleInputName1">Bank Name</label>
                            <div id="the-basics">
                              <input type="text" class="form-control" id="bank_name" name ="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{Auth::user()->bank_name}}" autocomplete="bank_name" autofocus  required  >  
                              @error('bank_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                            </div>
                      </div>
                      <div class="col-lg-6">
                      <label for="exampleInputName1">Branch Name</label>
                          <div id="bloodhound">
                          <input type="text" class="form-control" id="branch_name" name ="branch_name" class="form-control @error('branch_name') is-invalid @enderror" value="{{Auth::user()->branch_name}}" autocomplete="branch_name" autofocus  required  >
                          @error('branch_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                        </div>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-lg-6">
                      <label for="exampleInputEmail3">Account Number</label>
                            <div id="the-basics">
                            <input type="password" class="form-control" id="acct_no" name="acct_no" class="form-control @error('acct_no') is-invalid @enderror" value="{{Auth::user()->acct_no}}" autocomplete="acct_no" autofocus required>
                            @error('acct_no')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                            </div>
                            
                      </div>
                      <div class="col-lg-6">
                        <label for="exampleInputEmail3">Confirm Account Number</label>
                          <div id="the-basics">
                            <input type="text" class="form-control" id="acct_no_confirm" name="acct_no_confirmation" class="form-control @error('acct_no_confirmation') is-invalid @enderror" value="{{Auth::user()->acct_no}}" autocomplete="acct_no" autofocus required>
                          </div>
                      </div>
                     </div> 
                      <div class="form-group row">
                      <div class="col">
                      <label for="exampleInputPassword4">IFSC Code</label>
                          <div id="bloodhound">
                          <input type="text" class="form-control" id="ifsc_code" name ="ifsc_code" class="form-control @error('ifsc_code') is-invalid @enderror" value="{{Auth::user()->ifsc_code}}" autocomplete="ifsc_code" autofocus  required >
                          @error('ifsc_code')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                        </div>
                      </div>
                  </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{route('customerprofile')}}"><button type="button" class="btn btn-danger mr-2">Cancel</button></a>
                    @else
                    
                      <center><font color="red">{{'No data found !!!'}}</font>
                  @endif
                    
                  </form>
                </div>
              </div>
            </div>
            </div>

@endsection