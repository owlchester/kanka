<?php

namespace App\Services\Bragi;

use App\Traits\UserAware;
use Illuminate\Support\Str;

class BragiService
{
    use UserAware;

    public function prepare(): array
    {
        $data = [
            'header' => __('bragi.intro', [
                'docs' => link_to(
                    '//docs.kanka.io/en/latest/features/bragi.html',
                    __('front.menu.documentation'),
                    ['target' => '_blank']
                )
            ]),
        ];
        if (!$this->user->isElemental() && !$this->user->isWyvern() && !$this->user->isAdmin()) {
            return $this->renderError($data, 'invalid-sub');
        }
        /** elseif ($this->user->bragiTokens() === 0) {
        return $this->renderError($data, 'out-of-tokens');
         * return $this->renderError($data, 'out-of-tokens', ['date' => $this->user->bragiNextTokenDate()]);
        }*/

        $data['texts'] = [
            'placeholder' => __('bragi.placeholders.prompt'),
            'submit' => __('bragi.actions.generate'),
            'insert' => __('bragi.actions.insert'),
            'tokens' => __('bragi.token-limit', ['amount' => '<span class="token-amount font-bold"></span>']),
        ];

        $data['limits'] = [
            'prompt' => 180
        ];
        $data['tokens'] = mt_rand(5, 15);
        return $data;
    }

    public function generate(string $prompt): array
    {
        $data = [];
        $data['tokens'] = mt_rand(5, 15);
        $data['result'] = Str::random(512);

        return $data;
    }

    /**
     * Prepare an error for the plugin
     * @param array $data
     * @param string $error
     * @param array $params
     * @return array
     */
    protected function renderError(array $data, string $error, array $params = []): array
    {
        $data['error'] = $error;
        $data['message'] = __('bragi.errors.' . $error, $params);
        return $data;
    }
}
