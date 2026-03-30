<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Services\Campaign\Import\ImportMentions;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\DB;

abstract class MiscMapper
{
    use BaseEntityMapper;
    use CampaignAware;
    use EntityMapper;
    use ImportMapper;
    use ImportMentions;
    use UserAware;

    protected array $mapping = [];

    protected array $parents = [];

    protected string $className;

    protected string $mappingName;

    public function prepare(): self
    {
        // $this->campaign->{$this->mappingName}()->forceDelete();
        return $this;
    }

    public function third(): self
    {
        $this
            ->loadModel()
            ->entityThird();

        return $this;
    }

    public function tree(): self
    {
        return $this;
    }

    /**
     * Resolve an old child-level status field to a category_statuses.id
     * and inject it into $this->data['entity']['status_id'] for the EntityMapper.
     */
    protected function resolveOldStatusToEntity(string $entityTypeCode, string $statusKey): void
    {
        if (array_key_exists('status_id', $this->data['entity'] ?? [])) {
            return;
        }

        $entityTypeId = config('entities.ids.' . $entityTypeCode);
        $status = DB::table('category_statuses')
            ->where('category_id', $entityTypeId)
            ->where('key', $statusKey)
            ->first();

        if ($status) {
            $this->data['entity']['status_id'] = $status->id;
        }
    }
}
