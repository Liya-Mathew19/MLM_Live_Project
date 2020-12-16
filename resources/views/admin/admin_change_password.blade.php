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
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <center><h2>CHANGE PASSWORD</h2>
                <h6 class="font-weight-light">Want to change your password??</h6><br>
                <form class="forms-sample" action="{{route('change_password_action')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                <div class="form-group">
                    <input type="old_password" class="form-control " id="old_password" name="old_password" placeholder="Old Password" required>
                  </div>
                  <div class="form-group">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="new_password" placeholder="New Password" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
                     </div>
                  <div class="form-group">
                  <input id="password-confirm" type="password" class="form-control" name="confirm_password" required placeholder="Confirm Password" autocomplete="new-password">
                </div>
                  <div class="mt-3 ">
                  <button type="submit" class="btn btn-primary mr-2 col-lg-12">Submit</button>
                  </div>
                </form>
              </div>
            </div>
@endsection