<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashDraw extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function winners(): HasMany
    {
        return $this->hasMany(Winner::class, 'cash_draw_id');
    }



    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class, 'cash_draw_id');
    }


    public function approvedWinners(): HasMany
    {
        return $this->winners()->where('status', 'approved');
    }


    public function claimedWinners(): HasMany
    {
        return $this->winners()->where('status', 'claimed');
    }

    public function clearWinner(): int
    {
        return $this->winners()->delete();
    }


    public function scopeActiveDraws($query): Builder
    {
        return $query
            ->where('status', 'active')
            ->where('draw_date', '>=', Carbon::now())
            ->orderBy('draw_date');
    }

    public function scopeRecentWinners($query, $limit): Builder
    {
        return $query
            ->whereHas('winners')
            ->with(['winners' => function ($query) use ($limit) {
                $query->with('user')->orderBy('created_at', 'desc')->limit($limit);
            }]);
    }


    public function scopeCompletedDraws($query): Builder
    {
        return $query
            ->where('status', 'completed')
            ->with(['winners' => function ($query) {
                $query->with('user');
            }])
            ->latest();
    }

    public function scopeUpcomingDraws($query): Builder
    {
        return $query
            ->where('status', 'upcoming')
            ->orderBy('draw_date');
    }



    public function updateExpiredDraws()
    {
        return static::query()
            ->where('status', 'active')
            ->where('draw_date', '<=', Carbon::now())
            ->update([
                'status' => 'completed',
                'updated_at' => Carbon::now()
            ]);
    }
}
