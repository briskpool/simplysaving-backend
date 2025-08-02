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
                <div class="col-xl-12 mb-3 text-right">
                    @include('admin.trades._add-trade-button')
                </div>

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0">
                            @include('admin.trades._trade-list-menu')
                        </div>
                        <div class="card-body pt-0">

                            <div class="transaction-table">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-responsive-trade-list">
                                        <thead class="bg-dark text-light">
                                            <th>Date</th>
                                            <th>Event</th>
                                            <th>Player 1</th>
                                            <th>Player 2</th>
                                            <th>Reward</th>
                                            <th>Result</th>
                                            <th>Trade</th>
                                            {{-- <th>Action</th> --}}
                                        </thead>
                                        <tbody>
                                            @forelse ($table_tennis_trades as $trade)
                                                <tr>
                                                    <td>
                                                        {{ date('d-m-Y', strtotime($trade->trade_date)) }}
                                                    </td>

                                                    <td>
                                                        <div class="media">
                                                            <span class="justify-content-center">
                                                                <img src="{{ Storage::disk('public')->exists('events/' . $trade->event_img)? ($image = asset('storage/events/' . $trade->event_img)): ($image = asset('images/' . $trade->event_img)) }}"
                                                                    height="30" alt="">
                                                                <span
                                                                    class="ml-2">{{ $trade->event_name }}</span>
                                                            </span>

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="media">
                                                            <span class="justify-content-center">
                                                                <img src="{{ Storage::disk('public')->exists('teams/' . $trade->player_1_img)? ($image = asset('storage/teams/' . $trade->player_1_img)): ($image = asset('images/' . $trade->player_1_img)) }}"
                                                                    height="30" alt="">
                                                                <span class="ml-2">{{ $trade->player_1_name }}
                                                                    <b>({{ $trade->team_one_score }})</b></span>
                                                            </span>

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="media">
                                                            <span class="justify-content-center">
                                                                <img src="{{ Storage::disk('public')->exists('teams/' . $trade->player_2_img)? ($image = asset('storage/teams/' . $trade->player_2_img)): ($image = asset('images/' . $trade->player_2_img)) }}"
                                                                    height="30" alt="">
                                                                <span class="ml-2">{{ $trade->player_2_name }}
                                                                    <b>({{ $trade->team_two_score }})</b></span>
                                                            </span>

                                                        </div>
                                                    </td>
                                                    <td>{{ $trade->reward . '%' }}</td>
                                                    <td>
                                                        @if ($trade->result == 'win')
                                                            <span
                                                                class="badge badge-success">{{ ucfirst($trade->result) }}</span>
                                                        @else
                                                            <span
                                                                class="badge badge-danger text-light">{{ ucfirst($trade->result) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($trade->notes != '')
                                                            <a class="round-btn notes-popover" role="button" tabindex="0"
                                                                data-toggle="popover" data-trigger="focus"
                                                                data-content="{{ $trade->notes }}"
                                                                href="javascript:void(0)"><i class="mdi mdi-eye"></i></a>
                                                        @endif
                                                    </td>
                                                    {{-- <td>
                                                <a class="round-btn" href="{{route('trades.edit', $trade->id)}}"><i class="mdi mdi-pen"></i></a>
                                                <a class="round-btn" href="#" onclick="delete_row('myForm{{$trade->id}}')"><i class="mdi mdi-delete"></i></a>
                                                <form action="{{route('trades.destroy',$trade->id)}}" id="myForm{{$trade->id}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td> --}}
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
@section('scripts')
    <script>
        $(function() {
            $('.notes-popover').popover({
                container: 'body'
            });


        })
    </script>
@endsection
