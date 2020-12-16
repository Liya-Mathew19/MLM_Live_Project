@extends('layouts.user')
@section('content')
<div class="row mt-4">
<div class="col-12 grid-margin stretch-card">
<div class="card card-danger card-outline card-outline-danger">
							<div class="card-header">
											<h4 class="card-title">UPDATE PROFILE</h4>
                      </div>
                      <div class="row content">
        <div class="col-md-4 order-1 order-md-2 " data-aos="fade-left" >
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/details-4.png" class="img-fluid" alt="">
        </div>
        <div class="col-md-7 pt-4" data-aos="fade-up">
            <div class="col-md-12">
                  <form class="forms-sample" method="POST" action="{{route('updatecustomer',Auth::user()->id)}}">
                        @csrf
                    <div class="form-group">
                      <label for="exampleInputName1">Name</label>
                      <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name ="name"  value="{{(Auth::user()->name)}}" >
                      @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                    </div>
                  

                    <div class="form-group">
                    
                      <label for="exampleInputEmail3">Email address</label>
                      <div class="input-group">
                      @if(Auth::user()->email_status=="Verified")
                      <input type="email" readonly="readonly" class="form-control @error('email') is-invalid @enderror" id="email" name="email"  value="{{(Auth::user()->email)}}" >
                      <div class="input-group-append">
                        <span class="input-group-text bg-success text-white">Verified</span>
                      </div>
                      @elseif(Auth::user()->email_status!="Verified")
                      <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"  value="{{(Auth::user()->email)}}" >
                      <div class="input-group-append">
                        <span class="input-group-text bg-dark text-white">Not Verified</span>
                      </div>
                      @endif
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                   
                    </div>
                   
                    <div class="form-group">
                      <label for="exampleInputPassword4">Phone Number</label>
                      <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-dark text-white">+91</span>
                      </div>
                      @if(Auth::user()->phone_status=="Verified")
                      <input type="text" readonly="readonly" maxlength='10' class="form-control @error('phone') is-invalid @enderror" id="phone" name ="phone" value="{{(Auth::user()->phone)}}" >
                      <div class="input-group-append">
                        <span class="input-group-text bg-success text-white">Verified</span>
                      </div>
                      @error('phone')
                                    <span class="invalid-feedback"  role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                      @elseif(Auth::user()->phone_status!="Verified")
                      <input type="text" maxlength='10' class="form-control @error('phone') is-invalid @enderror" id="phone" name ="phone" value="{{(Auth::user()->phone)}}" >
                      <div class="input-group-append">
                        <span class="input-group-text bg-dark text-white">Not Verified</span>
                      </div>
                      @endif
                      @error('phone')
                                    <span class="invalid-feedback"  role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    
                   
</div>
                    
                    <div class="form-group">
                      <label for="exampleTextarea1">Address</label>
                      <textarea class="form-control" id="address" name="address" rows="4">{{(Auth::user()->address)}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{route('customerprofile')}}"><button type="button" class="btn btn-danger mr-2">Cancel</button></a>
                  </form>
                </div>
              </div>
            </div>
</div>
@endsection