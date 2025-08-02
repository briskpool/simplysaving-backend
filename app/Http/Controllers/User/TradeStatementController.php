<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Membership;
use App\Models\Admin\Client;
use App\Models\Admin\Trade;
use App\Models\Admin\Transaction;
use App\Models\MembershipTypes;
use App\Models\UserMembershipBalances;
use App\Models\UserMemberships;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TradeStatementController extends Controller
{

    public function index()
    {

        $client = Auth::user();
        $client_membership_type_ids = UserMemberships::where('userid', $client->id)->pluck('membership_type_id');

        $client_statement_data = [];
        foreach ($client_membership_type_ids as $membership_type_id) {
            $membership_type = MembershipTypes::where('id', $membership_type_id)->pluck('type')->first();
            // Transactions data
            $client_statement_data[$membership_type] = $this->GetClientStatements($client->id, $membership_type_id);
            $client_statement_data[$membership_type]['balance'] = UserMembershipBalances::where('user_id', $client->id)
                                                                    ->where('membership_type_id',$membership_type_id)->pluck('balance')->first();

            if (request()->has('month_filter')) {

                $trades = Trade::dateRangeFilter()->join('users', 'trades.user_id', 'users.id')
                ->orderBy('trades.created_at', 'desc')
                    ->where('trades.user_id', auth()->user()->id)
                    ->where('trades.membership_type_id', $membership_type_id)
                    ->select('trades.*', 'users.first_name', 'users.last_name')
                    ->get();
            } else {
                $lastEntry = Trade::where('trades.user_id', auth()->user()->id)->latest()->first();
                if ($lastEntry) {
                    // Step 2: Extract the month from the timestamp
                    $lastEntryMonth = $lastEntry->created_at->month;

                    // Step 3: Fetch all records from that month
                    $trades = Trade::dateRangeFilter()->join('users', 'trades.user_id', 'users.id')
                    ->whereMonth('trades.created_at', $lastEntryMonth)
                        ->where('trades.user_id', auth()->user()->id)
                        ->where('trades.membership_type_id', $membership_type_id)
                        ->orderBy('trades.id', 'desc')
                        ->select('trades.*', 'users.first_name', 'users.last_name')
                        ->get();
                } else {
                    $trades = Trade::join('users', 'trades.user_id', 'users.id')
                    ->orderBy('trades.created_at', 'desc')
                        ->where('trades.user_id', auth()->user()->id)
                        ->where('trades.membership_type_id', $membership_type_id)
                        ->select('trades.*', 'users.first_name', 'users.last_name')
                        ->get();
                }
            }

            $client_statement_data[$membership_type]['trades'] = $trades;
        }

        $client_membership_types = json_decode($client->membership_type);
        // Check if $client->membership_type is not JSON encoded
        if ($client_membership_types == null) {
            // Encode it to JSON
            $encoded_membership_type = json_encode([$client->membership_type]);
            // Update the $client object
            $client_membership_types = json_decode($encoded_membership_type);
        }
        
        return view('user.trade_statement', compact('client_statement_data', 'client_membership_types'));
    }
}
