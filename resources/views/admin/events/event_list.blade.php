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
                        <h4 class="card-title">All Events</h4>
                        <a href="{{route('events.create')}}">
                            <button  class="btn btn-primary btn-sm"> Add New Event</button>
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
                                            <th>Created At</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($events as $event)
                                        <tr>
                                            <td>
                                               
                                                <div class="media">
                                                    <span class="justify-content-center">
                                                        <img src="{{Storage::disk('public')->exists('events/'.$event->event_img)?$image=asset('storage/events/'.$event->event_img):$image=asset('images/'.$event->event_img)}}"  width="60" height="60" alt="">
                                                    </span>
                                                </div>
                                                
                                            </td>
                                            <td>
                                                {{$event->event_name}}
                                            </td>

                                            <td>
                                                {{$event->created_at}}
                                            </td>
                                           
                                           
                                            <td>
                                                <a class="round-btn" href="{{route('events.show', $event->id)}}"><i class="mdi mdi-eye"></i></a>
                                                <a class="round-btn" href="{{route('events.edit', $event->id)}}"><i class="mdi mdi-pen"></i></a>
                                                <a class="round-btn" href="#" onclick="delete_row('myForm{{$event->id}}')"><i class="mdi mdi-delete"></i></a>
                                                <form action="{{route('events.destroy',$event->id)}}" id="myForm{{$event->id}}" method="post">
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


