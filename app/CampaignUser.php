<?php

namespace App;

use App\Scopes\CampaignScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignUser extends Pivot
{
    public $table = 'campaign_user';

    protected $fillable = ['user_id', 'campaign_id'];
}
