<?php

namespace App\Console\Commands\Report;

use App\Models\McpToolDailyUsage as Usage;
use Illuminate\Console\Command;

class McpToolUsage extends Command
{
    protected $signature = 'mcp:usage {--days=30 : Number of days to include}';

    protected $description = 'Show daily MCP tool usage for the last 30 days';

    public function handle(): int
    {
        $days = max(1, (int) $this->option('days'));
        $rows = Usage::query()
            ->where('usage_date', '>=', today()->subDays($days - 1))
            ->orderBy('usage_date')
            ->orderBy('tool')
            ->get(['usage_date', 'tool', 'calls']);

        if ($rows->isEmpty()) {
            $this->info('No MCP tool calls recorded.');

            return self::SUCCESS;
        }

        $this->table(['Date', 'Tool', 'Calls'], $rows->map(fn (Usage $row): array => [
            $row->usage_date->toDateString(),
            $row->tool,
            $row->calls,
        ]));

        return self::SUCCESS;
    }
}
