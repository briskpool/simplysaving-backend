<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\User\SecurityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    
    public function index()
    {
        $security_questions = SecurityQuestion::all();
        return view('profile.profile_security', compact('security_questions'));
    }

    public function secure(Request $request){
        if($request->has('is_secure')){
        $request->validate(
            [
            'security_question_id' => 'required',
            'security_answer' => 'required|min:3',
            ],[
                'security_question_id.required' => 'Please select a question',
                'security_answer.required' => 'Answer is required',
                'security_answer.min' => 'Please enter minimum 3 character',
            ]
        );

        Client::where('id', Auth::user()->id)->update(
            [
                'is_secure' => 1,
                'security_question_id' => $request->security_question_id,
                'security_answer' => $request->security_answer,
            ]
        );


        }else{
        Client::where('id', Auth::user()->id)->update(
            [
                'is_secure' => 0,
                'security_question_id' => NULL,
                'security_answer' => NULL,
            ]
        );
        }
        return redirect()->route('security');
    }
}
