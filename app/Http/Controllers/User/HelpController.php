<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Notifications\HelpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class HelpController extends Controller
{
   
    public function help(Request $request)
   {
       if($request->has('question')){
            $request->validate([
                'question' => 'required'
            ]);

            $admin = Client::where('is_admin', 1)->first();

            $data = [
                'question' => $request->question,
                'email' => Auth::user()->email,
                'full_name' =>Auth::user()->first_name.' '.Auth::user()->last_name,
            ];
  
            Notification::send($admin, new HelpNotification($data));

            $notification = array(
                'message' => 'Help request sent successfully!',
                'alert-type' => 'success'
                );

            return redirect()->route('help')->with($notification);
        
       }else{

           return view('user.help');
       }
   }
}
