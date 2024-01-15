<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Acl;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use App\Models\CampaignSystem;

class GameSystem extends Model
{
    use Acl;
    use ExportableTrait;
    use SortableTrait;
    
    public $fillable = [
        'name',
    ];

    public function campaignSystem()
    {
        return $this->hasMany(CampaignSystem::class, 'system_id', 'id');
    }
}
