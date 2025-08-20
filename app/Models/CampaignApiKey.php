<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasUser;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CampaignApiKey
 *
 * @property int $campaign_id
 * @property string $api_key
 * @property string $provider
 * @property string $model
 * @property bool|int $is_enabled
 * @property Campaign $campaign
 */
class CampaignApiKey extends Model
{
    use HasCampaign;
    use HasUser;
    use Paginatable;
    use SortableTrait;
    use Blameable;

    protected $fillable = [
        'campaign_id',
        'provider',
        'api_key',
        'model',
        'is_enabled',
        'created_by',
        'updated_by',
    ];

    protected array $sortable = [
        'model',
        'provider',
        'is_enabled',
    ];

    protected string $userField = 'created_by';

    public function url(string $sub): string
    {
        return 'api-keys.' . $sub;
    }

    /**
     * Determine if the model is extinct.
     */
    public function isEnabled(): bool
    {
        return (bool) $this->is_enabled;
    }
}
