<?php

namespace App\Observers;

use App\Enums\Permission;
use App\Enums\WebhookAction;
use App\Facades\Domain;
use App\Facades\EntityLogger;
use App\Facades\Images;
use App\Facades\Permissions;
use App\Jobs\EntityUpdatedJob;
use App\Jobs\EntityWebhookJob;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Services\Entity\TagService;
use App\Services\PermissionService;

class EntityObserver
{
    use PurifiableTrait;

    /**
     * PermissionController constructor.
     */
    public function __construct(
        protected PermissionService $permissionService,
        protected TagService $tagService
    ) {}

    /**
     * An entity has been saved from the crud
     */
    public function crudSaved(Entity $entity)
    {
        if (request()->has('type')) {
            $entity->type = request()->get('type');
        }
        if (request()->has('entry')) {
            $entity->entry = request()->get('entry');
            // Dirty, force the entry to be saved to trigger the HasEntry observer
            $entity->save();
        }

        if (request()->post('remove-image') == '1') {
            Images::cleanup($entity, 'image');
        }
        if (request()->post('remove-header_image') == '1') {
            Images::cleanup($entity, 'header_image');
        }
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
        if (! request()->has('tags') && ! request()->has('save-tags')) {
            return;
        }
        $ids = request()->post('tags', []);
        if (! is_array($ids)) { // People sent weird stuff through the API
            $ids = [];
        }
        $this->tagService
            ->user(auth()->user())
            ->entity($entity)
            ->withNew()
            ->sync($ids);
    }

    /**
     * Save permissions sent to the controller
     */
    public function savePermissions(Entity $entity)
    {
        if (! auth()->user()->can('permissions', $entity)) {
            return;
        } elseif (request()->has('copy_permissions') && request()->filled('copy_permissions')) {
            return;
        } elseif (request()->get('quick-creator') === '1') {
            // If we're creating an entity from the quick creator, there is no form for permissions.
            return;
        }
        $data = request()->only('role', 'user', 'is_attributes_private', 'permissions_too_many');

        // If the user granted/assigned themselves read/write permissions on the entity, we need to make sure they
        // still have them even if not checked in the UI.
        if (Permissions::granted() && ! empty($data['user'])) {
            $user = auth()->user()->id;
            if (! in_array(Permission::Update->value, $data['user'][$user])) {
                $data['user'][$user][Permission::Update->value] = 'allow';
            }
            if (! in_array(Permission::View->value, $data['user'][$user])) {
                $data['user'][$user][Permission::View->value] = 'allow';
            }
        }

        $this->permissionService->saveEntity($data, $entity);
    }

    public function created(Entity $entity)
    {
        // If the user has created a new entity but doesn't have the permission to read or edit it,
        // automatically create said permission.
        if (! auth()->user()->can('view', $entity)) {
            $this->grant($entity, Permission::View->value);
        }
        if (! auth()->user()->can('update', $entity)) {
            $this->grant($entity, Permission::Update->value);
        }
        // Refresh the model because adding permissions to the child means we have a new relation
        if (Permissions::granted() && $entity->hasChild()) {
            $entity->unsetRelation('child');
            $entity->reloadChild();
        }

        EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::CREATED->value);
    }

    protected function grant(Entity $entity, int $action): CampaignPermission
    {
        $permission = new CampaignPermission;
        $permission->entity_id = $entity->id;
        if (! $entity->entityType->isSpecial()) {
            $permission->misc_id = $entity->entity_id;
        }
        $permission->entity_type_id = $entity->type_id;
        $permission->campaign_id = $entity->campaign_id;
        $permission->user_id = auth()->user()->id;
        $permission->action = $action;
        $permission->access = true;
        $permission->save();
        Permissions::grant($entity);

        return $permission;
    }

    /**
     * Queue a few jobs whenever an entity gets updated
     */
    public function updated(Entity $entity)
    {
        EntityUpdatedJob::dispatch($entity);
        EntityWebhookJob::dispatch($entity, auth()->user(), WebhookAction::EDITED->value);

        // Sometimes we just touch the entity, which should also touch the child
        if ($entity->hasChild() && $entity->child && $entity->updated_at->greaterThan($entity->child->updated_at)) {
            $entity->child->touchSilently();
        }
    }

    public function savePremium(Entity $entity): void
    {
        // Gallery is now available to all
        if (request()->has('entity_image_uuid')) {
            $entity->image_uuid = request()->get('entity_image_uuid');
        } elseif (Domain::isApp()) {
            $entity->image_uuid = null;
        }
        // No changed for non-boosted campaigns
        if (! $entity->campaign->boosted()) {
            return;
        }

        if (request()->has('tooltip')) {
            $entity->tooltip = $this->purify(request()->get('tooltip'));
        }

        // Superboosted image gallery selection
        if (request()->has('entity_header_uuid')) {
            $entity->header_uuid = request()->get('entity_header_uuid');
        } elseif (Domain::isApp()) {
            $entity->header_uuid = null;
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
