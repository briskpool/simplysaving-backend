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
                    <div class="card-header border-0">
                        <h4 class="card-title">All Teams</h4>
                        <a href="{{route('teams.create')}}">
                            <button  class="btn btn-primary btn-sm"> Add New Team</button>
                        </a>
                        
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{route('teams.filter')}}" id="events_form" method="POST">
                            @csrf 
                            <select id="events" name="event_id" class="form-control col-xl-3 col-12">
                                @foreach ($events as $event)
                                    <option value="{{$event->id}}" {{request()->event_id==$event->id?'selected':''}}>{{$event->event_name}}</option>
                                @endforeach
                            </select>
                        </form>
                        <div class="transaction-table">
                            <div class="table-responsive">
                                <table class="table mb-0 table-responsive-sm">
                                    <thead >
                                        <tr class="bg-dark text-light">
                                            <th>Logo</th>
                                            <th>Name</th>
                                            <th>Event</th>
                                            <th>Created At</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($teams as $team)
                                        <tr>
                                            <td>
                                               
                                                <div class="media">
                                                    <span class="justify-content-center">
                                                        <img class="rounded-circle" src="{{Storage::disk('public')->exists('teams/'.$team->team_img)?$image=asset('storage/teams/'.$team->team_img):$image=asset('images/'.$team->team_img)}}"  width="60" height="60" alt="">
                                                    </span>
                                                </div>
                                                
                                            </td>
                                            <td>
                                                {{$team->team_name}}
                                            </td>
                                            <td>
                                                {{$team->event_name}}
                                            </td>

                                            <td>
                                                {{$team->created_at}}
                                            </td>
                                           
                                           
                                            <td>
                                                <a class="round-btn" href="{{route('teams.edit', $team->id)}}"><i class="mdi mdi-pen"></i></a>
                                                <a class="round-btn" href="#" onclick="delete_row('myForm{{$team->id}}')"><i class="mdi mdi-delete"></i></a>
                                                <form action="{{route('teams.destroy',$team->id)}}" id="myForm{{$team->id}}" method="post">
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


