<?php

namespace App\Services\Bragi;

use App\Exceptions\OpenAiException;
use Illuminate\Support\Arr;
use Orhanerday\OpenAi\OpenAi;

class OpenAiService
{
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
        $engine = config('openai.engine');

        // Defining max tokens
        // 1 token is almost 0.75 word
        $maxTokens = config('openai.tokens');

        $complete = $openAi->chat([
            'model' => $engine,
            'messages' => $prompt,
            'temperature' => 0.9,
            'max_tokens' => $maxTokens,
            'frequency_penalty' => 0,
            'presence_penalty' => 0.6,
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
                'content' => __('openai.intro'),
            ],
        ];

        $roles = [];
        if (! empty($this->name)) {
            $roles[] = __('openai.intro-named', ['name' => $this->name]);
        }

        if (! empty($this->pronouns)) {
            $roles[] = __('openai.intro-gender', ['gender' => $this->gender]);
        }

        if (! empty($this->gender)) {
            $roles[] = __('openai.intro-pronouns', ['pronouns' => $this->pronouns]);
        }

        $option = mt_rand(0, count(config('openai.prompts.first')) - 1);
        $roles[] = __('openai.paragraphs.first', ['option' => config('openai.prompts.first')[$option]]);

        $option = mt_rand(0, count(config('openai.prompts.second')) - 1);
        $roles[] = __('openai.paragraphs.second', ['option' => config('openai.prompts.second')[$option]]);

        $option = mt_rand(0, count(config('openai.prompts.third')) - 1);
        $roles[] = __('openai.paragraphs.third', ['option' => config('openai.prompts.third')[$option]]);

        $roles[] = __('openai.closing', ['prompt' => $this->prompt]);

        foreach ($roles as $role) {
            $prompts[] = ['role' => 'user', 'content' => $role];
        }

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
