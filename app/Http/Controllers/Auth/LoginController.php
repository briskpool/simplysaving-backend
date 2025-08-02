<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    // use ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $maxAttempts = 3; // Default is 5
    // protected $decayMinutes = 1; // Default is 1
     

     
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
 * Handle a login request to the application.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
 *
 * @throws \Illuminate\Validation\ValidationException
 */
public function login(Request $request)
{
    $password = $request->input('password'); 
    $client= User::where('email', $request->input('email'))->first();

    if ($client) {
        if (Crypt::decrypt($client->password) == $password) {
            if($client->status != 'active'){
                return back()->withErrors(['account_locked' => 'We have suspended your account for security reasons']);
            }
            Auth::login($client);
            
            if(Auth::user()->is_admin){
                $redirectTo='/clients';
            }else{
                $redirectTo='/trade-statement';
            }
            return redirect($redirectTo);

        }
    }

    return $this->sendFailedLoginResponse($request);
}
}
