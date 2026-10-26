<?php

use Illuminate\Support\Facades\Date;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;

it('lists MCP authorizations separately from personal tokens and ordinary OAuth apps', function () {
    $this->asUser();
    $user = auth()->user();
    $clients = app(ClientRepository::class);

    $mcpClient = $clients->createAuthorizationCodeGrantClient(
        'OpenCode',
        ['http://localhost/callback'],
        false,
    );
    $oauthClient = $clients->createAuthorizationCodeGrantClient(
        'Calendar Assistant',
        ['https://example.test/callback'],
        false,
        $user,
    );

    foreach ([[$mcpClient, ['mcp:use']], [$oauthClient, ['read']]] as [$client, $scopes]) {
        Token::query()->create([
            'id' => (string) str()->uuid(),
            'user_id' => $user->id,
            'client_id' => $client->id,
            'name' => $client->name,
            'scopes' => $scopes,
            'revoked' => false,
            'expires_at' => Date::now()->addDay(),
        ]);
    }

    $this->get(route('settings.api'))
        ->assertOk()
        ->assertSee('MCP Connections')
        ->assertSee('OpenCode')
        ->assertSee('MCP · read only')
        ->assertSee('Calendar Assistant')
        ->assertSee('Authorised Applications');
});
