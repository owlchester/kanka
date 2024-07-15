<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Facades\Permissions;
use App\Facades\Images;
use App\Jobs\EntityUpdatedJob;
use App\Jobs\EntityWebhookJob;
use App\Enums\WebhookAction;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Services\Entity\TagService;
use App\Services\PermissionService;
use App\Facades\Domain;

class EntityObserver
{
    use PurifiableTrait;

    protected PermissionService $permissionService;

    protected TagService $tagService;

    /**
     * PermissionController constructor.
     */
    public function __construct(
        PermissionService $permissionService,
        TagService $tagService
    ) {
        $this->permissionService = $permissionService;
        $this->tagService = $tagService;
    }

    /**
     * An entity has been saved from the crud
     */
    public function crudSaved(Entity $entity)
    {
        Images::entity($entity, 'w/' . $entity->campaign_id, 'image');
        Images::entity($entity, 'w/' . $entity->campaign_id);
        $this->saveTags($entity);
        $this->savePermissions($entity);
        $this->savePremium($entity);

        if ($entity->isDirty()) {
            // The entity was created, but now we're potentially updating it in the same request, so we need
            // to check if it's really a new entity or not
            if (EntityLogger::entity($entity)->created()) {
                $entity->saveQuietly();
            } else {
                $entity->save();
            }
        } elseif ($this->tagService->isDirty()) {
            // Same thing here, if adding tags to a newly created entity, don't make it complicated
            if (EntityLogger::entity($entity)->created()) {
                // It was just created, why to we need to touch it quietly?
                $entity->touchQuietly();
            } else {
                $entity->touch();
            }
        }
    }

    /**
     * Save the sections/categories
     */
    protected function saveTags(Entity $entity)
    {
        // HTML forms will have 'save-tags', while the api will have a tag array if they want to make changes.
        if (!request()->has('tags') && !request()->has('save-tags')) {
            return;
        }
        $ids = request()->post('tags', []);
        if (!is_array($ids)) { // People sent weird stuff through the API
            $ids = [];
        }
        $this->tagService
            ->user(auth()->user())
            ->entity($entity)
            ->withNew()
            ->sync($ids)
        ;
    }

    /**
     * Save permissions sent to the controller
     */
    public function savePermissions(Entity $entity)
    {
        if (!auth()->user()->can('permission', $entity->child)) {
            return;
        } elseif (request()->has('copy_source_permissions') && request()->filled('copy_source_permissions')) {
            return;
        } elseif (request()->get('quick-creator') === '1') {
            // If we're creating an entity from the quick creator, there is no form for permissions.
            return;
        }
        $data = request()->only('role', 'user', 'is_attributes_private', 'permissions_too_many');

        // If the user granted/assigned themselves read/write permissions on the entity, we need to make sure they
        // still have them even if not checked in the UI.
        if (Permissions::granted() && !empty($data['user'])) {
            $user = auth()->user()->id;
            if (!in_array(CampaignPermission::ACTION_EDIT, $data['user'][$user])) {
                $data['user'][$user][CampaignPermission::ACTION_EDIT] = 'allow';
            }
            if (!in_array(CampaignPermission::ACTION_READ, $data['user'][$user])) {
                $data['user'][$user][CampaignPermission::ACTION_READ] = 'allow';
            }
        }

        $this->permissionService->saveEntity($data, $entity);
    }

    /**
     */
    public function created(Entity $entity)
    {
        // If the user has created a new entity but doesn't have the permission to read or edit it,
        // automatically creates said permission.
        if (!auth()->user()->can('view', $entity->child)) {
            $permission = new CampaignPermission();
            $permission->entity_id = $entity->id;
            $permission->misc_id = $entity->entity_id;
            $permission->entity_type_id = $entity->type_id;
            $permission->campaign_id = $entity->campaign_id;
            $permission->user_id = auth()->user()->id;
            $permission->action = CampaignPermission::ACTION_READ;
            $permission->access = true;
            $permission->save();
            Permissions::grant($entity);
        }
        if (!auth()->user()->can('update', $entity->child)) {
            $permission = new CampaignPermission();
            $permission->entity_id = $entity->id;
            $permission->misc_id = $entity->entity_id;
            $permission->entity_type_id = $entity->type_id;
            $permission->campaign_id = $entity->campaign_id;
            $permission->user_id = auth()->user()->id;
            $permission->action = CampaignPermission::ACTION_EDIT;
            $permission->access = true;
            $permission->save();
            Permissions::grant($entity);
        }

        // Refresh the model because adding permissions to the child means we have a new relation
        if (Permissions::granted()) {
            $entity->unsetRelation('child');
            $entity->reloadChild();
        }

        EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::CREATED->value);
    }

    /**
     * Queue a few jobs whenever an entity gets updated
     */
    public function updated(Entity $entity)
    {
        EntityUpdatedJob::dispatch($entity);
        EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::EDITED->value);

        // Sometimes we just touch the entity, which should also touch the child
        if ($entity->child && $entity->updated_at->greaterThan($entity->child->updated_at)) {
            $entity->child->touchSilently();
        }
    }

    /**
     */
    public function savePremium(Entity $entity): void
    {
        // Gallery is now available to all
        if (request()->has('entity_image_uuid')) {
            $entity->image_uuid = request()->get('entity_image_uuid');
        } elseif (Domain::isApp()) {
            $entity->image_uuid = null;
        }
        // No changed for non-boosted campaigns
        if (!$entity->campaign->boosted()) {
            return;
        }

        if (request()->has('entity_tooltip')) {
            $entity->tooltip = $this->purify(request()->get('entity_tooltip'));
        }

        // Superboosted image gallery selection
        if ($entity->campaign->superboosted()) {
            if (request()->has('entity_header_uuid')) {
                $entity->header_uuid = request()->get('entity_header_uuid');
            } elseif (Domain::isApp()) {
                $entity->header_uuid = null;
            }
        }
    }

    public function deleted(Entity $entity)
    {
        // When an entity is soft-deleted, we just want some webhooks to trigger,
        // not actually delete the entity and its image.
        if ($entity->trashed()) {
            EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::DELETED->value);
            return;
        }

        $entity->permissions()->delete();
        $entity->widgets()->delete();
    }
}
