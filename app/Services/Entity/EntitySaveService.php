<?php

namespace App\Services\Entity;

use App\Enums\Permission;
use App\Facades\Domain;
use App\Facades\EntityLogger;
use App\Facades\Images;
use App\Facades\Permissions;
use App\Models\Entity;
use App\Services\PermissionService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;
use Stevebauman\Purify\Facades\Purify;

class EntitySaveService
{
    use CampaignAware;
    use EntityAware;
    use UserAware;

    protected bool $permissions = true;

    public function __construct(
        protected TagService $tagService,
        protected PermissionService $permissionService,
    ) {}

    public function skipPermissions(): self
    {
        $this->permissions = false;

        return $this;
    }

    public function save(array $data): Entity
    {
        // Pre-save: scalar entity fields — must all be set before save() so HasEntry fires once
        if (array_key_exists('name', $data)) {
            $this->entity->name = $data['name'];
        }
        if (array_key_exists('is_private', $data)) {
            // Non-admin forms don't expose privacy, and request middleware can
            // represent the missing field as null. Null means public here.
            $this->entity->is_private = $data['is_private'] ?? false;
        }
        if (array_key_exists('type', $data)) {
            $this->entity->type = $data['type'];
        }
        if (array_key_exists('entry', $data)) {
            $this->entity->entry = $data['entry'];
        }
        if (array_key_exists('parent_id', $data)) {
            $this->entity->parent_id = $data['parent_id'];
        }
        if (array_key_exists('status_id', $data)) {
            $this->entity->status_id = $data['status_id'] ?: null;
        }

        $this->applyGalleryFields($data);

        $this->entity->save();

        // Post-save: image file cleanup (safe after save — doesn't affect entity record)
        if (($data['remove-image'] ?? null) == '1') {
            Images::model($this->entity)->field('image')->cleanup();
            $this->entity->saveQuietly();
        }
        if (($data['remove-header_image'] ?? null) == '1') {
            Images::model($this->entity)->field('header_image')->cleanup();
            $this->entity->saveQuietly();
        }

        $this->saveTags($data);
        if ($this->permissions) {
            $this->savePermissions($data);
        }

        return $this->entity;
    }

    protected function applyGalleryFields(array $data): void
    {
        // image_uuid is available to all (not premium-gated)
        if (array_key_exists('entity_image_uuid', $data)) {
            $this->entity->image_uuid = $data['entity_image_uuid'];
        } elseif (array_key_exists('image_uuid', $data)) {
            $this->entity->image_uuid = $data['image_uuid'];
        } elseif (Domain::isApp()) {
            // On the hosted app, a missing key means the user cleared it
            $this->entity->image_uuid = null;
        }

        // tooltip and header_uuid are boosted-campaign features
        if (! $this->entity->campaign->boosted()) {
            return;
        }

        if (array_key_exists('tooltip', $data)) {
            $this->entity->tooltip = Purify::clean($data['tooltip']);
        }

        if (array_key_exists('entity_header_uuid', $data)) {
            $this->entity->header_uuid = $data['entity_header_uuid'];
        } elseif (array_key_exists('header_uuid', $data)) {
            $this->entity->header_uuid = $data['header_uuid'];
        } elseif (Domain::isApp()) {
            $this->entity->header_uuid = null;
        }
    }

    protected function saveTags(array $data): void
    {
        if (! array_key_exists('tags', $data) && ! array_key_exists('save-tags', $data)) {
            return;
        }

        $ids = $data['tags'] ?? [];
        if (! is_array($ids)) {
            // The API can send malformed values
            $ids = [];
        }

        $user = $this->user ?? auth()->user();
        if (! $user) {
            return;
        }

        $this->tagService
            ->user($user)
            ->entity($this->entity)
            ->withNew()
            ->sync($ids);

        // Touch entity to update updated_at if tags changed (but quietly if just created)
        if ($this->tagService->isDirty()) {
            if (EntityLogger::entity($this->entity)->created()) {
                $this->entity->touchQuietly();
            } else {
                $this->entity->touch();
            }
        }
    }

    protected function savePermissions(array $data): void
    {
        $user = $this->user ?? auth()->user();
        if (! $user || ! $user->can('permissions', $this->entity)) {
            return;
        }
        if (array_key_exists('copy_permissions', $data) && ! empty($data['copy_permissions'])) {
            return;
        }
        $permData = array_intersect_key($data, array_flip(['role', 'user', 'is_attributes_private', 'permissions_too_many']));

        // If the user has been granted permissions on this entity, ensure they keep read/write
        if (Permissions::granted() && ! empty($permData['user'])) {
            $userId = $user->id;
            if (! in_array(Permission::Update->value, $permData['user'][$userId] ?? [])) {
                $permData['user'][$userId][Permission::Update->value] = 'allow';
            }
            if (! in_array(Permission::View->value, $permData['user'][$userId] ?? [])) {
                $permData['user'][$userId][Permission::View->value] = 'allow';
            }
        }

        $this->permissionService
            ->user($user)
            ->campaign($this->campaign)
            ->entity($this->entity)
            ->save($permData);
    }
}
