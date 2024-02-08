<?php

namespace App\Observers;

use App\Facades\Permissions;
use App\Jobs\EntityUpdatedJob;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\Tag;
use App\Services\AttributeService;
use App\Services\Entity\TagService;
use App\Services\ImageService;
use App\Services\PermissionService;
use Illuminate\Support\Str;
use App\Facades\Domain;

class EntityObserver
{
    use PurifiableTrait;

    protected PermissionService $permissionService;

    protected AttributeService $attributeService;

    /**
     * PermissionController constructor.
     */
    public function __construct(PermissionService $permissionService, AttributeService $attributeService)
    {
        $this->permissionService = $permissionService;
        $this->attributeService = $attributeService;
    }

    /**
     * An entity has been saved from the crud
     */
    public function crudSaved(Entity $entity)
    {
        $this->saveTags($entity);
        $this->savePermissions($entity);
        $this->saveAttributes($entity);
        $this->saveBoosted($entity);
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

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        /** @var Tag $tag */
        foreach ($entity->tags()->with('entity')->has('entity')->get() as $tag) {
            if ($tag->entity) {
                $existing[$tag->id] = $tag->name;
            }
        }
        $new = [];

        /** @var TagService $tagService */
        $tagService = app()->make(TagService::class);
        $tagService->user(auth()->user());

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $tag = $tagService->fetch($id, $entity->campaign_id);
                if (!empty($tag)) {
                    $new[] = $tag->id;
                }
            }
        }
        $entity->tags()->attach($new);

        // Detatch the remaining
        if (!empty($existing)) {
            $entity->tags()->detach(array_keys($existing));
        }
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
     * @return $this
     * @throws \Exception
     */
    protected function saveAttributes(Entity $entity): self
    {
        // If we're not in an interface that has attributes, don't go any further
        if (!request()->has('attr_name') && !request()->has('save-attributes') || !auth()->user()->can('attributes', $entity)) {
            return $this;
        }
        $data = request()->only(
            'attr_name',
            'attr_value',
            'attr_is_private',
            'attr_is_pinned',
            'attr_type',
            'template_id',
            'is_attributes_private'
        );
        $this->attributeService->entity($entity)->save($data);
        $sourceId = request()->post('copy_source_id');

        if (request()->has('replace_mentions') && request()->filled('replace_mentions') && $entity->child->isFillable('entry')) {
            $source = Entity::findOrFail($sourceId);
            $sourceAttributes = [];
            $entityAttributes = [];
            foreach ($source->attributes as $attribute) {
                array_push($sourceAttributes, '{attribute:' . $attribute->id . '}');
            }
            foreach ($entity->attributes as $attribute) {
                array_push($entityAttributes, '{attribute:' . $attribute->id . '}');
            }
            //$attributes = array_combine($sourceAttributes, $entityAttributes);
            $entry = Str::replace($sourceAttributes, $entityAttributes, $entity->child->entry);
            $entity->child->update(['entry' => $entry]);
            foreach ($entity->posts as $post) {
                $post->entry = Str::replace($sourceAttributes, $entityAttributes, $post->entry);
                $post->updateQuietly();
            }
        }
        return $this;
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

        if (!request()->has('attr_name')) {
            $this->attributeService->applyEntityTemplates($entity);
        }
    }

    /**
     */
    public function updated(Entity $entity)
    {
        //EntityCache::clearEntity($entity->id);

        // Queue job when an entity was updated
        EntityUpdatedJob::dispatch($entity);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveBoosted(Entity $entity): void
    {
        // Gallery is now available to all
        if (request()->has('entity_image_uuid')) {
            $entity->image_uuid = request()->get('entity_image_uuid');
        } elseif (Domain::isApp()) {
            $entity->image_uuid = null;
        }
        // No changed for non-boosted campaigns
        if (!$entity->campaign->boosted()) {
            $entity->save();
            return;
        }

        if (request()->has('entity_tooltip')) {
            $entity->tooltip = $this->purify(request()->get('entity_tooltip'));
        }


        // Handle map. Let's use a service for this.
        ImageService::entity($entity, 'campaign/' . $entity->campaign_id, 'header_image');

        // Superboosted image gallery selection
        if ($entity->campaign->superboosted()) {
            if (request()->has('entity_header_uuid')) {
                $entity->header_uuid = request()->get('entity_header_uuid');
            } elseif (Domain::isApp()) {
                $entity->header_uuid = null;
            }
        }

        $entity->save();
    }

    /**
     */
    public function deleted(Entity $entity)
    {
        // If soft deleting, don't really delete the image
        if ($entity->trashed()) {
            return;
        }

        $entity->permissions()->delete();
        $entity->widgets()->delete();
    }
}
