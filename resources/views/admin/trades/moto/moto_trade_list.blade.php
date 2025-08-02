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
                                        <th>Driver</th>
                                        <th>Position</th>
                                        <th>Reward</th>
                                        <th>Result</th>
                                        <th>Trade</th>
                                        {{-- <th>Action</th> --}}
                                    </thead>
                                    <tbody>
                                        @forelse ($motoTrades as $motoTrade)
                                        <tr>
                                            <td>
                                                {{date('d-m-Y',strtotime($motoTrade->trade_date))}}
                                            </td>

                                            <td>
                                                <div class="media">
                                                    <span class="justify-content-center">
                                                        <img src="{{Storage::disk('public')->exists('events/'.$motoTrade->event_img)?$image=asset('storage/events/'.$motoTrade->event_img):$image=asset('images/'.$motoTrade->event_img)}}"  height="30" alt="">
                                                        <span class="ml-2">{{$motoTrade->event_name}}</span>
                                                    </span>
                                                   
                                                </div>
                                            </td>
                                            <td>
                                                <div class="media">
                                                    <span class="justify-content-center">
                                                        <img src="{{Storage::disk('public')->exists('teams/'.$motoTrade->t1_img)?$image=asset('storage/teams/'.$motoTrade->t1_img):$image=asset('images/'.$motoTrade->t1_img)}}"  height="30" alt="">
                                                        <span class="ml-2">{{$motoTrade->t1_name}}</span>
                                                    </span>
                                                   
                                                </div>
                                            </td>
                                            <td>
                                                {{$motoTrade->team_one_score}}
                                            </td>
                                           
                                            <td>{{$motoTrade->reward.'%'}}</td>
                                            <td>
                                                @if ($motoTrade->result == "winner")
                                                <span class="badge badge-success">{{ucfirst($motoTrade->result)}}</span>
                                                @else
                                                <span class="badge badge-danger text-light">{{ucfirst($motoTrade->result)}}</span>
                                                @endif
                                            </td>
                                            <td>
                                               @if ($motoTrade->notes != '')
                                               <a class="round-btn notes-popover"  role="button" data-toggle="popover" data-trigger="focus" data-content="{{$motoTrade->notes}}" href="javascript:void(0)"><i class="mdi mdi-eye"></i></a>
                                               @endif
                                            </td>
                                            {{-- <td>
                                                <a class="round-btn" href="{{route('moto-trades.edit', $motoTrade->id)}}"><i class="mdi mdi-pen"></i></a>
                                                <a class="round-btn" href="#" onclick="delete_row('myForm{{$motoTrade->id}}')"><i class="mdi mdi-delete"></i></a>
                                                <form action="{{route('moto-trades.destroy',$motoTrade->id)}}" id="myForm{{$motoTrade->id}}" method="post">
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
        $(function () {
  $('.notes-popover').popover({
    container: 'body'
  })
})
    </script>
@endsection

