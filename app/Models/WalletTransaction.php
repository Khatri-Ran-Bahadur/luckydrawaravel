<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'status',
        'description',
        'payment_method',
        'payment_reference',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public static function getUserTransactions(int $userId, int $limit = 20)
    {
        return static::query()
            ->select('wallet_transactions.*')
            ->join('wallets', 'wallets.id', '=', 'wallet_transactions.wallet_id')
            ->where('wallets.user_id', $userId)
            ->orderByDesc('wallet_transactions.created_at')
            ->limit($limit)
            ->get();
    }
}
