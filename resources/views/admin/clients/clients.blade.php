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
                        <h4 class="card-title">All Clients</h4>
                        <a href="{{route('clients.create')}}">
                            <button  class="btn btn-primary btn-sm"> Add New Client</button>
                        </a>
                    </div>
                    <div class="card-body pt-0">
                        <div class="transaction-table">
                            <div class="table-responsive">
                                <table class="table mb-0 table-responsive-trade">
                                    <thead >
                                        <tr class="bg-dark text-light">
                                            <th></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Interests</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clients as $client)
                                        <tr>
                                           <td>
                                            <div class="media">
                                                <span class="justify-content-center">
                                                    <img src="{{Storage::disk('public')->exists('users/'.$client->profile_img)?$image=asset('storage/users/'.$client->profile_img):$image=asset('images/'.$client->profile_img)}}"  height="50" alt="">
                                                </span>
                                            </div>
                                           </td>
                                            <td>
                                                @if ($client->email_verified_at)
                                                    <i class="mdi mdi-check-circle text-success"></i>
                                                @endif
                                                {{$client->first_name}}
                                            </td>

                                            <td>
                                                {{$client->email}}
                                            </td>
                                            <td>
                                               {{count($client->trades)}}
                                            </td>
                                            <td>
                                                {{$client->currency_symbol." ".$client->client_balance}}
                                            </td>
                                           
                                            <td>
                                                <a class="round-btn" href="{{route('clients.show', Crypt::encrypt($client->id))}}"><i class="mdi mdi-eye"></i></a>
                                                <a class="round-btn" href="{{route('clients.edit', Crypt::encrypt($client->id))}}"><i class="mdi mdi-pen"></i></a>
                                                <a class="round-btn" href="#" onclick="delete_row('myForm{{$client->id}}')"><i class="mdi mdi-delete"></i></a>
                                                <form action="{{route('clients.destroy',$client->id)}}" id="myForm{{$client->id}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>  
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                No Record
                                            </td>
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


