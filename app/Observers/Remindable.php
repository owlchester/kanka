<?php

namespace App\Observers;

use App\Services\Entity\RemindableService;
use Illuminate\Database\Eloquent\Model;

class Remindable
{
    protected RemindableService $service;

    public function __construct(RemindableService $service)
    {
        $this->service = $service;
    }

    public function saved(Model $model)
    {
        // @phpstan-ignore-next-line
        $this->service->request(request())->save($model);
    }
}
