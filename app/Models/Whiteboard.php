<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Whiteboard extends Model
{
    use Blameable;
    use HasCampaign;
    use SoftDeletes;

    public $fillable = [
        'name',
        'data'
    ];
}
