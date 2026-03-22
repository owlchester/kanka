<?php

namespace App\Services\Entity\Relations;

use App\Models\MiscModel;

interface RelationsServiceInterface
{
    public function save(MiscModel $model, array $data): void;
}
