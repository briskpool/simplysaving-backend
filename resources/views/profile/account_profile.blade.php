@extends('layouts.app')
@section('content')
@include('layouts.partials.header')
@include('layouts.partials.sidebar')

<div class="page_title">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6">
                <div class="page_title-content">
                    <p class="mb-0">
                        <a href="{{auth()->user()->is_admin?route('clients.index'):route('trade-statement')}}">Home </a>
                        <span>/</span>
                        <span>Edit Profile</span>
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container">
        <div class="row">
            @if (!Auth::user()->is_admin)
                @include('layouts.partials.account_setting_menu')
            @endif
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('account.update',Crypt::encrypt(Auth::user()->id))}}" name="myform" class="personal_validate" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                               
                                <div class="form-group col-xl-4 mb-lg-3">
                                    <div class="media align-items-center mb-3">
                                        <img class="mr-3 rounded-circle shadow-sm mr-0 mr-sm-3"
                                            src="{{Storage::disk('public')->exists('users/'. Auth::user()->profile_img)?$image=asset('storage/users/'. Auth::user()->profile_img):$image=asset('images/'. Auth::user()->profile_img)}}" id="uploaded" width="100" height="100" alt="">
                                    </div>
                                    
                                </div>
                                <div class="form-group col-xl-8 align-self-center mb-3">
                                    <div class="file-upload-wrapper " data-text="Change Photo">
                                        <input name="profile_img" type="file"
                                            class="file-upload-field" value="" accept="image/png, image/gif, image/jpeg">
                                    </div>
                                    
                                </div>
                                <div class="form-group col-xl-6 mb-3">
                                    <label class="mr-sm-2">First Name</label>
                                    <input type="text" class="form-control" required placeholder="John" value="{{Auth::user()->first_name}}" name="first_name">
                                    @error('first_name')
                                    <label id="first_name-error" class="error" for="first_name">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-6  mb-3">
                                    <label class="mr-sm-2">Last Name</label>
                                    <input type="text" class="form-control" required placeholder="Doe" value="{{Auth::user()->last_name}}" name="last_name">
                                    @error('last_name')
                                    <label id="last_name-error" class="error" for="last_name">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-6  mb-3">
                                    <label class="mr-sm-2">Email</label>
                                    <input type="email" class="form-control" required placeholder="hello@example.com" value="{{Auth::user()->email}}" name="email">
                                    @error('email')
                                        <label id="email-error" class="error" for="email">{{ $message }}</label>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-xl-6  mb-3">
                                    <label class="mr-sm-2">Password</label>
                                    <div class="input-group mb-3">
                                       
                                        <input type="text" class="form-control edit-gen-password" required placeholder="********" value="{{Crypt::decrypt(Auth::user()->password)}}" name="password">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="generate">Generate</span>
                                        </div>
                                    </div>
                                    @error('password')
                                    <label id="password-error" class="error" for="password">{{ $message }}</label>
                                    @enderror
                                    
                                </div>
                               

                                <div class="form-group text-right col-12 mt-3">
                                    <button class="btn btn-primary pl-5 pr-5">Update Profile</button>
                                </div>
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
<script src="{{asset('vendor/validator/jquery.validate.js')}}"></script>
<script src="{{asset('vendor/validator/validator-init.js')}}"></script>
@endsection

