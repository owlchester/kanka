<?php

namespace App\Services\Logs;

use App\Models\ApiLog;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Http\JsonResponse;
use Throwable;

class ApiLogService
{
    use CampaignAware;
    use RequestAware;
    use UserAware;

    protected $duration;

    protected JsonResponse $response;

    protected Throwable $exception;

    public function duration($duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function response(JsonResponse $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function exception(Throwable $exception): self
    {
        $this->exception = $exception;

        return $this;
    }

    public function reset(): void
    {
        unset($this->campaign, $this->response, $this->exception);
        $this->user = null;
        $this->request = null;
        $this->duration = null;
    }

    public function log(): void
    {
        try {
            if (! config('logging.enabled') || ! isset($this->user, $this->request)) {
                return;
            }

            if (isset($this->exception)) {
                $code = 500;
            } else {
                $code = isset($this->response) ? $this->response->getStatusCode() : 200;
            }

            ApiLog::create([
                'campaign_id' => isset($this->campaign) ? $this->campaign->id : null,
                'user_id' => $this->user->id,
                'uri' => $this->request->path(),
                'params' => $this->request->except(['password', 'password_confirmation', 'current_password']),
                'duration' => $this->duration,
                'response' => (string) $code,
            ]);
        } finally {
            $this->reset();
        }
    }
}
