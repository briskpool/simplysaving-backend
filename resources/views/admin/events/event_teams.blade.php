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
                        <a href="{{route('events.index')}}">Events </a>
                        <span>/</span>
                        <span>Event Teams</span>
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
                        <h4 class="card-title">Event Teams</h4>
                        <a href="{{route('teams.create')}}">
                            <button  class="btn btn-primary btn-sm"> Add New Team</button>
                        </a>
                    </div>
                    <div class="card-body pt-0">
                        <div class="transaction-table">
                            <div class="table-responsive">
                                <table class="table mb-0 table-responsive-sm">
                                    <thead >
                                        <tr class="bg-dark text-light">
                                            <th>Logo</th>
                                            <th>Name</th>
                                            <th>Event Name</th>
                                            <th>Created At</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($event_teams as $event_team)
                                        <tr>
                                            <td>
                                               
                                                <div class="media">
                                                    <span class="justify-content-center">
                                                        <img class="rounded-circle" src="{{Storage::disk('public')->exists('teams/'.$event_team->team_img)?$image=asset('storage/teams/'.$event_team->team_img):$image=asset('images/'.$event_team->team_img)}}"  width="60" height="60" alt="">
                                                    </span>
                                                </div>
                                                
                                            </td>
                                            <td>
                                                {{$event_team->team_name}}
                                            </td>
                                            <td>
                                                {{$event_team->event_name}}
                                            </td>

                                            <td>
                                                {{$event_team->created_at}}
                                            </td>
                                           
                                           
                                            <td>
                                                <a class="round-btn" href="{{route('teams.edit', $event_team->id)}}"><i class="mdi mdi-pen"></i></a>
                                                <a class="round-btn" href="#" onclick="delete_row('myForm{{$event_team->id}}')"><i class="mdi mdi-delete"></i></a>
                                                <form action="{{route('teams.destroy',$event_team->id)}}" id="myForm{{$event_team->id}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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
        </div>
    </div>
</div>

@endsection


