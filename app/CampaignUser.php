<?php

namespace App;

use App\Scopes\CampaignScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignUser extends Pivot
{
    public $table = 'campaign_user';

    protected $fillable = ['user_id', 'campaign_id'];

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
