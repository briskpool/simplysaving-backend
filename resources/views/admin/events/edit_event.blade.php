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
                        <span>Edit Event</span>
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
                        <h4 class="card-title">Edit Event</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('events.update', $event->id)}}" name="myform" class="personal_validate" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-row">
                                <div class="form-group col-xl-12">
                                    <label class="mr-sm-2">Event Name</label>
                                    <input type="text" class="form-control" required placeholder="Premire League" value="{{$event->event_name}}" name="event_name">
                                    @error('event_name')
                                    <label id="event_name-error" class="error" for="event_name">{{ $message }}</label>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-xl-12">
                                    <div class="media align-items-center mb-3">
                                        <img class="mr-3 rounded-circle mr-0 mr-sm-3"
                                            src="{{Storage::disk('public')->exists('events/'.$event->event_img)?$image=asset('storage/events/'.$event->event_img):$image=asset('images/'.$event->event_img)}}" id="uploaded" width="55" height="55" alt="">
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
                                        <input name="event_img" type="file"
                                            class="file-upload-field" value="">
                                    </div>
                                </div>
                                
                               
                                <div class="form-group text-right col-12">
                                    <button class="btn btn-primary pl-5 pr-5">Update Event</button>
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

