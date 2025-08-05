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
                        <a href="{{ route('clients.index') }}">Client </a>
                        <span>/</span>
                        <span>{{ $client->first_name . ' ' . $client->last_name }}</span>
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
                        <h4 class="card-title">Add Account Transaction</h4>
                        {{-- <a href="{{route('teams.create')}}">
                        <button class="btn btn-primary btn-sm"> Add New Team</button>
                        </a> --}}
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('transactions.store') }}" name="myform"
                            class="personal_validate" novalidate="novalidate">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Date</label>
                                    <input type="text" class="form-control" placeholder="Select date" id="datepicker"
                                        autocomplete="off" value="{{ old('transaction_date') }}" readonly required
                                        name="transaction_date">
                                    @error('transaction_date')
                                    <label id="transaction_date-error" class="error"
                                        for="transaction_date">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Amount</label>
                                    <input type="number" class="form-control" required placeholder="10000"
                                        value="{{ old('transaction_amount') }}" name="transaction_amount">
                                    @error('transaction_amount')
                                    <label id="transaction_amount-error" class="error"
                                        for="transaction_amount  ">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Membership Type</label>
                                    <select class="form-control" required name="membership_type"
                                        id="membership_type_select">
                                        <option value="">--choose Membership type--</option>
                                        @foreach ($client->membership_type as $membership)
                                        <option value="{{ $membership }}"
                                            {{ old('membership_type') == $membership ? 'selected' : '' }}>
                                            {{ $membership }}</option>
                                        @endforeach
                                    </select>
                                    @error('membership_type')
                                    <label id="membership_type-error" class="error"
                                        for="membership_type">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Transaction Type</label>
                                    <select name="transaction_type" id="transaction_type_select" class="form-control"
                                        required>
                                        <option value="">--choose transaction type--</option>
                                        <option value="withdraw"
                                            {{ old('transaction_type') == 'withdraw' ? 'selected' : '' }}>Withdraw
                                        </option>
                                        <option value="deposit"
                                            {{ old('transaction_type') == 'deposit' ? 'selected' : '' }}>
                                            Deposit</option>
                                    </select>
                                    @error('email')
                                    <label id="email-error" class="error" for="email">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="form-group col-xl-6">
                                    <label class="mr-sm-2 text-dark">Authorised By</label>
                                    <input type="text" class="form-control" required placeholder="John Doe"
                                        value="{{ old('authorised_by') }}" name="authorised_by">
                                    @error('authorised_by')
                                    <label id="authorised_by-error" class="error"
                                        for="authorised_by">{{ $message }}</label>
                                    @enderror

                                </div>
                                <input type="hidden" name="user_id" value="{{ $client->id }}">
                                <div class="form-group text-right col-12">
                                    <button class="btn btn-primary pl-5 pr-5">Save Transaction</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row align-items-center">
                    <div class="col-xl-4">
                        <div class="page_title-content">
                            <p style="font-size: 16px;">{{ $client->first_name . ' ' . $client->last_name }} Membership
                                Type(s)
                                <select class="form-control" required name="membership_type"
                                    id="client_membership_type_select">
                                    @php
                                    $memberships = $client->membership_type ?? [];
                                    @endphp

                                    @if(count($memberships) > 0)
                                    @foreach ($memberships as $index => $membership)
                                    <option value="{{ $membership }}" {{ $index === 0 ? 'selected' : '' }}>
                                        {{ $membership }}
                                    </option>
                                    @endforeach
                                    @else
                                    <option value="" selected disabled>No Membership Types</option>
                                    @endif
                                </select>



                                @error('membership_type')
                                <label id="membership_type-error" class="error"
                                    for="membership_type">{{ $message }}</label>
                                @enderror
                                @if ($client->email_verified_at)
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

            <div class="container">
                @foreach($client_statement_data as $membership_type =>$membership_data)
                <div class="row membership-row" data-membership="{{ $membership_type }}" style="display: none;">
                    <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card-balance" style="min-height: 150px">
                            <div class="widget-title mb-3">
                                <h6>Your Balance</h6>
                            </div>
                            <div class="widget-info">
                                <h2>{{ Auth::user()->currency_symbol . '' . number_format($membership_data['balance'], 2) }}
                                </h2>
                                {{-- <p>GBP</p> --}}
                            </div>
                            @if($membership_type != 'Professional Fund' && $membership_type != 'Bespoke Trading')

                            <p class="trx-info mb-0">Withdrawn
                                {{ Auth::user()->currency_symbol . '' . number_format($membership_data['total_withdraw'], 2) }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card-deposit" style="min-height: 150px">
                            <div class="widget-title mb-3">
                                <h6>Total Deposit</h6>
                                {{-- <p class="text-success">133% <span><i class="las la-arrow-up"></i></span></p> --}}
                            </div>
                            <div class="widget-info">
                                <h2>{{ Auth::user()->currency_symbol . '' . number_format($membership_data['total_deposit'], 2) }}
                                </h2>
                                {{-- <p>GBP</p> --}}
                            </div>
                            @if (!$membership_data['transactions']->isEmpty())
                            <p class="trx-info mb-0">Updated
                                {{ date('d/m/Y', strtotime($membership_data['transactions']->first()->transaction_date)) }}
                            </p>
                            @endif

                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card-profit" style="min-height: 150px">
                            <div class="widget-title mb-3">
                                <h5>Total Profit</h5>
                                {{-- @if ($profit > 0)
                                            <p class="text-success">{{ $profit_percentage }}% <span><i
                                        class="las la-arrow-up"></i></span></p>
                                @endif --}}
                            </div>
                            <div class="widget-info">
                                <h2>{{ Auth::user()->currency_symbol . '' . number_format($membership_data['profit'], 2) }}
                                </h2>
                                {{-- <p>GBP</p> --}}
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
                                                <th>Membership Type</th>
                                                <th>Authorised By</th>
                                            </thead>
                                            <tbody>
                                                @forelse ($membership_data['transactions'] as $transaction)
                                                <tr>
                                                    <td>
                                                        {{ date('d-m-Y', strtotime($transaction->transaction_date)) }}
                                                    </td>

                                                    <td>
                                                        {{ $transaction->currency_symbol." ". $transaction->transaction_amount }}
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
                                                        {{$transaction->membership->type}}
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
                    @if (!$membership_data['trades']->isEmpty())
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <h4 class="card-title">Interest Payment</h4>
                            </div>
                            <div class="card-body pt-0">
                                <div class="transaction-table">
                                    <div class="table-responsive">
                                        <table class="table mb-0 ">
                                            <thead class="bg-dark text-light">
                                                <th>Date</th>
                                                <th>Profit</th>
                                                <th>Membership Type</th>

                                            </thead>
                                            <tbody>
                                                @forelse ($membership_data['trades'] as $trade)
                                                <tr>
                                                    <td>
                                                        {{date('d-m-Y',strtotime($trade->trade_date))}}
                                                    </td>
                                                    <td>{{$trade->reward.'%'}}</td>
                                                    <td>
                                                        {{$trade->membership->type}}
                                                    </td>

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
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
$(function() {
    $('.notes-popover').popover({
        container: 'body'
    });
});
</script>
<script>
$(function() {
    $("#datepicker").datepicker();
});
</script>
<script src="{{ asset('vendor/validator/jquery.validate.js') }}"></script>
<script src="{{ asset('vendor/validator/validator-init.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const membershipTypeSelect = document.getElementById('membership_type_select');
    const transactionTypeSelect = document.getElementById('transaction_type_select');

    // Event listener for membership type change
    // membershipTypeSelect.addEventListener('change', function () {
    //     const selectedMembership = this.value;
    //     // If membership type is "Professional Fund" || 'Bespoke Trading', hide withdraw option
    //     if (selectedMembership === 'Professional Fund' || selectedMembership === 'Bespoke Trading') {
    //         transactionTypeSelect.querySelector('option[value="withdraw"]').style.display = 'none';
    //         // Select the "Deposit" option
    //         transactionTypeSelect.value = 'deposit';
    //     } else {
    //         transactionTypeSelect.querySelector('option[value="withdraw"]').style.display = '';
    //     }
    // });

    // Trigger change event initially to handle default selection
    membershipTypeSelect.dispatchEvent(new Event('change'));
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select the dropdown
    const clientMembershipTypeSelect = document.getElementById('client_membership_type_select');

    var rows = document.querySelectorAll('.membership-row');

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

    //
    const defaultSelectedClientMembership = clientMembershipTypeSelect.value;
    showHideRows(defaultSelectedClientMembership);

    // Add event listener for selection change
    clientMembershipTypeSelect.addEventListener('change', function(event) {
        // Get the selected value
        const selectedMembershipType = event.target.value;

        showHideRows(selectedMembershipType);
    });
});
</script>
@endsection