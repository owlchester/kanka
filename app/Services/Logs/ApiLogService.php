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

    public function log()
    {
        if (! config('logging.enabled')) {
            return;
        }

        // Front-facing APIs? Don't log
        if (! isset($this->user)) {
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
            'params' => $this->request->all(),
            'duration' => $this->duration,
            'response' => $code,
        ]);
    }
}
