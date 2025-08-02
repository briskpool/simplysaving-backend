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
                        <a href="{{route('clients.index')}}">Clients </a>
                        <span>/</span>
                        <span>Edit Client</span>
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container">
        <div class="row">
            
            
           
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Client</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('clients.update', Crypt::encrypt($client->id))}}" name="myform" class="personal_validate" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf

                            @method('PATCH')

                            <input type="hidden" name="id" value="{{Crypt::encrypt($client->id)}}">
                            <div class="form-row">
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">First Name</label>
                                    <input type="text" class="form-control" required placeholder="John" value="{{$client->first_name}}" name="first_name">
                                    @error('first_name')
                                    <label id="first_name-error" class="error" for="first_name">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Last Name</label>
                                    <input type="text" class="form-control" required placeholder="Doe" value="{{$client->last_name}}" name="last_name">
                                    @error('last_name')
                                    <label id="last_name-error" class="error" for="last_name">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Email</label>
                                    <input type="email" class="form-control" required placeholder="hello@example.com" value="{{$client->email}}" name="email">
                                    @error('email')
                                        <label id="email-error" class="error" for="email">{{ $message }}</label>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Password</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control edit-gen-password" required placeholder="********" value="{{Crypt::decrypt($client->password)}}" name="password">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="generate">Generate</span>
                                        </div>
                                    </div>
                                    @error('password')
                                    <label id="password-error" class="error" for="password">{{ $message }}</label>
                                    @enderror
                                    
                                </div>

                                <div class="form-group col-xl-6" >
                                    <label class="mr-sm-2 text-dark">Membership Type</label>
                                    <select class="form-control nice-select" id="select2" required name="membership_type[]" multiple>
                                        @foreach ($membership_types as $membership)
                                            <option value="{{ $membership->type }}" {{ in_array($membership->type, $client->membership_type) ? 'selected' : '' }}>{{ $membership->type }}</option>
                                            {{-- <option value="{{ $membership->type }}" {{ in_array($membership->type, $client->membership_type) ? 'selected' : '' }}>{{ $membership->type }}</option> --}}
                                        @endforeach
                                    </select>
                                    @error('membership_type')
                                        <label id="membership_type-error" class="error"
                                            for="membership_type">{{ $message }}</label>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-xl-6" >
                                    <label class="mr-sm-2 text-dark">Currency</label>
                                    <select class="form-control" required name="currency_symbol">
                                        <option value="£" {{ $client->currency_symbol == "£" ? 'selected' : '' }}>GBP (£)</option>
                                        <option value="$" {{ $client->currency_symbol == "$" ? 'selected' : '' }}>USD ($)</option>
                                        <option value="€" {{ $client->currency_symbol == "€" ? 'selected' : '' }}>EUR (€)</option>
                                        <option value="₣" {{ old('currency_symbol') == "₣" ? 'selected' : '' }}>CHF (₣)</option>

                                    </select>
                                    @error('currency_symbol')
                                        <label id="currency_symbol-error" class="error"
                                            for="currency_symbol">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active" {{$client->status=='active'?'selected':''}}>Active</option>
                                        <option value="inactive" {{$client->status=='inactive'?'selected':''}}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <label id="status-error" class="error" for="status">{{ $message }}</label>
                                    @enderror
                                    
                                </div>
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Verified</label>
                                    <select name="is_verified" class="form-control">
                                        <option value="0" {{ !$client->email_verified_at ? 'selected' : '' }}>
                                            No
                                        </option>
                                        <option value="1" {{ $client->email_verified_at ? 'selected' : '' }}>
                                            Yes</option>
                                    </select>
                                    @error('status')
                                        <label id="status-error" class="error"
                                            for="status">{{ $message }}</label>
                                    @enderror

                                </div>
                                <div class="form-group col-xl-12">
                                    <div class="media align-items-center mb-3">
                                        <img class="mr-3 rounded-circle mr-0 mr-sm-3"
                                            src="{{Storage::disk('public')->exists('users/'.$client->profile_img)?$image=asset('storage/users/'.$client->profile_img):$image=asset('images/'.$client->profile_img)}}" id="uploaded" accept="image/png, image/gif, image/jpeg"  weight="50" height="50" alt="">
                                        <div class="media-body">
                                            {{-- <h4 class="mb-0"></h4> --}}
                                            <p class="mb-0">
                                                Supported files: jpg, png, svg. Max file size is 20mb
                                               
                                            </p>
                                        </div>
                                    </div>
                                    <div class="file-upload-wrapper" data-text="Change Photo">
                                        <input name="profile_img" type="file"
                                            class="file-upload-field" value="">
                                    </div>
                                </div>
                                {{-- @if ($client->is_secure)
                                    <div class="form-group col-xl-3 align-self-center" style="margin-top:65px">
                                    <label class="toggle" style="margin-bottom: -2px !important;">
                                        <input class="toggle-checkbox" id="security" value="1" {{$client->is_secure?'checked':''}} name="is_secure"  type="checkbox">
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">Turn Off Extra Security</span>
                                    </label>
                                    
                                </div>                                    
                                @endif --}}

                                
                                
                                <div class="form-group text-right col-12">
                                    <button class="btn btn-primary pl-5 pr-5">Save Client</button>
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
<script>
    $('#select2').select2({
    //theme: 'bootstrap-5'
});
</script>
@endsection

