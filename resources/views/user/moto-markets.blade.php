@extends('layouts.app')
@section('styles')
    <style>
        #standings{
            font-family:'Roboto' !important;
        }
    </style>
@endsection
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
                        <span>Motorsport Markets</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container">
        <div class="row">
           
            {{-- <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h4 class="card-title">Football Statistics</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div id="wg-api-football-fixtures"
                            data-host="api-football-v1.p.rapidapi.com"
                            data-refresh="60"
                            data-date=""
                            data-league="39"
                            data-team=""
                            data-season="2021"
                            data-last="7"
                            data-next=""
                            data-key="2c254db3famsh3f8ef7b2d38b11ep1c40b9jsnb6f9f28d0bb3"
                            data-theme=""
                            data-show-errors="false"
                            class="api_football_loader">
                        </div>

                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-xl-12">
                <div class="card">
                            <div class="card-header border-0">
                                <h4 class="card-title">Football Statistics</h4>
                            </div>
                            <div class="card-body pt-0">
                                <div id="wg-api-football-fixtures"
                                    data-host="api-football-v1.p.rapidapi.com"
                                    data-refresh="60"
                                    data-date=""
                                    data-league="78"
                                    data-team=""
                                    data-season="2021"
                                    data-last="7"
                                    data-next=""
                                    data-key="2c254db3famsh3f8ef7b2d38b11ep1c40b9jsnb6f9f28d0bb3"
                                    data-theme=""
                                    data-show-errors="false"
                                    class="api_football_loader">
                                </div>
       
                            </div>
                        </div>
            </div> --}}
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h4 class="card-title">Formula 1 Statistics</h4>
                        
                    </div>
                    <div class="card-body pt-0 table-responsive">
                        <span class="" id="competition_name"></span>
                        <table class="table table-responsive-trade" id="standing_table">
                            <!-- Data coming from javascript (matches.js) -->
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script
    type="module"
    src="https://widgets.api-sports.io/football/1.1.8/widget.js">
</script>

@include('user.f1-ranks')
<script>
    $(function () {
        $('.notes-popover').popover({
            container: 'body'
        })
    })
</script>

@endsection

