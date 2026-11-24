<?php

namespace App\Services\Logs;

use App\Enums\UserAction;
use App\Facades\Identity;
use App\Models\UserLog;
use App\Services\Auth\IpResolver;
use App\Traits\UserAware;

class UserLoggerService
{
    use UserAware;

    public function __construct(
        protected IpResolver $ipResolver,
    ) {}

    public function log(UserAction $action, array $data = []): void
    {
        if (! config('logging.enabled')) {
            return;
        }
        if (! isset($this->user)) {
            return;
        }
        $log = new UserLog(['user_id' => $this->user->id]);
        $log->type_id = $action;
        $log->data = ! empty($data) ? $data : null;
        $this->fillRequestContext($log);
        $log->save();
    }

    public function campaign(int $campaignId, string $module, string $action, array $data = []): void
    {
        if (! config('logging.enabled')) {
            return;
        }
        if (! isset($this->user)) {
            return;
        }
        $log = new UserLog(['user_id' => $this->user->id]);
        $log->type_id = UserAction::campaign;
        $log->campaign_id = $campaignId;
        $log->data = ['module' => $module, 'action' => $action] + $data;
        $log->impersonated_by = Identity::getImpersonatorId();
        $this->fillRequestContext($log);
        $log->save();
    }

    protected function fillRequestContext(UserLog $log): void
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }

        $log->ip = $this->ipResolver->resolve();
        $log->country = mb_substr(request()->server('HTTP_CF_IPCOUNTRY') ?? '', 0, 6) ?: null;
    }
}
