<?php

namespace App\Auth;

use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\Token;

/**
 * Workaround for a Passport 13.7 bug where personal access tokens are rejected
 * when the user's ID matches the OAuth client's ID. The upstream check assumes
 * equal IDs means a client credentials token, but this is a false positive.
 *
 * @see https://github.com/laravel/passport/blob/master/src/Guards/TokenGuard.php
 */
class PassportTokenGuard extends TokenGuard
{
    protected function authenticateViaBearerToken(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        if (! $psr = $this->getPsrRequestViaBearerToken()) {
            return null;
        }

        $client = $this->clients->findActive(
            $psr->getAttribute('oauth_client_id')
        );

        if (! $client ||
            ($client->provider &&
             $client->provider !== $this->provider->getProviderName())) {
            return null;
        }

        $this->setClient($client);

        $oauthUserId = $psr->getAttribute('oauth_user_id');

        if (empty($oauthUserId)) {
            return null;
        }

        // Passport 13.7 added a check: if oauth_user_id === oauth_client_id, reject
        // as a client credentials token. However, this is a false positive when the
        // user's primary key happens to equal the client's ID. We verify via the DB.
        if ($oauthUserId === $psr->getAttribute('oauth_client_id')) {
            $tokenId = $psr->getAttribute('oauth_access_token_id');
            $token = Token::find($tokenId);

            if (! $token || $token->user_id === null) {
                return null;
            }
        }

        try {
            $user = $this->provider->retrieveById($oauthUserId);
        } catch (\Exception) {
            return null;
        }

        return $user?->withAccessToken(\Laravel\Passport\AccessToken::fromPsrRequest($psr));
    }
}
