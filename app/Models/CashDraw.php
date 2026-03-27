<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashDraw extends Model
{
    use HasFactory;

    protected $guarded = [];

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
