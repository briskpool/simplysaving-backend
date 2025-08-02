@extends('layouts.app')
@section('content')
    @include('layouts.partials.header')
    @include('layouts.partials.sidebar')

    <div class="page_title">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-4">
                    <div class="page_title-content">
                        <p style="font-size: 16px;">Your Membership Type
                        <select class="form-control" required name="membership_type" id="membership_type_select">
                            <option value="" disabled>Select Membership Type</option> <!-- Placeholder -->
                            @foreach ($client_membership_types as $membership)
                                <option value="{{ $membership }}" {{ old('membership_type') == $membership || session('selected_membership_type') == $membership ? 'selected' : '' }}>{{ $membership }}</option>
                            @endforeach
                        </select>
                        @error('membership_type')
                            <label id="membership_type-error" class="error" for="membership_type">{{ $message }}</label>
                        @enderror
                        @if (!Auth::user()->is_admin && Auth::user()->email_verified_at)
                            <p class="d-block d-xl-none"
                                style="font-size: 12px;margin-left:0px !important;line-height: 1.5; color:#29294E; font-weight:400; font-style:normal;">
                                <i class="mdi mdi-check-circle mr-1"></i>
                                Verified Account
                            </p>
                        @endif
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="container">
            @foreach($client_statement_data as $membership_type =>$membership_data)
                <div class="row membership-row" data-membership="{{ $membership_type }}" style="display: none;">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="widget-card" style="min-height: 150px">
                                    <div class="widget-title mb-3">
                                        <h4 class="text-primary">Your Balance</h4>
                                    </div>
                                    <div class="widget-info">
                                        <h3>{{ Auth::user()->currency_symbol . ' ' . number_format($membership_data['balance'], 2) }}
                                        </h3>
                                        {{-- <p>GBP</p> --}}
                                    </div>
                                    @if($membership_type != 'Professional Fund' && $membership_type != 'Bespoke Trading')

                                    <p class="text-muted mb-0">Withdrawn
                                        {{ Auth::user()->currency_symbol . ' ' . number_format($membership_data['total_withdraw'], 2) }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="widget-card" style="min-height: 150px">
                                    <div class="widget-title mb-3">
                                        <h4>Total Deposit</h4>
                                        {{-- <p class="text-success">133% <span><i class="las la-arrow-up"></i></span></p> --}}
                                    </div>
                                    <div class="widget-info">
                                        <h3>{{ Auth::user()->currency_symbol . ' ' . number_format($membership_data['total_deposit'], 2) }}</h3>
                                        {{-- <p>GBP</p> --}}
                                    </div>
                                    @if (!$membership_data['transactions']->isEmpty())
                                        <p class="text-muted mb-0">Updated
                                            {{ date('d/m/Y', strtotime($membership_data['transactions']->first()->transaction_date)) }}</p>
                                    @endif

                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="widget-card" style="min-height: 150px">
                                    <div class="widget-title mb-3">
                                        <h4 class="text-info">Total Profit</h4>
                                        {{-- @if ($profit > 0)
                                            <p class="text-success">{{ $profit_percentage }}% <span><i
                                                        class="las la-arrow-up"></i></span></p>
                                        @endif --}}
                                    </div>
                                    <div class="widget-info">
                                        <h3>{{ Auth::user()->currency_symbol . ' ' . number_format($membership_data['profit'], 2) }}</h3>
                                        {{-- <p>GBP</p> --}}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-xl-12">
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="row d-flex align-items-center p-3">
                                        <div class="col-md-6 col-12">
                                            <h4 class="card-title">All Interest Payments</h4>

                                        </div>
                                    </div>
                                    <div class="row d-flex align-items-center p-2">
                                        <div class="col-md-6 col-12 mb-2">

                                            @if (request()->has('month_filter'))
                                                <span class="badge badge-pill badge-light text-danger"
                                                    style="font-size: 16px;  font-weight:400;">Showing Results of
                                                    {{ request()->month_filter }}<a href="{{ route('trade-statement') }}"
                                                        class="text-dark"><i class="mdi mdi-close"></i></a> </span>
                                            @else
                                                <span class="badge badge-pill badge-light text-dark"
                                                    style="font-size: 16px; font-weight:400;">Showing Results of
                                                    @if (count($membership_data['trades'])>0)
                                                    {{ Carbon\Carbon::CreateFromFormat('m', $membership_data['trades']->first()->created_at->month)->format('F Y')}}
                                                    @else
                                                        {{ Carbon\Carbon::now()->format('F Y')}}

                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-12 d-flex justify-content-lg-end justify-content-start">
                                            <button type="button" class="btn btn-dark btn-sm mr-1 px-2 py-1"
                                                style="min-width: 0px !important; text-transform:capitalize;"
                                                data-toggle="modal" data-target="#exampleModal">
                                                <i class="mdi mdi-filter"></i>
                                                Filter</button>

                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <div class="transaction-table">
                                            <div class="table-responsive">
                                                <table class="table mb-0 " id="table">
                                                    <thead class="bg-dark text-light">
                                                        <th>Date</th>
                                                        <th>Profit</th>

                                                    </thead>
                                                    <tbody>
                                                        @forelse ($membership_data['trades'] as $trade)
                                                            <tr>
                                                                <td>
                                                                    {{ date('d-m-Y', strtotime($trade->trade_date)) }}
                                                                </td>
                                                                <td>{{ $trade->reward . '%' }}</td>


                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td class="text-center" colspan="8">No record</td>
                                                            </tr>
                                                        @endforelse


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-0">
                                        <h4 class="card-title">Transactions</h4>
                                    </div>
                                    <div class="card-body pt-0">

                                        <div class="transaction-table">
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-responsive-trade">
                                                    <thead class="bg-dark text-light">
                                                        <th>Date</th>
                                                        <th>Transaction Amount</th>
                                                        <th>Transaction Type</th>
                                                        <th>Authorised By</th>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($membership_data['transactions'] as $transaction)
                                                            <tr>
                                                                <td>
                                                                    {{ date('d-m-Y', strtotime($transaction->transaction_date)) }}
                                                                </td>

                                                                <td>
                                                                    {{ Auth::user()->currency_symbol . number_format($transaction->transaction_amount) }}
                                                                </td>
                                                                <td>
                                                                    @if ($transaction->transaction_type == 'deposit')
                                                                        <span
                                                                            class="badge badge-success">{{ ucfirst($transaction->transaction_type) }}</span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-danger text-light">{{ ucfirst($transaction->transaction_type) }}</span>
                                                                    @endif

                                                                </td>
                                                                <td>
                                                                    {{ $transaction->authorised_by }}
                                                                </td>

                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">No record</td>
                                                            </tr>
                                                        @endforelse


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="false" data-backdrop="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="myform" class="personal_validate" novalidate="novalidate"
                        enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-xl-12">
                                <label>Select Month</label>
                                <input type="text" class="form-control" placeholder="Select month" data-date=""
                                    id="monthPicker" autocomplete="off"
                                    {{-- @if (count($trades)>0)
                                    value="{{ request()->month_filter ?? Carbon\Carbon::CreateFromFormat('m', $trades->first()->created_at->month)->format('F Y') }}"
                                    {{ Carbon\Carbon::CreateFromFormat('m', $trades->first()->created_at->month)->format('F Y')}}
                                    @else --}}
                                    value="{{ Carbon\Carbon::now()->format('F Y')}}"                                        
                                    {{-- @endif --}}
                                    readonly required name="month_filter">
                            </div>

                            <div class="form-group text-right col-12">
                                <button class="btn btn-primary pl-5 pr-5">Apply Filter</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('vendor/validator/jquery.validate.js') }}"></script>

    <script src="{{ asset('vendor/validator/validator-init.js') }}"></script>
    <script>
        $(function() {
            $('#table').DataTable({
                searching: false,
                ordering: false
            });
        })
    </script>
    <script src="{{ asset('js/plugins/jquery-ui-init.js') }}"></script>
    <script src="{{ asset('js/plugins/monthpicker.js') }}"></script>
    
    <script>
        // Wait for the document to be ready
         document.addEventListener("DOMContentLoaded", function() {
        // Add event listener to the membership type select
        var membershipSelect = document.getElementById('membership_type_select');
        var rows = document.querySelectorAll('.membership-row');
        const withdrawFundsLi = document.getElementById('withdraw_funds_li');
        
        // Get the default selected membership type
        var defaultMembership = "{{ old('membership_type') ?: session('selected_membership_type') }}";
        
        // If a default membership is selected
        if (defaultMembership) {
            // Show the corresponding membership row
            var membershipRow = document.querySelector('.membership-row[data-membership="' + defaultMembership + '"]');
            if (membershipRow) {
                membershipRow.style.display = 'block';
            }
        }else{
            let sessionSelectedMembership = sessionStorage.getItem('selected_membership_type');
            var matchFound = false;
            // If session storage doesn't have a selected membership type, use the default selected value
            if (sessionSelectedMembership) {
                // Loop through each option of the select element
                for (var i = 0; i < membershipSelect.options.length; i++) {
                    var option = membershipSelect.options[i];

                    // Check if the value of the current option matches the search string
                    if (option.value === sessionSelectedMembership) {
                        // Match found
                        matchFound = true;
                        break; // Stop further iteration if match found
                    }
                }
                // Check if a match was found and log the result
                if (matchFound) {
                    membershipSelect.value = sessionSelectedMembership;
                } else {
                    membershipSelect.selectedIndex = 1; // Select the first option
                    sessionSelectedMembership = membershipSelect.value;
                    sessionStorage.setItem('selected_membership_type', sessionSelectedMembership);
                }
                showHideRows(sessionSelectedMembership);
                if (sessionSelectedMembership === 'Professional Fund' || sessionSelectedMembership === 'Bespoke Trading') {
                    withdrawFundsLi.style.display = 'none';
                } else {
                    withdrawFundsLi.style.display = ''; // Show the withdraw funds li
                }
            }else{
                membershipSelect.selectedIndex = 1; // Select the first option
                let selected = membershipSelect.value;
                sessionStorage.setItem('selected_membership_type', selected);
                showHideRows(selected);
                if (selected === 'Professional Fund' || selected === 'Bespoke Trading') {
                    withdrawFundsLi.style.display = 'none';
                } else {
                    withdrawFundsLi.style.display = ''; // Show the withdraw funds li
                }
            }
        }
        
        // Function to show/hide rows based on the selected membership type
        function showHideRows(selectedMembershipType) {
                rows.forEach(function(row) {
                    if (row.dataset.membership === selectedMembershipType) {
                        row.style.display = 'block';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        membershipSelect.addEventListener('change', function(event) {
            // Hide all membership rows
            var membershipRows = document.querySelectorAll('.membership-row');
            membershipRows.forEach(function(row) {
                row.style.display = 'none';
            });
            
            // Show the selected membership row
            var selectedMembership = event.target.value;
            var selectedRow = document.querySelector('.membership-row[data-membership="' + selectedMembership + '"]');
            if (selectedRow) {
                selectedRow.style.display = 'block';
            }
            sessionStorage.setItem('selected_membership_type', selectedMembership);

            if (selectedMembership === 'Professional Fund' || selectedMembership === 'Bespoke Trading') {
                withdrawFundsLi.style.display = 'none';
            } else {
                withdrawFundsLi.style.display = ''; // Show the withdraw funds li
            }
        });
    });
    </script>
    
@endsection
