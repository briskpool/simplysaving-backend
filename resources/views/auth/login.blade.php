@extends('layouts.app')

@section('content')
{{-- <div class="py-2 bg-white" style="position: fixed; width: 100%; top: 0; left: 0; z-index:9999;">
        <div class="container-fluid">
            <div class="row">
                <div class="col text-center">
                    <img src="https://account.formula1.com/images/f1_logo.svg" width="80px" class="mb-1">
                    <p class="mb-0" style="font-size: 16px; font-weight: 600; color: black;">
                    <span style="color: #E10600; font-weight: 700;">F1 </span>Fund Now Available
                    <span style="color: #3c9e03;font-weight: 700; font-size: 14px;">(18% Fixed Return)</span></p>
                    
                    <p class="mb-0" style="font-size: 13px; color: #383838;">Ask Your Account Manager For Further Information</p>
                </div>
            </div>
        </div>       
    </div> --}}
<div class="authentication">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">

            <div class="col-xl-5 col-md-6">
                <div class="mini-logo text-center my-3">
                    <a href="{{ env('WEBSITE_URL') }}"><img style="height:50px;" src="{{ asset('images/logo.svg') }}"
                            alt=""></a>
                </div>
                @error('account_locked')
                <div class="text-danger p-3">
                    {{ $message }}
                    <br>
                    Can you please contact IG Global at <span class="text-dark">{{ env('MAIL_FROM_ADDRESS') }}</span> or
                    by calling us on <br> <span class="text-dark">{{ env('PHONE_NUMBER') }}
                    </span>.
                </div>
                @enderror
                <div class="auth-form card">
                    <div class="card-header login-card-header justify-content-center">
                        <h4 class="card-title">Secure Login</h4>
                    </div>
                    <div class="card-body login-card-body">
                        <form method="post" name="myform" class="signin_validate" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input id="email" type="email"
                                    class="login-feilds form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <label class="error" role="alert">
                                    {{ $message }}
                                </label>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input id="password" type="password"
                                    class="login-feilds form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">

                                @error('password')
                                <label class="error" role="alert">
                                    {{ $message }}
                                </label>
                                @enderror
                            </div>
                            <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                <div class="form-group mb-0">
                                    <label class="toggle">
                                        <input class="toggle-checkbox" name="remember" type="checkbox">
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">Remember me</span>
                                    </label>
                                </div>
                                <div class="form-group mb-0">
                                    <a href="{{ route('password.request') }}"
                                        style="color: #fff; border-bottom: 1px solid #fff;">Forgot Password?</a>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="py-2 mb-4 d-flex justify-content-center">
                            Copyright © {{env('APP_NAME')}} <?php echo date("Y"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('vendor/validator/jquery.validate.js') }}"></script>
<script src="{{ asset('vendor/validator/validator-init.js') }}"></script>
@endsection