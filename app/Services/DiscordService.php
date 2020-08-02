<?php


namespace App\Services;


use App\Models\UserApp;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class DiscordService
 * @package App\Services
 *
 * To set up your discord bot, access the following:
 * https://discord.com/api/oauth2/authorize?client_id=<DISCORD_ID>&scope=bot&permissions=268443657
 */
class DiscordService
{
    /** @var User */
    protected $user;

    /** @var UserApp */
    protected $app;

    /** @var string  */
    protected $url = 'https://discord.com/api/v6/';

    /** @var mixed */
    protected $me = false;

    /**
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
        $this->app = $user->apps()->app('discord')->first();
        return $this;
    }

    /**
     * @param string $code
     */
    public function validate(string $code): self
    {
        $body = [
            'client_id' => config('discord.client_id'),
            'client_secret' => config('discord.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => url('/settings/discord-callback'),
            'scope' => 'identify guilds guilds.join'
        ];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $content = $this->post('oauth2/token', $body, $headers);
        $this->saveUserApp($content);

        return $this;
    }

    /**
     * Add the user to the server.
     * We don't need to worry about re-adding a user twice, Discord's api will provide
     * a success message back with the info.
     * @return $this
     */
    public function addServer(): self
    {
        $me = $this->me();

        $headers = [
            'Authorization' => 'Bot ' . config('discord.bot_token'),
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $this->app->access_token,
        ];
        $this->call('put', 'guilds/' . config('discord.channel_id') . '/members/' . $me->id, $body, $headers);

        return $this;
    }

    /**
     * @return mixed
     */
    public function me()
    {
        // Cache the response during a single process
        if ($this->me !== false) {
            return $this->me;
        }

        $this->refresh();
        $client = new Client();
        $url = $this->url . 'users/@me';
        $headers = [
            'Authorization' => 'Bearer ' . $this->app->access_token,
        ];

        $response = $client->get($url, ['headers' => $headers]);
        $this->me = json_decode($response->getBody());

        return $this->me;
    }

    /**
     * Save the user app
     * @param $data
     */
    protected function saveUserApp($data): self
    {
        if (!$this->app) {
            $this->app = new UserApp([
                'user_id' => $this->user->id,
                'app' => 'discord',
            ]);
        }

        $this->app->access_token = $data->access_token;
        $this->app->refresh_token = $data->refresh_token;
        $this->app->expires_at = Carbon::now()->addSeconds($data->expires_in);
        $this->app->save();

        // Get me for data
        $me = $this->me();
        $this->app->settings = ['username' => $me->username, 'discriminator' => $me->discriminator];
        $this->app->save();

        return $this;
    }

    /**
     * Refresh the user's access token
     * @return $this
     */
    public function refresh()
    {
        // Don't refresh a valid token
        if (!$this->app->expires_at->isPast()) {
            return $this;
        }

        $body = [
            'client_id' => config('discord.client_id'),
            'client_secret' => config('discord.client_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->app->refresh_token,
            'redirect_uri' => url('/settings/discord-callback'),
            'scope' => 'identify guilds guilds.join'
        ];
        $content = $this->post('oauth2/token', $body);
        $this->saveUserApp($content);

        return $this;
    }

    /**
     * Add the user to the discord roles
     * @return $this
     */
    public function addRoles(): self
    {
        // Don't add roles if the user isn't connected
        if (empty($this->app)) {
            return $this;
        }

        // Only add roles if the user is a subscriber
        if (!$this->user->subscribed('kanka')) {
            return $this;
        }

        $me = $this->me();

        $headers = [
            'Authorization' => 'Bot ' . config('discord.bot_token'),
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $this->app->access_token,
        ];

        $roles = [
            config('discord.roles.' . ($this->user->isElementalPatreon() ? 'elemental' : 'owlbear')),
        ];

       foreach ($roles as $id) {
           $url = 'guilds/' . config('discord.channel_id') . '/members/' . $me->id . '/roles/' . $id;
           $this->call('put', $url, $body, $headers);
       }

        return $this;
    }

    /**
     * Remove all bonus discord roles for the user
     */
    public function removeRoles(): self
    {
        // Don't remove if the user is already disconnected
        if (empty($this->app)) {
            return $this;
        }

        $me = $this->me();


        $headers = [
            'Authorization' => 'Bot ' . config('discord.bot_token'),
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $this->app->access_token,
        ];

        try {
            foreach (config('discord.roles') as $id) {
                $url = 'guilds/' . config('discord.channel_id') . '/members/' . $me->id . '/roles/' . $id;
                $this->call('delete', $url, $body, $headers);
            }
        } catch (\Exception $e) {
            Log::warning('Couldn\'t delete role for user');
        }

        return $this;
    }

    /**
     * Remove a user's discord integration
     * @throws Exception
     */
    public function remove(): self
    {
        // Don't remove if the user is already disconnected
        if (empty($this->app)) {
            return $this;
        }

        // Remove any roles the user might have had
        $this->removeRoles();

        // Delete the discord app
        $this->app->delete();

        return $this;
    }

    /**
     * Make a post request on the discord api
     * @param string $api
     * @param array $body
     * @param array|null $headers
     * @return mixed
     */
    protected function post(string $api, array $body = [], array $headers = null)
    {
        $client = new Client();
        if ($headers === null) {
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];
        }

        $url = $this->url . ltrim($api, '/');
        $response = $client->post($url, ['form_params' => $body, 'headers' => $headers]);

        return json_decode($response->getBody());
    }

    /**
     * @param string $action post, get, put, delete
     * @param string $api
     * @param array $body
     * @param array|null $headers
     * @return mixed
     */
    protected function call(string $action, string $api, array $body = [], array $headers = null)
    {
        $client = new Client();
        if ($headers === null) {
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];
        }

        $url = $this->url . ltrim($api, '/');

        if ($action === 'put') {
            $response = $client->{$action}($url, ['json' => $body, 'headers' => $headers]);
        } else {
            $response = $client->{$action}($url, ['form_params' => $body, 'headers' => $headers]);
        }

        return json_decode($response->getBody());
    }
}
