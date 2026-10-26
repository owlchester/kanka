<?php

namespace App\Mcp\Tools\Concerns;

trait RecordsToolUsage
{
    protected function recordUsage(): void
    {
        $request = app('request');
        $tools = $request->attributes->get('mcp_tool_usage', []);
        $tools[] = $this->name();

        $request->attributes->set('mcp_tool_usage', $tools);
    }
}
