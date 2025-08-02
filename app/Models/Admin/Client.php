<?php

namespace App\Models\Admin;

use App\Models\MembershipTypes;
use App\Models\UserMemberships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use Notifiable;
    use HasFactory;
    protected $table = "users";
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'profile_img',
        'email_verified_at',
        'password',
        'is_admin',
        'is_secure',
        'status',
        'currency_symbol',
        'membership_type'
    ];


    public function trades()
    {
        return $this->hasMany(Trade::class, 'user_id');
    }
    public function memberships()
    {
        return $this->hasMany(UserMemberships::class, 'userid');
    }
}
