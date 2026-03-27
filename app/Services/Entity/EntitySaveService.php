<?php

namespace App\Services\Entity;

use App\Enums\Permission;
use App\Facades\Domain;
use App\Facades\EntityLogger;
use App\Facades\Images;
use App\Facades\Permissions;
use App\Models\Entity;
use App\Services\PermissionService;
use Stevebauman\Purify\Facades\Purify;

class EntitySaveService
{
    public function __construct(
        protected TagService $tagService,
        protected PermissionService $permissionService,
    ) {}

    public function save(Entity $entity, array $data): Entity
    {
        // Pre-save: scalar entity fields — must all be set before save() so HasEntry fires once
        if (array_key_exists('name', $data)) {
            $entity->name = $data['name'];
        }
        if (array_key_exists('is_private', $data)) {
            $entity->is_private = $data['is_private'];
        }
        if (array_key_exists('type', $data)) {
            $entity->type = $data['type'];
        }
        if (array_key_exists('entry', $data)) {
            $entity->entry = $data['entry'];
        }
        if (array_key_exists('parent_id', $data)) {
            $entity->parent_id = $data['parent_id'];
        }

        $this->applyGalleryFields($entity, $data);

        $entity->save();

        // Post-save: image file cleanup (safe after save — doesn't affect entity record)
        if (($data['remove-image'] ?? null) == '1') {
            Images::model($entity)->field('image')->cleanup();
        }
        if (($data['remove-header_image'] ?? null) == '1') {
            Images::model($entity)->field('header_image')->cleanup();
        }

        $this->saveTags($entity, $data);
        $this->savePermissions($entity, $data);

        return $entity;
    }

    protected function applyGalleryFields(Entity $entity, array $data): void
    {
        // image_uuid is available to all (not premium-gated)
        if (array_key_exists('entity_image_uuid', $data)) {
            $entity->image_uuid = $data['entity_image_uuid'];
        } elseif (Domain::isApp()) {
            // On the hosted app, a missing key means the user cleared it
            $entity->image_uuid = null;
        }

        // tooltip and header_uuid are boosted-campaign features
        if (! $entity->campaign->boosted()) {
            return;
        }

        if (array_key_exists('tooltip', $data)) {
            $entity->tooltip = Purify::clean($data['tooltip']);
        }

        if (array_key_exists('entity_header_uuid', $data)) {
            $entity->header_uuid = $data['entity_header_uuid'];
        } elseif (Domain::isApp()) {
            $entity->header_uuid = null;
        }
    }

    protected function saveTags(Entity $entity, array $data): void
    {
        if (! array_key_exists('tags', $data) && ! array_key_exists('save-tags', $data)) {
            return;
        }

        $ids = $data['tags'] ?? [];
        if (! is_array($ids)) {
            // The API can send malformed values
            $ids = [];
        }

        $this->tagService
            ->user(auth()->user())
            ->entity($entity)
            ->withNew()
            ->sync($ids);

        // Touch entity to update updated_at if tags changed (but quietly if just created)
        if ($this->tagService->isDirty()) {
            if (EntityLogger::entity($entity)->created()) {
                $entity->touchQuietly();
            } else {
                $entity->touch();
            }
        }
    }

    protected function savePermissions(Entity $entity, array $data): void
    {
        if (! auth()->user()->can('permissions', $entity)) {
            return;
        }
        if (array_key_exists('copy_permissions', $data) && ! empty($data['copy_permissions'])) {
            return;
        }
        if (($data['quick-creator'] ?? null) === '1') {
            return;
        }

        $permData = array_intersect_key($data, array_flip(['role', 'user', 'is_attributes_private', 'permissions_too_many']));

        // If the user has been granted permissions on this entity, ensure they keep read/write
        if (Permissions::granted() && ! empty($permData['user'])) {
            $userId = auth()->user()->id;
            if (! in_array(Permission::Update->value, $permData['user'][$userId] ?? [])) {
                $permData['user'][$userId][Permission::Update->value] = 'allow';
            }
            if (! in_array(Permission::View->value, $permData['user'][$userId] ?? [])) {
                $permData['user'][$userId][Permission::View->value] = 'allow';
            }
        }

        $this->permissionService
            ->user(auth()->user())
            ->entity($entity)
            ->save($permData);
    }
}
