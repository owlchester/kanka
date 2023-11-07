<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CampaignImport extends Model
{
    public $fillable = [
        'user_id',
        'campaign_id',
        'status_id'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
