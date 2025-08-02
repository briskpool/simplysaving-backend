@extends('layouts.app')

@section('content')

    <div class="authentication">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-xl-5 col-md-6">
                    <div class="mini-logo text-center my-5">
                        <a href="{{ env('WEBSITE_URL') }}"><img src="{{ asset('images/logo.png') }}" alt="" height="50px"></a>
                    </div>
                    <div class="auth-form card">
                        <div class="card-header login-card-header justify-content-center">
                            <h4 class="card-title ">Answer the security question</h4>
                        </div>
                        <div class="card-body">


                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                @if ($securityQuestion)
                                    <label for="">
                                        <b>{{ $securityQuestion->question }}</b>
                                    </label>

                                    <input id="security_answer" type="text" placeholder="Your answer"
                                        class="form-control @error('security_answer') is-invalid @enderror"
                                        name="security_answer" value="{{ old('security_answer') }}" required>
                                    @error('security_answer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <br />
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Submit Answer') }}</button>
                                    </div>
                                @else
                                    {{ __('Please confirm your password before continuing.') }}
                                    <div class="form-group row">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Confirm Password') }}
                                            </button>

                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
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
