<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refferal extends Model
{
    protected $fillable = [
        'referrer_id',
        'referred_id',
        'referral_code',
        'bonus_amount',
        'bonus_paid',
        'status',
    ];


    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }
    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    public function createReferral($referrer_id, $referred_id, $referral_code, $bonus_amount)
    {
        return self::create([
            'referrer_id' => $referrer_id,
            'referred_id' => $referred_id,
            'referral_code' => $referral_code,
            'bonus_amount' => $bonus_amount,
            'status' => 'pending',
        ]);
    }
}
