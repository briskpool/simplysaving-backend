<?php

namespace App\Models\Admin;

use App\Models\MembershipTypes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
class Trade extends Model
{
    use HasFactory;
    protected $fillable = [
        'trade_date',
        'event_id',
        'team_one_id',
        'team_two_id',
        'team_one_score',
        'team_two_score',
        'result',
        'running_total',
        'reward',
        'user_id',
        'notes',
    ];

    public function scopeDateRangeFilter($filter)
    {
        if (request()->has('month_filter')) {
            $year_filter = DateTime::createFromFormat('F Y', trim(request()->month_filter))->format('Y');
            $month_filter = DateTime::createFromFormat('F Y', trim(request()->month_filter))->format('m');
            $filter->whereMonth('trades.created_at', $month_filter);
            $filter->whereYear('trades.created_at', $year_filter);
        }
        // else{
        //     $filter->whereMonth('trades.created_at', Carbon::now()->month);
        //     $filter->whereYear('trades.created_at', Carbon::now()->year);
        // }
    }
    public function membership()
    {
        return $this->belongsTo(MembershipTypes::class, 'membership_type_id');
    }
}
