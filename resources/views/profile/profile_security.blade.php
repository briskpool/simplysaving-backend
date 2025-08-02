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
                        <a href="{{auth()->user()->is_admin?route('clients.index'):route('trade-statement')}}">Home </a>
                        <span>/</span>
                        <span>Security</span>
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container">
        <div class="row">
            @include('layouts.partials.account_setting_menu')
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Security</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('security.update')}}" name="myform" id="myForm" class="personal_validate" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                               
                                <div class="form-group col-xl-6 mb-lg-3">
                                    <label class="toggle">
                                        <input class="toggle-checkbox" id="security" value="{{Auth::user()->is_secure}}" {{Auth::user()->is_secure?'checked':''}} name="is_secure"  type="checkbox">
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">Enable extra security</span>
                                    </label>
                                    
                                </div>
                            </div>
                            <div class="form-row d-none" id="security_questions">
                                <div class="form-group col-xl-12 mb-3">
                                    <label class="mr-sm-2">Security Question</label>
                                    <select name="security_question_id" class="form-control" id="">
                                        <option value="">Select Question</option>
                                        @foreach ($security_questions as $security_question)
                                        <option value="{{$security_question->id}}" {{Auth::user()->security_question_id == $security_question->id?'selected':''}}>{{$security_question->question}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-xl-12  mb-3">
                                    <label class="mr-sm-2">Answer</label>
                                    <input type="text" class="form-control" placeholder="Enter your answer here" value="{{Auth::user()->security_answer}}" name="security_answer">
                                    @error('security_answer')
                                    <label id="security_answer-error" class="error" for="security_answer">{{ $message }}</label>
                                    @enderror
                                </div>
                                

                                <div class="form-group text-right col-12 mt-3">
                                    <button class="btn btn-primary pl-5 pr-5">Save</button>
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

<script>

        if($("#security").is(':checked')){
        //    console.log($('#security_questions'));
            $('#security_questions').removeClass('d-none')
       }else{
            $('#security_questions').addClass('d-none')
       }
    $("#security").change(function(){
       if($("#security").is(':checked')){
        //    console.log($('#security_questions'));
            $('#security_questions').toggleClass('d-none')
       }else{
            $('#myForm').submit();
            $('#security_questions').toggleClass('d-none')
       }
    });
</script>
@endsection

