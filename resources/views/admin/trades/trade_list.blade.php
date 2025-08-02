@extends('layouts.app')
@section('content')
    @include('layouts.partials.header')
    @include('layouts.partials.sidebar')

    <div class="page_title">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="page_title-content">
                        <p>Welcome Back,
                            <span>Admin</span>
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
                        <div class="row d-flex align-items-center p-2">
                            <div class="col-md-6 col-12">
                                <h4 class="card-title">All Interest Payments</h4>

                            </div>
                            <div class="col-md-6 col-12 pt-3 d-flex justify-content-lg-end justify-content-start">
                                <a href="{{ route('interests.create') }}">
                                    <button class="btn btn-primary btn-sm">
                                        Add Interest Payment
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center p-2">
                            <div class="col-md-6 col-12 mb-2">

                                @if (request()->has('month_filter'))
                                    <span class="badge badge-pill badge-light text-danger"
                                        style="font-size: 16px;  font-weight:400;">Showing Results of
                                        {{ request()->month_filter }}<a href="{{ route('interests.index') }}"
                                            class="text-dark"><i class="mdi mdi-close"></i></a> </span>
                                @else
                                    @if (count($trades) > 0)
                                        <span class="badge badge-pill badge-light text-dark"
                                            style="font-size: 16px; font-weight:400;">Showing Results of
                                            {{ Carbon\Carbon::CreateFromFormat('m', $trades->first()->created_at->month)->format('F Y') }}
                                        </span>
                                    @else
                                        <span class="badge badge-pill badge-light text-dark"
                                            style="font-size: 16px; font-weight:400;">Showing Results of
                                            {{ Carbon\Carbon::now()->format('F Y') }} </span>

                                    @endif
                                @endif
                            </div>
                            <div class="col-md-6 col-12 d-flex justify-content-lg-end justify-content-start">
                                <button type="button" class="btn btn-dark btn-sm mr-1 px-2 py-1"
                                    style="min-width: 0px !important; text-transform:capitalize;" data-toggle="modal"
                                    data-target="#exampleModal">
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
                                            <th>Client</th>
                                            <th>Membership Type</th>
                                            <th>Profit</th>

                                        </thead>
                                        <tbody>
                                            @forelse ($trades as $trade)
                                                <tr>
                                                    <td>
                                                        {{ date('d-m-Y', strtotime($trade->trade_date)) }}
                                                    </td>


                                                    <td>{{ $trade->first_name . ' ' . $trade->last_name }}</td>
                                                    <td>{{ $trade->membership->type}} </td>
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

            </div>
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
                    <form name="myform" class="personal_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-xl-12">
                                <label>Select Month</label>
                                <input type="text" class="form-control" placeholder="Select month" data-date=""
                                    id="monthPicker" autocomplete="off"
                                    @if (count($trades)>0)
                                    value="{{ request()->month_filter ?? Carbon\Carbon::CreateFromFormat('m', $trades->first()->created_at->month)->format('F Y') }}"
                                    {{ Carbon\Carbon::CreateFromFormat('m', $trades->first()->created_at->month)->format('F Y')}}
                                    @else
                                    value="{{ Carbon\Carbon::now()->format('F Y')}}"                                        
                                    @endif
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
            $('.notes-popover').popover({
                container: 'body'
            });

            $('#table').DataTable({
                searching: false,
                ordering: false
            });
        })
    </script>
    <script src="{{ asset('js/plugins/jquery-ui-init.js') }}"></script>
    <script src="{{ asset('js/plugins/monthpicker.js') }}"></script>
@endsection
