<?php

namespace App\Services\Mcp;

use Illuminate\Support\Facades\DB;

class ToolUsageLogger
{
    public function record(string $tool): void
    {
        try {
            $date = today()->toDateString();

            DB::table('mcp_tool_daily_usage')->upsert(
                [[
                    'usage_date' => $date,
                    'tool' => $tool,
                    'calls' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]],
                ['usage_date', 'tool'],
                ['updated_at'],
            );

            DB::table('mcp_tool_daily_usage')
                ->where('usage_date', $date)
                ->where('tool', $tool)
                ->increment('calls');
        } catch (\Throwable) {
            // Usage tracking must not affect MCP requests.
        }
    }
}
