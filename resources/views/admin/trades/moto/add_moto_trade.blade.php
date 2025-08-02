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
                            <a href="{{ route('trades.index') }}">Trades </a>
                            <span>/</span>
                            <span>Add Motorsport Trade</span>
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
                            <h4 class="card-title">Add Trade</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('moto-trades.store') }}" name="myform"
                                class="personal_validate" novalidate="novalidate" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">

                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2">Date</label>
                                        <input type="text" class="form-control" placeholder="Select date" id="datepicker"
                                            autocomplete="off" value="{{ old('trade_date') }}" readonly required
                                            name="trade_date">
                                        @error('trade_date')
                                            <label id="trade_date-error" class="error"
                                                for="trade_date">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2">Event</label>
                                        <select class="form-control" required id="event" name="event_id">
                                            <option value="">--choose event--</option>
                                            @foreach ($events as $id => $event)
                                                <option value="{{ $id }}"
                                                    {{ old('event_id') == $id ? 'selected' : '' }}>{{ $event }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('event_id')
                                            <label id="event_id-error" class="error"
                                                for="event_id">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2">Driver</label>
                                        <select class="form-control" id="team_one" required name="team_one_id">
                                            <option value="">--choose driver--</option>

                                        </select>
                                        @error('team_one_id')
                                            <label id="team_one_id-error" class="error"
                                                for="team_one_id">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2">Position</label>
                                        <input type="text" class="form-control" required placeholder="Enter Position"
                                            value="{{ old('team_one_score') }}" name="team_one_score">
                                        @error('team_one_score')
                                            <label id="team_one_score-error" class="error"
                                                for="team_one_score">{{ $message }}</label>
                                        @enderror
                                    </div>



                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2">Result</label>
                                        <select class="form-control" required name="result">
                                            <option value="">--choose result--</option>
                                            <option value="winner" {{ old('result') == 'winner' ? 'selected' : '' }}>
                                                Winner
                                            </option>
                                            <option value="podium" {{ old('result') == 'podium' ? 'selected' : '' }}>
                                                Podium
                                            </option>
                                        </select>
                                        @error('result')
                                            <label id="result-error" class="error"
                                                for="result">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2">Reward %</label>
                                        <input type="number" class="form-control" required placeholder="Enter Reward %"
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

                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2">Client</label>
                                        <select class="form-control" required name="user_id">
                                            <option value="">--choose client--</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}"
                                                    {{ old('user_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->first_name . ' ' . $client->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('event_id')
                                            <label id="event_id-error" class="error"
                                                for="event_id">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <label class="mr-sm-2">Trade <span class="text-muted"
                                                style="font-size:12px; font-weight:400">(Optional)</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Trade"
                                            value="{{ old('notes') }}" name="notes">
                                        @error('notes')
                                            <label id="notes-error" class="error"
                                                for="notes">{{ $message }}</label>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="running_total" value="2">


                                    <div class="form-group text-right col-12">
                                        <button class="btn btn-primary pl-5 pr-5">Save Trade</button>
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
    <script>
        old_team_one = "{{ old('team_one_id') }}";
        selected_team_one = '';
        selected_team_two = '';
        var eventID = $('#event').val();
        if (eventID) {
            $.ajax({
                url: "{{ url('get-team') }}?event_id=" + eventID,
                type: "Get",
                success: function(res) {
                    if (res) {
                        $("#team_one").empty();
                        $("#team_one").append('<option value="">--choose driver--</option>');
                        $.each(res, function(key, value) {
                            selected_team_one = '';
                            selected_team_two = '';
                            // console.log(old_team_one+'-'+value);
                            if (old_team_one == value) {
                                selected_team_one = 'selected';
                            } else if (old_team_two == value) {
                                selected_team_two = 'selected';
                            }

                            $("#team_one").append('<option value="' + value + '" ' + selected_team_one +
                                '>' + key + '</option>');
                            $("#team_two").append('<option value="' + value + '"' + selected_team_two +
                                '>' + key + '</option>');
                        });

                    } else {
                        $("#team_one").empty();
                        $("#team_one").append('<option value="">--choose event first--</option>');

                    }
                }
            });
        } else {
            $("#team_one").empty();
            $("#team_one").append('<option value="">--choose event first--</option>');
        }

        $('#event').change(function() {
            var eventID = $(this).val();
            if (eventID) {
                $.ajax({
                    url: "{{ url('get-team') }}?event_id=" + eventID,
                    type: "Get",
                    success: function(res) {
                        if (res) {
                            $("#team_one").empty();
                            $("#team_one").append('<option value="">--choose driver--</option>');
                            $.each(res, function(key, value) {
                                $("#team_one").append('<option value="' + value + '">' + key +
                                    '</option>');
                                $("#team_two").append('<option value="' + value + '">' + key +
                                    '</option>');
                            });
                        } else {
                            $("#team_one").empty();
                            $("#team_one").append('<option value="">--choose event first--</option>');
                        }
                    }
                });
            } else {
                $("#team_one").empty();
                $("#team_one").append('<option value="">--choose event first--</option>');
            }
        });
    </script>
    <script>
        $('#datepicker').datepicker();
    </script>

    <script src="{{ asset('vendor/validator/jquery.validate.js') }}"></script>
    <script src="{{ asset('vendor/validator/validator-init.js') }}"></script>
@endsection
