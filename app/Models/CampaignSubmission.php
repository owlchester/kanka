<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasUser;
use App\Models\Concerns\Sanitizable;
use App\Observers\CampaignSubmissionObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CampaignSubmission
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

    protected static function booted()
    {
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }
        static::observe(CampaignSubmissionObserver::class);
    }
}
