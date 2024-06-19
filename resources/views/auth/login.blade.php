@extends('layouts.app')

@section('content')
<head>


     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="{{URL::to('admin/icon/themify-icons/themify-icons.css')}}">
     <link rel="stylesheet" type="text/css" href="{{URL::to('admin/icon/font-awesome/css/font-awesome.min.css')}}">


</head>
<div class="login-logo">
     <img src="https://www.pcctmc.com/assets/img/tmc_logo1.png" height="35%" width="35%" alt="" class="brand-image " style="">
     <h2>Weather Forecast</h2>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg" style="font-family:Montserrat; font-weight:bold ">Sign in to start your session</p>

        <form action="{{ route('login') }}" method="post" style="font-family: Montserrat;">
            @csrf
            <div class="input-group mb-3">
                <input id="email" type="email" placeholder="E-mail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fa  fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fa fa-lg fa-lock"></span>
                    </div>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div><br>
            <div class="row" style="margin-left: 5px;">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-flat btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

      {{-- <p class="mb-1" style="font-family: Montserrat;">
        <a href="{{ route('password.request') }}">I forgot my password</a>
      </p> --}}


       {{--<p class="mb-0" style="font-family: Montserrat;">
            <a href="{{route('register')}}" class="text-center">Create new account</a>
        </p>--}} 
    </div>
    <!-- /.login-card-body -->
</div>

@endsection
