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
                        <a href="{{route('teams.index')}}">Teams </a>
                        <span>/</span>
                        <span>Add New Team</span>
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
                        <h4 class="card-title">Add Team</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('teams.store')}}" name="myform" class="personal_validate" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-xl-12">
                                    <label class="mr-sm-2">Team Name</label>
                                    <input type="text" class="form-control" required placeholder="Barcelona" value="{{old('team_name')}}" name="team_name">
                                    @error('team_name')
                                    <label id="team_name-error" class="error" for="team_name">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-12">
                                    <label class="mr-sm-2">Event</label>
                                    <select class="form-control" required name="event_id">
                                        <option value="">--choose event--</option>
                                        @foreach ($events as $id => $event)
                                            <option value="{{$id}}" {{old('event_id')==$id?'selected':''}}>{{$event}}</option>
                                        @endforeach
                                    </select>
                                    @error('event_id')
                                    <label id="event_id-error" class="error" for="event_id">{{ $message }}</label>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-xl-12 mt-5">
                                    <div class="media align-items-center mb-3">
                                        <img class="mr-3 rounded-circle mr-0 mr-sm-3"
                                            src="{{asset('images/placeholder.jpg')}}" id="uploaded" width="55" height="55" alt="">
                                        <div class="media-body">
                                            {{-- <h4 class="mb-0"></h4> --}}
                                            <p class="mb-0">
                                                Supported files: jpg, png, svg
                                                <br>
                                                Max file size is 20mb
                                            </p>
                                        </div>
                                    </div>
                                    <div class="file-upload-wrapper" data-text="Change Photo">
                                        <input name="team_img" type="file"
                                            class="file-upload-field" value="">
                                    </div>
                                </div>
                                
                               
                                <div class="form-group text-right col-12">
                                    <button class="btn btn-primary pl-5 pr-5">Save Team</button>
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
<script src="{{asset('vendor/validator/jquery.validate.js')}}"></script>
<script src="{{asset('vendor/validator/validator-init.js')}}"></script>
@endsection

