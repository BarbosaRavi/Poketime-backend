<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pokemon extends Model
{
    protected $fillable = ['api_id', 'name', 'image_url', 'type', 'team_id'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Time::class);
    }
}

