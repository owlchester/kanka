<?php

namespace App\Services\Bragi;

use App\Http\Requests\BragiRequest;
use App\Models\BragiLog;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class BragiService
{
    use UserAware;
    use CampaignAware;

    protected $openAI;

    /*public function __construct(OpenAIService $service)
    {
        $this->openAI = $service;
    }*/

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
        if (!$this->user->hasTokens()) {
            return $this->renderError($data, 'invalid-sub');
        } elseif ($this->user->availableTokens() === 0) {
            return $this->renderError($data, 'out-of-tokens', ['date' => $this->user->tokenRenewalDate()]);
        }

        $data['texts'] = [
            'placeholder' => __('bragi.placeholders.prompt'),
            'submit' => __('bragi.actions.generate'),
            'insert' => __('bragi.actions.insert'),
            'tokens' => __('bragi.token-limit', ['amount' => '<span class="token-amount font-bold"></span>']),
        ];

        $data['limits'] = [
            'prompt' => 180
        ];
        $data['tokens'] = $this->user->availableTokens();
        return $data;
    }

    /**
     * Call the API and generate a result for the user.
     * @param BragiRequest $request
     * @return array
     */
    public function generate(BragiRequest $request): array
    {
        if (!$this->user->hasTokens()) {
            return $this->renderError([], 'invalid-sub');
        }
        $data = [];
        $promt = $request->get('prompt');
        $name = $request->get('name');

        // Call the service
        //$openAI = $this->openAI->input($prompt, $name)->generate();
        // $data['result'] = Arr::get($openAI, 'result');
        $logs = [];
        // $logs = Arr::get($openAI, 'logs');

        $data['tokens'] = $this->user->availableTokens();
        $data['result'] = Str::random(512);

        // Log the result into the db for admins
        $this->log($promt, $data['result'], $logs);

        return $data;
    }

    /**
     * Log what was generated into the db
     * @param string $prompt
     * @param string $result
     * @return void
     */
    protected function log(string $prompt, string $result, array $data = [])
    {
        $log = new BragiLog();
        $log->user_id = $this->user->id;
        $log->campaign_id = $this->campaign->id;
        $log->prompt = $prompt;
        $log->result = $result;
        $log->data = $data;
        $log->save();
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
