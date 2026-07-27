<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $fillable = [

        'title',
        'subject',
        'content',
        'status'

    ];

    public function recipients(): HasMany
    {
        return $this->hasMany(CampaignRecipient::class);
    }
}
