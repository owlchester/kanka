<?php

namespace App\Services\Discord;

use App\Traits\UserAware;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    use UserAware;

    protected ?string $webhook;
    protected string $title;
    protected string $content;
    protected string $description;
    protected string $url;
    protected array $json;

    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function content(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function description(string $description): self
    {
        $this->description = strip_tags($description);
        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function webhook(string $webhook): self
    {
        $this->webhook = $webhook;
        return $this;
    }

    public function json(): ?array
    {
        return $this->json;
    }

    public function send(): self
    {
        $embeds = $this->embeds();

        $response = Http::post($this->webhook . '?wait=true', [
            'content' => $this->content,
            'embeds' => [
                $embeds
            ],
            'wait' => true,
        ]);

        $this->json = $response->json();

        return $this;
    }

    protected function embeds(): array
    {
        $embeds = [
            'title' => $this->title,
            'color' => config('discord.color'),
        ];

        if (isset($this->url)) {
            $embeds['url'] = $this->url;
        }
        if (isset($this->description)) {
            $embeds['description'] = $this->description;
        }

        if (isset($this->user)) {
            $embeds['author'] = [
                'name' => $this->user->name,
                'url' => route('users.profile', $this->user->id),
                'icon_url' => $this->user->hasAvatar() ? $this->user->getAvatarUrl() : null,
            ];
        }

        return $embeds;
    }
}
