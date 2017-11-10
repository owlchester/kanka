<?php

namespace App;

use App\Scopes\CampaignScope;
use Illuminate\Database\Eloquent\Model;

class CampaignUser extends Model
{
    public $table = 'campaign_user';

    protected $fillable = ['user_id', 'campaign_id', 'role'];

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
