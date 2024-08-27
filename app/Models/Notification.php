<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;

class Notification extends Model
{
    use MassPrunable;

    protected $fillable = [
        'notifiable_type',
    ];

    /**
     * Automatically prune read notifications older than a year
     */
    public function prunable(): Builder
    {
        return static::whereNotNull('read_at')
            ->where('read_at', '<=', now()->subYear());
    }
}
