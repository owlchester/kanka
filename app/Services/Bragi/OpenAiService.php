<?php

namespace App\Services\Bragi;

use Orhanerday\OpenAi\OpenAi;

class OpenAiService
{
    /** @var string */
    protected $prompt;

    /** @var string */
    protected $name;

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
        $prompt = config('openai.prompt') . $this->prompt . config('openai.prompt2') . $this->name . "'";

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

        $output = json_decode($complete, true);

        return $output;
    }
}
