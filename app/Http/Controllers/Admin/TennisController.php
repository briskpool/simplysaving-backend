<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Admin\Event;
use App\Models\Admin\Trade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class TennisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tennis_trades = Trade::join('events', 'events.id', 'trades.event_id')
            ->where('trades.event_type', 'tennis')
            ->join('teams as t1', 't1.id', 'trades.team_one_id')
            ->join('teams as t2', 't2.id', 'trades.team_two_id')
            ->orderBy('trades.created_at', 'desc')
            ->select('trades.*', 't1.team_name as player_1_name', 't2.team_name as player_2_name', 't1.team_img as player_1_img', 't2.team_img as player_2_img', 'events.event_name', 'events.event_img')
            ->get();

        return view('admin.trades.tennis.tennis_trade_list', compact('tennis_trades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::latest()->pluck('event_name', 'id');
        $clients = User::where('is_admin', 0)->latest()->select('first_name', 'last_name', 'id')->get();
        return view('admin.trades.tennis.add_tennis_trade', compact('events', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $trade = new Trade($request->all());
        $trade->event_type = 'tennis';
        $balance = Client::where('id', $trade->user_id)->where('is_admin', 0)->latest()->pluck('client_balance')->first();

        if ($balance <= 0) {
            $balanceError = new MessageBag();
            $balanceError->add('balance', 'The client has not enough balance');
            // dd($balance);
            return redirect()->back()->withInput($request->all())->withErrors($balanceError);
        } else {
            $running_total = $trade->reward / 100 * $balance;

            if ($trade->result == 'lose') {
                $new_balance = $balance - $running_total;
            } else {
                $new_balance = $balance + $running_total;
            }

            $trade->trade_date = date('Y-m-d', strtotime($request->trade_date));
            $trade->running_total = $running_total;
            Client::where('id', $trade->user_id)->update(['client_balance' => $new_balance]);


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

            return redirect()->route('tennis-trades.index')->with($notification);
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
