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
                        <a href="{{route('trade-statement')}}">Dashboard </a>
                        <span>/</span>
                        <span>Add Funds</span>
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Funds</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('add-funds.request')}}" name="myform" class="personal_validate" novalidate="novalidate" >
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="mr-sm-2 text-dark">Membership Type</label>
                                    <select class="form-control" required name="membership_type" id="membership_type_select">
                                        <option value="" disabled>Select Membership Type</option> <!-- Placeholder -->
                                        @foreach ($client->membership_type as $membership)
                                            <option value="{{ $membership }}" {{ old('membership_type') == $membership || session('selected_membership_type') == $membership ? 'selected' : '' }}>{{ $membership }}</option>
                                        @endforeach
                                    </select>
                                    @error('membership_type')
                                        <label id="membership_type-error" class="error" for="membership_type">{{ $message }}</label>
                                    @enderror
                                </div>

                                <label>I would like to add</label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text bg-light text-dark"><b>{{Auth::user()->currency_symbol}}</b></label>
                                    </div>
                                    <input type="text" class="form-control" required placeholder="10000" value="{{old('amount')}}" name="amount">
                                    @error('amount')
                                    <label id="amount-error" class="error" for="amount">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group text-center col-12">
                                    <button class="btn btn-primary pl-5 pr-5">Add Funds</button>
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
    // Get the selected membership type from session storage
    const selectedMembershipType = sessionStorage.getItem('selected_membership_type');

    // Select the dropdown
    const membershipTypeSelect = document.getElementById('membership_type_select');

    // Loop through options to find the one to select
    for (let option of membershipTypeSelect.options) {
        if (option.value === selectedMembershipType) {
            option.selected = true;
            break;
        }
    }
</script>
@endsection

