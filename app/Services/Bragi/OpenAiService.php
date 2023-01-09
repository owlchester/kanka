<?php

namespace App\Services\Bragi;

use Orhanerday\OpenAi\OpenAi;

class OpenAiService
{
    /** @var string */
    protected $prompt;

    /** @var string */
    protected $name;

    protected $output;

    /**
     * @param string $prompt
     * @param string $name
     * @return string
     */
    public function input(string $prompt, string $name): self
    {
        $this->prompt = $prompt;
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function generate(): array
    {
        $token = config('openai.secret');
        $open_ai = new OpenAi($token);

        //Creating prompt
        $prompt = $this->preparePrompt();

        //Choosing model
        $engine = config('openai.engine');

        //Defining max tokens
        //1 token is almost 0.75 word
        $maxTokens = config('openai.tokens');

        //Generating NPC
        $complete = $open_ai->completion([
            'model' => $engine,
            'prompt' => $prompt,
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
     * @return string
     */
    protected function preparePrompt(): string
    {
        $prompt = __('openai.intro');

        if (!empty($this->name)) {
            $prompt = __('openai.intro-named', ['name' => $this->name]);
        }

        $prompt .= ' ';
        $option = mt_rand(0, count(config('openai.prompts.first')) - 1);
        $prompt .= __('openai.paragraphs.first', ['option' => config('openai.prompts.first')[$option]]);

        $prompt .= ' ';
        $option = mt_rand(0, count(config('openai.prompts.second')) - 1);
        $prompt .= __('openai.paragraphs.second', ['option' => config('openai.prompts.second')[$option]]);

        $prompt .= ' ';
        $option = mt_rand(0, count(config('openai.prompts.third')) - 1);
        $prompt .= __('openai.paragraphs.third', ['option' => config('openai.prompts.third')[$option]]);

        $prompt .= __('openai.closing', ['prompt' => $this->prompt]);
        return $prompt;
    }

    public function result(): string
    {
        $return = '';
        $texts = explode("\n", $this->output["choices"][0]["text"]);
        foreach ($texts as $text) {
            if (empty(trim($text))) {
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
