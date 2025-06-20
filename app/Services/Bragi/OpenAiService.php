<?php

namespace App\Services\Bragi;

use App\Exceptions\OpenAiException;
use App\Traits\CampaignAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Orhanerday\OpenAi\OpenAi;

class OpenAiService
{
    use CampaignAware;

    protected string $prompt;

    protected ?string $name;

    protected ?string $pronouns = null;

    protected ?string $gender = null;

    protected mixed $output;

    public function input(string $prompt, array $context = []): self
    {
        $this->prompt = $prompt;
        foreach ($context as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    public function generate(): array
    {
        $token = config('openai.secret');
        $openAi = new OpenAi($token);

        $openAi->setCustomURL(config('openai.custom_url'));

        // Creating prompt
        $prompt = $this->preparePrompt();

        // Choosing model
        $engine = config('bragi.backstory.engine');

        // Defining max tokens
        // 1 token is almost 0.75 word
        $maxTokens = config('bragi.backstory.tokens');

        $complete = $openAi->chat([
            'model' => $engine,
            'messages' => $prompt,
            'temperature' => config('bragi.backstory.temperature'),
            'max_tokens' => $maxTokens,
            'frequency_penalty' => config('bragi.backstory.frequency_penalty'),
            'presence_penalty' => config('bragi.backstory.presence_penalty'),
        ]);

        $this->output = json_decode($complete, true);

        return $this->output;
    }

    /**
     * Generate the prompt to send to ChatGTP
     */
    protected function preparePrompt(): array
    {
        $prompts = [
            [
                'role' => 'system',
                'content' => __('bragi/backstory.system'),
            ],
        ];

        $roles = [];
        if (! empty($this->name)) {
            $roles[] = __('bragi/backstory.setup.name', ['name' => $this->name]);
        }

        if (! empty($this->pronouns)) {
            $roles[] = __('bragi/backstory.setup.gender', ['gender' => $this->gender]);
        }

        if (! empty($this->gender)) {
            $roles[] = __('bragi/backstory.setup.pronouns', ['pronouns' => $this->pronouns]);
        }

        if ($this->campaign->systems) {
            $roles[] = __('bragi/backstory.setup.systems', ['systems' => $this->campaign->systems->pluck('name')->implode(', ')]);
        }
        if ($this->campaign->genres) {
            // Comma-separated list of campaign genres
            $list = new Collection;
            foreach ($this->campaign->genres as $genre) {
                $list->push(__('genres.' . $genre->slug));
            }
            $roles[] = __('bragi/backstory.setup.genres', ['genres' => $list->implode(', ')]);
        }

        $roles[] = __('bragi/backstory.setup.prompt', ['prompt' => $this->prompt]);
        $roles[] = __('bragi/backstory.closing');

        foreach ($roles as $role) {

        }
        $prompts[] = [
            'role' => 'user',
            'content' => implode("\n", $roles),
        ];

        return $prompts;
    }

    public function result(): string
    {
        if (! Arr::has($this->output, 'choices')) {
            $excep = new OpenAiException;
            $excep->setContext($this->output);
            throw $excep;
        }
        $return = '';
        $texts = explode("\n", $this->output['choices'][0]['message']['content']);
        foreach ($texts as $text) {
            $striped = mb_trim(htmlentities($text));
            if (empty($striped) || $striped == '.') {
                continue;
            }
            $return .= '<p>' . $text . '</p>';
        }

        // Disciple of Kankappy 0.x%
        if (mt_rand(1, 1000) <= config('bragi.kankappy')) {
            $return .= '<p>' . __('bragi.kankappy') . '</p>';
        }

        return $return;
    }
}
