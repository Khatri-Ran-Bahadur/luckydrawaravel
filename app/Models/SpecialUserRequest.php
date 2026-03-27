<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialUserRequest extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo('user');
    }
}
