<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasUser;
use App\Models\Concerns\Sanitizable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Application
 *
 * @property string $text
 */
class Application extends Model
{
    use HasCampaign;
    use HasUser;
    use Sanitizable;

    protected array $sanitizable = [
        'text', 'character_concept', 'additional_notes'
    ];

    protected $fillable = [
        'campaign_id', 'user_id', 'character_concept', 'experience', 
        'availability_days', 'time_start', 'time_end', 'timezone', 
        'pref_rp_combat', 'pref_tone', 'external_link', 'additional_notes'
    ];

    protected $casts = [
        'availability_days' => 'array',
    ];
}
