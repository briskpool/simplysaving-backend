<?php

namespace App\Http\Controllers;

use App\Models\Admin\Transaction;
use App\Models\UserMembershipBalances;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetClientStatements($user_id, $membership_type_id)
    {
        $data = [];
        $transactions = Transaction::join('users', 'users.id', 'transactions.user_id')
        ->orderBy('transactions.created_at', 'desc')
            ->where('transactions.user_id', $user_id)
            ->where('transactions.membership_type_id', $membership_type_id)
            ->select('transactions.*','users.currency_symbol')
            ->get();

        $total_deposit = $transactions->where('transaction_type', 'deposit')->sum('transaction_amount');
        $total_withdraw = $transactions->where('transaction_type', 'withdraw')->sum('transaction_amount');

        $balance = UserMembershipBalances::where('membership_type_id', $membership_type_id)
            ->where('user_id', $user_id)->pluck('balance')->first();
        if (!$balance) {
            $balance = 0;
        } else {
            // Convert to float/double
            $balance = (float)$balance;
        }
        $total_balance = $balance + $total_withdraw;

        $profit = 0;
        $loss = 0;
        if ($total_balance > $total_deposit) {
            $profit = $total_balance - $total_deposit;
        } else if ($total_balance < $total_deposit) {
            $loss = $total_deposit - $total_balance;
        }
        $profit_percentage = 0;
        if ($total_deposit > 0) {
            $profit_percentage = $profit / $total_deposit * 100;
        }


        $data['total_balance'] = $total_balance;
        $data['total_deposit'] = $total_deposit;
        $data['total_withdraw'] = $total_withdraw;
        $data['profit'] = $profit;
        $data['loss'] = $loss;
        $data['profit_percentage'] = $profit_percentage;
        $data['transactions'] = $transactions;
        return $data;
    }
}
