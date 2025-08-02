<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'user']);
    }

    /**
     * Display the password confirmation view.
     *
     * @return \Illuminate\Http\Response
     */
    public function showConfirmForm()
    {
        $securityQuestion = Client::where('users.id', Auth::user()->id)
        ->join('security_questions', 'users.security_question_id', 'security_questions.id')
        ->select('security_questions.question', 'security_questions.id')->first();

        return view('auth.passwords.confirm', compact('securityQuestion'));
    }

    /**
     * Confirm the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function confirm(Request $request)
    {
        $client=Client::find(auth()->user()->id);
        // dd($client);
        if ($request->input('security_answer')) {
            if (ucfirst(auth()->user()->security_answer) != ucfirst($request->input('security_answer'))) {
                if($client->attempts == 4){
                    $client->attempts = 0;
                    $client->status = 'inactive';
                    $client->save();
                   
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['account_locked' => 'We have suspended your account for security reasons']);
                }else{
                    $attempts = $client->attempts + 1;
                    $client->attempts = $attempts;
                    $client->save();
                }
                return back()->withInput()->withErrors(['security_answer' => 'Sorry, wrong answer']);
            }
        } else {
           
            $request->validate($this->rules(), $this->validationErrorMessages());
        }
        $client->attempts = 0;
        $client->save();
        $this->resetPasswordConfirmationTimeout($request);

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->intended($this->redirectPath());
    }
}