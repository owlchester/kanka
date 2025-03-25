<?php

namespace App\Services\Bragi;

use App\Exceptions\OpenAiException;
use App\Http\Requests\BragiRequest;
use App\Models\BragiLog;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\Log;

class BragiService
{
    use CampaignAware;
    use UserAware;

    protected OpenAiService $openAI;

    public function __construct(OpenAiService $service)
    {
        $this->openAI = $service;
    }

    public function prepare(): array
    {
        $data = [
            'header' => __('bragi.intro', [
                'name' => '<strong>Bragi</strong>',
                'here' => '<a href="https://docs.kanka.io/en/latest/features/bragi.html" target="_blank">' . __('bragi.here') . '</a>',
            ]),
        ];
        if (! $this->user->hasTokens()) {
            return $this->renderError($data, 'invalid-sub');
        } elseif ($this->user->availableTokens() <= 0) {
            return $this->renderError($data, 'out-of-tokens', ['date' => $this->user->tokenRenewalDate()]);
        }

        $data['texts'] = [
            'placeholder' => __('bragi.placeholders.prompt'),
            'submit' => __('bragi.actions.generate'),
            'insert' => __('bragi.actions.insert'),
            'tokens' => __('bragi.token-limit', ['amount' => '<span class="token-amount font-bold"></span>']),
            'loading' => __('bragi.loading'),
        ];

        $data['limits'] = [
            'prompt' => config('bragi.limit.prompt'),
        ];
        $data['tokens'] = $this->user->availableTokens();

        return $data;
    }

    /**
     * Call the API and generate a result for the user.
     */
    public function generate(BragiRequest $request): array
    {
        if (! $this->user->hasTokens()) {
            return $this->renderError([], 'invalid-sub');
        } elseif ($this->user->availableTokens() <= 0) {
            return $this->renderError([], 'out-of-tokens', ['date' => $this->user->tokenRenewalDate()]);
        }
        $data = [];
        $prompt = $request->get('prompt');
        $context = [];
        if ($request->filled('name')) {
            $context['name'] = $request->get('name');
        }
        if ($request->filled('gender')) {
            $context['gender'] = $request->get('gender');
        }
        if ($request->filled('pronouns')) {
            $context['pronouns'] = $request->get('pronouns');
        }

        $openAI = $this
            ->openAI
            ->input($prompt, $context)
            ->generate();

        try {
            $data['result'] = $this->openAI->result();

            $logs = [];
            $logs = $openAI['usage'];

            // Log the result into the db for admins
            $this->log($prompt, $data['result'], $logs);
        } catch (OpenAiException $e) {
            $data['result'] = 'API error, please try again';
            Log::warning('OpenAI error', $e->getContext());
        }

        $data['tokens'] = $this->user->availableTokens();
        if ($data['tokens'] <= 0) {
            $data['message'] = __('bragi.errors.out-of-tokens', ['date' => $this->user->tokenRenewalDate()]);
        }

        return $data;
    }

    /**
     * Log what was generated into the db
     *
     * @return void
     */
    protected function log(string $prompt, string $result, array $data = [])
    {
        $log = new BragiLog;
        $log->user_id = $this->user->id;
        $log->campaign_id = $this->campaign->id;
        $log->prompt = $prompt;
        $log->result = $result;
        $log->data = $data;
        $log->save();
    }

    /**
     * Prepare an error for the plugin
     */
    protected function renderError(array $data, string $error, array $params = []): array
    {
        $data['error'] = $error;
        $data['message'] = __('bragi.errors.' . $error, $params);

        return $data;
    }
}
