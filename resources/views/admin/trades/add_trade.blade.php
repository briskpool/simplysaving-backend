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
                            <a href="{{ route('interests.index') }}">Interest Payment</a>
                            <span>/</span>
                            <span>Add Interest Payment</span>
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
                            <h4 class="card-title">Add Interest Payment</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('interests.store') }}" name="myform"
                                class="personal_validate" novalidate="novalidate" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2 text-dark">Client</label>
                                        <select class="form-control" required name="user_id" id="user_id">
                                            <option value="">--choose client--</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}" data-membership="{{ json_encode($clientMembershipTypes[$client->id] ?? []) }}"
                                                    {{ old('user_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->first_name . ' ' . $client->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <label id="user_id-error" class="error" for="user_id">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2 text-dark">Membership Type</label>
                                        <select class="form-control" required name="membership_type" id="membership_type" disabled>
                                            <option value="">--choose membership type--</option>
                                        </select>
                                        @error('membership_type')
                                            <label id="membership_type-error" class="error" for="membership_type">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    
                                    
                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2 text-dark">Date</label>
                                        <input type="text" class="form-control" placeholder="Select date" id="datepicker"
                                        autocomplete="off" value="{{ old('trade_date') }}" readonly required
                                        name="trade_date">
                                        
                                        @error('trade_date')
                                            <label id="trade_date-error" class="error"
                                                for="trade_date">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    

                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2 text-dark">Interest %</label>
                                        <input type="number" class="form-control" required placeholder="Enter Interest %"
                                            value="{{ old('reward') }}" name="reward">
                                        @error('reward')
                                            <label id="reward-error" class="error"
                                                for="reward">{{ $message }}</label>
                                        @enderror
                                        @error('balance')
                                            <label id="balance-error" class="error"
                                                for="balance">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    


                                    <input type="hidden" name="running_total" value="2">
                                    {{-- <input type="hidden" name="user_id" value="2"> --}}


                                    <div class="form-group text-right col-12">
                                        <button class="btn btn-primary pl-5 pr-5">Save Interest Payment</button>
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
    {{-- <script>
        $('#datepicker').datepicker();
    </script> --}}

    <script src="{{ asset('vendor/validator/jquery.validate.js') }}"></script>
    <script src="{{ asset('vendor/validator/validator-init.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-ui-init.js') }}"></script>

    <script>
        // Get the select elements
        var userSelect = document.getElementById('user_id');
        var membershipSelect = document.getElementById('membership_type');
    
        // Event listener for change in user select
        userSelect.addEventListener('change', function() {
            // Clear existing options
            membershipSelect.innerHTML = '<option value="">--choose membership type--</option>';
    
            // Get the selected user's membership types
            var selectedUser = this.options[this.selectedIndex];
            var membershipTypes = JSON.parse(selectedUser.getAttribute('data-membership'));
            
            // Populate membership options for selected user
            if (membershipTypes && membershipTypes.length > 0) {
                membershipTypes.forEach(function(type) {
                    var option = document.createElement('option');
                    option.value = type;
                    option.textContent = type;
                    membershipSelect.appendChild(option);
                });
                // Enable the membership select
                membershipSelect.disabled = false;
            } else {
                // Disable the membership select if no membership types found
                membershipSelect.disabled = true;
            }
        });
    </script>
    
@endsection
