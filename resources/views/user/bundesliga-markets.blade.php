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
                        <span>Football Markets</span>
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
                    <div class="card-header border-0">
                        {{-- {{Route::current()->getName()=='footbal-markets'?'selected':''}} --}}
                        {{-- <h4 class="card-title">Football Statistics</h4> --}}
                        {{-- {{Route::current()->getName()}} --}}
                            <select id="league" class="form-control col-xl-3 col-12">
                                <option value="/football-markets" {{Route::current()->getName()=='football-markets'?'selected':''}}>Premier League</option>
                                <option value="/football-markets/bundesliga" {{Route::current()->getName()=='bundesliga'?'selected':''}}>Bundesliga</option>
                                <option value="/football-markets/french-league" {{Route::current()->getName()=='french-league'?'selected':''}}>French Ligue</option>
                                <option value="/football-markets/laliga" {{Route::current()->getName()=='laliga'?'selected':''}}>La Liga</option>
                                <option value="/football-markets/uefa" {{Route::current()->getName()=='uefa'?'selected':''}}>UEFA Champions League</option>
                            </select>
                        
                         {{-- <a href="{{route('clients.create')}}">
                            <button  class="btn btn-primary btn-sm"> Add New Client</button>
                        </a> --}}
                    </div>
                    <div class="card-body pt-0">
                        <div id="wg-api-football-fixtures"
                            data-host="api-football-v1.p.rapidapi.com"
                            data-refresh="60"
                            data-date=""
                            data-league="78"
                            data-team=""
                            data-season="2022"
                            data-last="20"
                            data-next=""
                            data-key={{env('FOOTBALL_API_KEY')}}
                            data-theme=""
                            data-show-errors="false"
                            class="api_football_loader">
                        </div>

                    </div>
                </div>
            </div>
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
                                    data-key="5a064d629amsh0e00769af305bdap180755jsnb03e3a7f19f0"
                                    data-theme=""
                                    data-show-errors="false"
                                    class="api_football_loader">
                                </div>
       
                            </div>
                        </div>
            </div> --}}
           
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script
    type="module"
    src="https://widgets.api-sports.io/football/1.1.8/widget.js">
</script>

<script>
    $('#league').change(function(){
        console.log($('#league').val());
        window.location.href = $('#league').val();
    });
    $(function () {
        $('.dropdown-toggle').dropdown()
        $('.notes-popover').popover({
            container: 'body'
        })
    })
</script>

@endsection

