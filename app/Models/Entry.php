<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $guarded = [];

    public function checkUserProductDrawEntry(int $userId, int $drawId)
    {
        return static::where('user_id', $userId)
            ->where('product_draw_id', $drawId)
            ->where('draw_type', 'product')
            ->exists();
    }

    public function checkUserCashDrawEntry(int $userId, int $drawId)
    {
        return static::where('user_id', $userId)
            ->where('cash_draw_id', $drawId)
            ->where('draw_type', 'cash')
            ->exists();
    }
}
