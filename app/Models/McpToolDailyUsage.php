<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class McpToolDailyUsage extends Model
{
    use Prunable;

    protected $table = 'mcp_tool_daily_usage';

    protected $fillable = ['usage_date', 'tool', 'calls'];

    protected function casts(): array
    {
        return ['usage_date' => 'date', 'calls' => 'integer'];
    }

    public function prunable(): Builder
    {
        return static::query()->where('usage_date', '<', today()->subDays(30));
    }
}
