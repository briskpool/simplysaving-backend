@extends('layouts.app')

@section('content')
    <div class="authentication">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-xl-5 col-md-6">
                    <div class="mini-logo text-center my-5">
                        <a href="{{ env('WEBSITE_URL') }}"><img style="height:50px"
                                src="{{ asset('images/logo.svg') }}" alt=""></a>
                    </div>
                    <div class="auth-form card">
                        <div class="card-header login-card-header justify-content-center">
                            <h4 class="card-title">Reset Password</h4>
                        </div>
                        <div class="card-body login-card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <label for="email" class="">{{ __('Email') }}</label>
                                        <input id="email" type="email"
                                            class="login-feilds form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback error" role="alert">
                                                <label class="error">{{ $message }}</label>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Send Password Reset Link') }}</button>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}">
                                        {{ __('Back to login') }}</a>
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
