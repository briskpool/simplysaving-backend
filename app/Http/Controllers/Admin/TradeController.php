<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MotoTradeRequest;
use App\Http\Requests\TradeRequest;
use App\Models\Admin\Client;
use App\Models\Admin\Event;
use App\Models\Admin\Trade;
use App\Models\MembershipTypes;
use App\Models\User;
use App\Models\UserMembershipBalances;
use Illuminate\Support\MessageBag;


class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('month_filter')){
            $trades = Trade::dateRangeFilter()->join('users', 'trades.user_id', 'users.id')->orderBy('trades.created_at', 'desc')
                ->select('trades.*', 'users.first_name', 'users.last_name')
                ->with('membership')
                ->get();
        }else{
            $lastEntry = Trade::latest()->first();
            if ($lastEntry) {
                // Step 2: Extract the month from the timestamp
                $lastEntryMonth = $lastEntry->created_at->month;

                // Step 3: Fetch all records from that month
                $trades = Trade::dateRangeFilter()->join('users', 'trades.user_id', 'users.id')
                    ->whereMonth('trades.created_at', $lastEntryMonth)
                    ->orderBy('trades.created_at', 'desc')
                    ->select('trades.*', 'users.first_name', 'users.last_name')
                    ->with('membership')
                    ->get();

            } else {
                $trades = Trade::join('users', 'trades.user_id', 'users.id')
                    ->orderBy('trades.created_at', 'desc')
                    ->select('trades.*', 'users.first_name', 'users.last_name')
                    ->with('membership')
                    ->get();
            }
        }
        // dd($trades);
        return view('admin.trades.trade_list', compact('trades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::latest()->pluck('event_name', 'id');
        $clients = User::where('is_admin', 0)->latest()->select('first_name', 'last_name', 'id', 'membership_type')->get();

        // Create an empty array to store client id and membership type key-value pairs
        $clientMembershipTypes = [];

        foreach ($clients as $client) {
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

            if (is_array($client->membership_type)) {
                // Append each membership type to the array
                foreach ($client->membership_type as $type) {
                    $clientMembershipTypes[$client->id][] = $type;
                }
            }
        }
        
        return view('admin.trades.add_trade', compact('events', 'clients','clientMembershipTypes'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TradeRequest $request)
    {
        $trade = new Trade($request->all());
        $trade->event_type = 'interest';

        $membership_type_id = MembershipTypes::firstWhere('type',$request->membership_type)->id;
        if($membership_type_id){
            $trade->membership_type_id = $membership_type_id;
        }

        $balance = UserMembershipBalances::where('user_id', $trade->user_id)
                    ->where('membership_type_id', $membership_type_id)->latest()->pluck('balance')->first();

        if ($balance <= 0) {
            $balanceError = new MessageBag();
            $balanceError->add('balance', 'The client has not enough balance');
            return redirect()->back()->withInput($request->all())->withErrors($balanceError);
        } else {
            $running_total = $trade->reward / 100 * $balance;

            $new_balance = $balance + $running_total;

            $trade->trade_date = date('Y-m-d', strtotime($request->trade_date));
            $trade->running_total = $running_total;
            UserMembershipBalances::where('user_id', $trade->user_id)
                    ->where('membership_type_id', $membership_type_id)
                    ->update(['balance' => $new_balance]);


            // dd($trade);
            //setting up success message
            if ($trade->save()) {
                $notification = array(
                    'message' => 'Trade added successfully!',
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

            return redirect()->route('interests.index')->with($notification);
        }
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TradeRequest $request, $id)
    {
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
