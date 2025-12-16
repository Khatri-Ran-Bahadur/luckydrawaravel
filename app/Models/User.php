<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'phone',
        'status',
        'login_type',
        'google_id',
        'profile_image',
        'referred_by',
        'wallet_name',
        'wallet_number',
        'wallet_type',
        'is_special_user',
        'wallet_active',
        'wallet_r_code',
        'last_login_at',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = self::generateReferralCode();
            }
            if (empty($user->wallet_id)) {
                $user->wallet_id = self::generateWalletId();
            }
        });
    }

    /**
     * Generate a unique referral code.
     */
    public static function generateReferralCode($length = 8)
    {
        do {
            $code = 'REF-' . Str::upper(Str::random($length));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Generate a unique wallet ID.
     */
    public static function generateWalletId($length = 8)
    {
        do {
            $walletId = 'WLT-' . Str::upper(Str::random($length));
        } while (self::where('wallet_id', $walletId)->exists());

        return $walletId;
    }
}
