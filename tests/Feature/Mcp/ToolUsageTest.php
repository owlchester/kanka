<?php

use App\Http\Middleware\RecordMcpToolUsage;
use App\Models\McpToolDailyUsage;
use App\Services\Mcp\ToolUsageLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

uses(RefreshDatabase::class);

it('aggregates tool calls by day and tool without recording request details', function () {
    $logger = app(ToolUsageLogger::class);

    $logger->record('search-entities');
    $logger->record('search-entities');
    $logger->record('list-campaigns');

    expect(McpToolDailyUsage::query()->count())->toBe(2)
        ->and(McpToolDailyUsage::query()->where('tool', 'search-entities')->value('calls'))->toBe(2)
        ->and(McpToolDailyUsage::query()->where('tool', 'list-campaigns')->value('calls'))->toBe(1)
        ->and((new McpToolDailyUsage)->getFillable())->toBe(['usage_date', 'tool', 'calls']);
});

it('records tool names from terminable MCP middleware', function () {
    $request = Request::create('/mcp', 'POST');
    $request->attributes->set('mcp_tool_usage', ['list-campaigns', 'list-campaigns']);

    app(RecordMcpToolUsage::class)->terminate($request, new Response);

    expect(McpToolDailyUsage::query()->where('tool', 'list-campaigns')->value('calls'))->toBe(2);
});
