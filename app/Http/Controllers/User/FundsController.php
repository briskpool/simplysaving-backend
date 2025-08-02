<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Notifications\AddFundsNotification;
use App\Notifications\WithdrawFundsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class FundsController extends Controller
{


  public function add_funds(Request $request)
  {
    if($request->has('amount')){
      $request->validate([
        'amount' => 'required|gt:0'
      ]);

      $admin = Client::where('is_admin', 1)->first();

    $data = [
        'currency_symbol'=> Auth::user()->currency_symbol,
        'amount' => $request->amount,
        'email' => Auth::user()->email,
        'full_name' =>Auth::user()->first_name.' '.Auth::user()->last_name,
        'membership'=> $request->membership_type,
    ];

    Notification::send($admin, new AddFundsNotification($data));

    $notification = array(
    'message' => 'Request sent successfully!',
    'alert-type' => 'success'
    );

    return redirect()->route('add-funds')->with($notification);
    
    } else {
      $client = Auth::user();
      $client_membership_type = json_decode($client->membership_type);
      // Check if $client->membership_type is not JSON encoded
      if ($client_membership_type == null) {
        // Encode it to JSON
        $encoded_membership_type = json_encode([$client->membership_type]);
        // Update the $client object
        $client->membership_type = json_decode($encoded_membership_type);
      } else {
        $client->membership_type = $client_membership_type;
      }
      return view('user.add_funds', compact('client'));
    }
  }


  public function withdraw_funds(Request $request)
  {
      if($request->has('amount')){
        $request->validate([
          'amount' => 'required|gt:0'
        ]);

        $admin = Client::where('is_admin', 1)->first();

      $data = [
          'amount' => $request->amount,
          'reason' => $request->reason,
          'currency_symbol' => Auth::user()->currency_symbol,
          'email' => Auth::user()->email,
          'full_name' =>Auth::user()->first_name.' '.Auth::user()->last_name,
          'membership'=> $request->membership_type,
        ];

      Notification::send($admin, new WithdrawFundsNotification($data));

      $notification = array(
      'message' => 'Withdrawal request sent successfully!',
      'alert-type' => 'success'
      );

      return redirect()->route('withdraw-funds')->with($notification);
    } else {
      $client = Auth::user();
      $client_membership_type = json_decode($client->membership_type);
      // Check if $client->membership_type is not JSON encoded
      if ($client_membership_type == null) {
        // Encode it to JSON
        $encoded_membership_type = json_encode([$client->membership_type]);
        // Update the $client object
        $client->membership_type = json_decode($encoded_membership_type);
      } else {
        $client->membership_type = $client_membership_type;
      }
      return view('user.withdraw_funds', compact('client'));
    }
  }
}
