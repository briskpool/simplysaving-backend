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
                        <a href="{{route('trade-statement')}}">Dashboard </a>
                        <span>/</span>
                        <span>Help</span>
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Help</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('help.request')}}" name="myform" class="personal_validate" novalidate="novalidate" >
                            @csrf
                            <div class="form-row">
                                <p>
                                    If you're unsure about something in your account or have a general question, please use this form to send a message to Customer Support.
                                </p>
                               
                                <div class="form-group col-xl-12">
                                    <label>Your Question</label>
                                    <textarea name="question" rows="5" class="form-control py-2" required placeholder="Enter your question here">{{old('question')}}</textarea>
                                    @error('question')
                                    <label id="question-error" class="error" for="question">{{ $message }}</label>
                                    @enderror    
                                </div>
                                <p>
                                    Once submitted your request will be reviewed by our Customer Support team.
                                </p>

                                <div class="form-group text-center col-12">
                                    <button class="btn btn-primary pl-5 pr-5">Send Message</button>
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

