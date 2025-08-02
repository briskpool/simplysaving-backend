<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Admin\Transaction;
use App\Models\MembershipTypes;
use App\Models\UserMembershipBalances;
use App\Notifications\AddTransactionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\MessageBag;
use Symfony\Component\Console\Input\Input;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $transaction = new Transaction($request->all());
            // $transaction->user_id = Crypt::decrypt($request->user_id);
            $transaction->transaction_date = date('Y-m-d', strtotime($request->transaction_date));

            $membership_type_id = MembershipTypes::firstWhere('type',$request->membership_type)->id;
            if($membership_type_id){
                $transaction->membership_type_id = $membership_type_id;
            }


            $client_balance = UserMembershipBalances::where('user_id', $transaction->user_id)
                                    ->where('membership_type_id', $membership_type_id)
                                    ->pluck('balance')->first();
            if(!$client_balance){
                $user_membership_balance = new UserMembershipBalances();
                $user_membership_balance->user_id = $transaction->user_id;
                $user_membership_balance->membership_type_id = $membership_type_id;
                $user_membership_balance->balance = 0; // Save default Balance as 0
                $user_membership_balance->save();
            }
            $client_balance = $client_balance ?? 0;


            if ($request->transaction_type == 'withdraw') {

                if ($request->transaction_amount > $client_balance) {
                    $errors = new MessageBag();

                    $errors->add('transaction_amount', 'You don\'t currently have enough funds');

                    return redirect()->back()->withInput($request->all())->withErrors($errors);
                }

                $new_client_balance = $client_balance - $request->transaction_amount;
            } else {
                $new_client_balance = $client_balance + $request->transaction_amount;
            }

            $transaction->save();

            UserMembershipBalances::where('user_id', $transaction->user_id)
                                    ->where('membership_type_id', $membership_type_id)
                                    ->update(['balance' => $new_client_balance]);
            $client = Client::find($transaction->user_id);

            $transaction_data = [
                'full_name' => $client->first_name . ' ' . $client->last_name,
                'transaction_type' => $transaction->transaction_type,
                'transaction_amount' => $transaction->transaction_amount,
                'currency_symbol'=> $client->currency_symbol,
                'membership_type' => $request->membership_type
            ];

           Notification::send($client, new AddTransactionNotification($transaction_data));
        });
        //setting up success message
        if (DB::transactionLevel() == 0) {
            $notification = array(
                'message' => 'Transaction added successfully!',
                'alert-type' => 'success'
            );
        }
        //setting up error message
        else {
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );
        }

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
