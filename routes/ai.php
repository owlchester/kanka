<?php

use App\Http\Middleware\AuthenticateMcp;
use App\Http\Middleware\ClearMcpCampaignContext;
use App\Http\Middleware\EnsureMcpEnabled;
use App\Mcp\Servers\KankaServer;
use Laravel\Mcp\Facades\Mcp;
use Laravel\Passport\Http\Middleware\CheckToken;

Mcp::web('/mcp', KankaServer::class)
    ->middleware([EnsureMcpEnabled::class, ClearMcpCampaignContext::class, AuthenticateMcp::class, CheckToken::using('mcp:use')]);

Route::get('/mcp', fn () => response()->view('mcp.help', [
    'title' => 'Kanka MCP',
    'metaDescription' => 'Connect an AI assistant to your Kanka worlds using read-only MCP tools.',
]))->middleware(EnsureMcpEnabled::class)->name('mcp.help');

Route::middleware(['throttle:20,1', EnsureMcpEnabled::class])->group(function () {
    Mcp::oauthRoutes();
});
