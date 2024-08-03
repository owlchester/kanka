<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasUser;
use App\Models\Concerns\Sanitizable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CampaignSubmission
 * @package App\Models
 *
 * @property string $text
 */
class CampaignSubmission extends Model
{
    use HasCampaign;
    use HasUser;
    use Sanitizable;

    public $fillable = [
        'text',
    ];

    protected array $sanitizable = [
        'text',
    ];
}
