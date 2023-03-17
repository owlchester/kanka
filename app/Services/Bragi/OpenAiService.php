<?php

namespace App\Services\Bragi;

use App\Exceptions\OpenAiException;
use Illuminate\Support\Arr;
use Orhanerday\OpenAi\OpenAi;

class OpenAiService
{
    /** @var string */
    protected $prompt;

    /** @var string */
    protected $name;
    protected $pronouns;
    protected $gender;

    protected $output;

    /**
     * @param string $prompt
     * @param string $name
     * @return string
     */
    public function input(string $prompt, string $name = null, string $pronouns = null, string $gender = null): self
    {
        $this->prompt = $prompt;
        $this->name = $name;
        $this->pronouns = $pronouns;
        $this->gender = $gender;

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
        //A humanoid mutant rat that likes the smell of trash, uses a crossbow as a weapon and dresses like an italian mobster

        $complete = $open_ai->chat([
            'model' => 'gpt-3.5-turbo',
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
     * @return array
     */
    protected function preparePrompt(): array
    {
        $system = __('openai.intro');

        $prompt = '';
        if (!empty($this->name)) {
            $prompt .= __('openai.intro-named', ['name' => $this->name]);
        }

        if (!empty($this->pronouns)) {
            $prompt .= ' ';
            $prompt .= __('openai.intro-gender', ['gender' => $this->gender]);
        }

        if (!empty($this->gender)) {
            $prompt .= ' ';
            $prompt .= __('openai.intro-pronouns', ['pronouns' => $this->pronouns]);
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

        $prompt .= ' ';
        $prompt .= __('openai.closing', ['prompt' => $this->prompt]);

        $prompts = [
            [
                "role" => "system",
                "content" => $system
            ],
            [
                "role" => "user",
            "content" => $prompt
            ]
        ];
        return $prompts;
    }

    public function result(): string
    {
        if (!Arr::has($this->output, 'choices')) {
            $excep = new OpenAiException();
            $excep->setContext($this->output);
            throw $excep;
        }
        $return = '';
        $texts = explode("\n", $this->output["choices"][0]["message"]["content"]);
        foreach ($texts as $text) {
            $striped = trim(htmlentities($text));
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
