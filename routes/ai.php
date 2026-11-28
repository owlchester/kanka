<?php

use App\Http\Middleware\AuthenticateMcp;
use App\Http\Middleware\ClearMcpCampaignContext;
use App\Http\Middleware\EnsureMcpEnabled;
use App\Http\Middleware\RecordMcpToolUsage;
use App\Mcp\Servers\KankaServer;
use Laravel\Mcp\Facades\Mcp;
use Laravel\Passport\Http\Middleware\CheckToken;

Mcp::web('/mcp', KankaServer::class)
    ->middleware([EnsureMcpEnabled::class, ClearMcpCampaignContext::class, AuthenticateMcp::class, CheckToken::using('mcp:use'), RecordMcpToolUsage::class]);

Route::get('/mcp', fn () => response()->view('mcp.help', [
    'title' => 'Kanka MCP',
    'metaDescription' => 'Connect Claude, ChatGPT, or other AI assistants to your Kanka worlds with full-text lore search and safe draft tools.',
]))->name('mcp.help');

Route::middleware(['throttle:20,1', EnsureMcpEnabled::class])->group(function () {
    Mcp::oauthRoutes();
});
