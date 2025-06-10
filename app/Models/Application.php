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

    public $fillable = [
        'text',
    ];

    protected array $sanitizable = [
        'text',
    ];
}
