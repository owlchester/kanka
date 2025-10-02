<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property array $data
 */
class Whiteboard extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFilters;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    public $fillable = [
        'name',
        'data',
        'is_private',
    ];

    public $casts = [
        'data' => 'array'
    ];

    protected array $sortable = [
        'name',
    ];

    protected array $sanitizable = [
        'name',
    ];

}
