@extends('layouts.app')

@section('content')
    <div class="authentication">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-xl-5 col-md-6">
                    <div class="mini-logo text-center my-5">
                        <a href="{{ env('WEBSITE_URL') }}"><img src="{{ asset('images/logo.svg') }}" alt="" height="50px"></a>
                    </div>
                    <div class="auth-form card">
                        <div class="card-header login-card-header justify-content-center">
                            <h4 class="card-title">Reset Password</h4>
                        </div>
                        <div class="card-body login-card-header">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <label for="email" class="">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email"
                                            class="login-feilds form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <label for="password" class="">{{ __('Password') }}</label>
                                        <input id="password" type="password"
                                            class="login-feilds form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <label for="password-confirm"
                                            class="">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" class="login-feilds form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Save Password') }}</button>
                                </div>
                            </form>
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
