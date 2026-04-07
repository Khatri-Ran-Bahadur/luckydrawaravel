<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Winner extends Model
{
    protected $table = 'winners';

    protected $fillable = [
        'lucky_draw_id',
        'cash_draw_id',
        'product_draw_id',
        'draw_type',
        'user_id',
        'position',
        'prize_amount',
        'status',
        'claim_details',
        'approved_at',
        'reject_comment',
    ];

    protected $casts = [
        'prize_amount' => 'decimal:2',
        'claim_details' => 'array',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cashDraw(): BelongsTo
    {
        return $this->belongsTo(CashDraw::class, 'cash_draw_id');
    }

    public function productDraw(): BelongsTo
    {
        return $this->belongsTo(ProductDraw::class, 'product_draw_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCash(Builder $query): Builder
    {
        return $query->where('draw_type', 'cash');
    }

    public function scopeProduct(Builder $query): Builder
    {
        return $query->where('draw_type', 'product');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopeClaimed(Builder $query): Builder
    {
        return $query->where('status', 'claimed');
    }

    public function scopePendingUserAction(Builder $query): Builder
    {
        return $query->whereIn('status', ['waiting_claim', 'rejected']);
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDrawTitleAttribute(): ?string
    {
        return $this->isCashDraw()
            ? $this->cashDraw?->title
            : $this->productDraw?->title;
    }

    public function getResolvedPrizeAmountAttribute(): float|int|null
    {
        if (!empty($this->prize_amount)) {
            return $this->prize_amount;
        }

        if ($this->isProductDraw()) {
            return $this->productDraw?->product_price;
        }

        return null;
    }

    public function getProductNameAttribute(): ?string
    {
        return $this->isProductDraw()
            ? $this->productDraw?->product_name
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isCashDraw(): bool
    {
        return $this->draw_type === 'cash';
    }

    public function isProductDraw(): bool
    {
        return $this->draw_type === 'product';
    }

    public function approve(): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Query methods
    |--------------------------------------------------------------------------
    */

    public static function getAllWinners(int $limit = 20)
    {
        return static::query()
            ->with([
                'user:id,name,username,profile_image',
                'cashDraw:id,title',
                'productDraw:id,title,product_name,product_price',
            ])
            ->latestFirst()
            ->limit($limit)
            ->get()
            ->map(function ($winner) {
                return [
                    'id' => $winner->id,
                    'lucky_draw_id' => $winner->lucky_draw_id,
                    'cash_draw_id' => $winner->cash_draw_id,
                    'product_draw_id' => $winner->product_draw_id,
                    'draw_type' => $winner->draw_type,
                    'user_id' => $winner->user_id,
                    'position' => $winner->position,
                    'prize_amount' => $winner->prize_amount,
                    'status' => $winner->status,
                    'claim_details' => $winner->claim_details,
                    'approved_at' => $winner->approved_at,
                    'reject_comment' => $winner->reject_comment,
                    'created_at' => $winner->created_at,
                    'updated_at' => $winner->updated_at,
                    'user' => $winner->user,
                    'cash_draw' => $winner->cashDraw,
                    'product_draw' => $winner->productDraw,
                    'draw_title' => $winner->draw_title,
                    'resolved_prize_amount' => $winner->resolved_prize_amount,
                    'product_name' => $winner->product_name,
                ];
            })
            ->toArray();
    }

    public static function getUserWinnings(int $userId)
    {
        return static::query()
            ->with([
                'cashDraw:id,title',
                'productDraw:id,title,product_name,product_price',
            ])
            ->forUser($userId)
            ->latestFirst()
            ->get();
    }

    public static function getUserUnclaimedWinnings(int $userId)
    {
        return static::query()
            ->with([
                'cashDraw:id,title',
                'productDraw:id,title,product_name,product_price',
            ])
            ->forUser($userId)
            ->pendingUserAction()
            ->latestFirst()
            ->get();
    }

    public static function getUserTotalWinnings(int $userId)
    {
        return static::query()
            ->where('user_id', $userId)
            ->sum('prize_amount');
    }
}
