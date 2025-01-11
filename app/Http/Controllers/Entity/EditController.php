<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\MultiEditingService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class EditController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authorize('update', $entity->child);

        $editingUsers = null;

        if ($this->campaign->hasEditingWarning()) {
            /** @var MultiEditingService $editingService */
            $editingService = app()->make(MultiEditingService::class);
            $editingUsers = $editingService->model($entity)->user(auth()->user())->users();
            // If no one is editing the entity, we are now editing it
            if (empty($editingUsers)) {
                $editingService->edit();
            }
        }

        $hasTabs = $this->hasTabs($entity->type_id);

        $params = [
            'campaign' => $this->campaign,
            'model' => $entity->child,
            'entity' => $entity,
            'name' => $entity->pluralType(),
            'tabPermissions' => $hasTabs && auth()->user()->can('permission', $entity->child),
            'tabAttributes' => $hasTabs && auth()->user()->can('attributes', $entity) && $this->campaign->enabled('entity_attributes'),
            'tabBoosted' => $hasTabs,
            'tabCopy' => $hasTabs,
            'entityType' => $entity->entityType,
            'editingUsers' => $editingUsers,
            'entityTypeId' => $entity->type_id,
        ];

        return view('cruds.forms.edit', $params);
    }

    protected function hasTabs(int $type): bool
    {
        return !in_array($type, [
            config('entities.ids.bookmark'),
            config('entities.ids.relation')
        ]);
    }
}
