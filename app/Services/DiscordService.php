<?php


namespace App\Services;


use App\Models\UserApp;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Exception;

/**
 * Class DiscordService
 * @package App\Services
 *
 * To set up your discord bot, access the following:
 * https://discordapp.com/api/oauth2/authorize?client_id=<DISCORD_ID>&scope=bot&permissions=268443657
 */
class DiscordService
{
    /** @var User */
    protected $user;

    /** @var UserApp */
    protected $app;

    /** @var string  */
    protected $url = 'https://discordapp.com/api/v6/';

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
     * Add the user to the server
     * @return $this
     */
    public function addToGuild(): self
    {
        $me = $this->me();
        $headers = [
            'Authorization' => 'Bot ' . config('discord.bot_token'),
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $this->app->access_token,
        ];
        $this->post('guilds/' . config('discord.channel_id') . '/members/' . $me->id, $body, $headers);

        return $this;
    }

    /**
     * @return mixed
     */
    public function me()
    {
        $this->refresh();
        $client = new Client();
        $url = $this->url . 'users/@me';
        $headers = [
            'Authorization' => 'Bearer ' . $this->app->access_token,
        ];

        $response = $client->get($url, ['headers' => $headers]);
        $content = json_decode($response->getBody());

        return $content;
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
     * Add the roles to the discord user
     * @param int $role
     */
    public function addRoles()
    {
        $me = $this->me();

        $headers = [
            'Authorization' => 'Bot ' . config('discord.bot_token'),
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $this->app->access_token,
        ];

        dump($this->user->isElementalPatreon());
        $roles = [
            config('discord.roles.patreon'),
            config('discord.roles.' . ($this->user->isElementalPatreon() ? 'elemental' : 'owlbear')),
        ];

        dd($roles);

       foreach ($roles as $id) {
           $url = 'guilds/' . config('discord.channel_id') . '/members/' . $me->id . '/roles/' . $id;
           $this->call('put', $url, $body, $headers);
       }
    }

    /**
     * Remove all bonus discord roles for the user
     */
    public function removeRoles()
    {
        $me = $this->me();

        // First add them to the patrons role
        $patreonRoleID = 431547159217963020;

        $headers = [
            'Authorization' => 'Bot ' . config('discord.bot_token'),
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $this->app->access_token,
        ];

        foreach (config('discord.roles') as $id) {
            $url = 'guilds/' . config('discord.channel_id') . '/members/' . $me->id . '/roles/' . $id;
            $this->call('delete', $url, $body, $headers);
        }
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
        $response = $client->{$action}($url, ['form_params' => $body, 'headers' => $headers]);

        return json_decode($response->getBody());
    }
}
