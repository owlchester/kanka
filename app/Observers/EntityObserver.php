<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Facades\EntityPermission;
use App\Jobs\EntityUpdatedJob;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\Tag;
use App\Services\AttributeService;
use App\Services\ImageService;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Auth;

class EntityObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * @var AttributeService
     */
    protected $attributeService;

    /**
     * @var bool
     */
    protected $permissionGrantSelf = false;

    /**
     * PermissionController constructor.
     * @param PermissionService $permissionService
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
        // Only save tags if we are in a form. But we should probably move this?
        $ids = request()->post('tags', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($entity->tags()->with('entity')->has('entity')->get() as $tag) {
            if (EntityPermission::canView($tag->entity)) {
                $existing[$tag->id] = $tag->name;
            }
        }
        $new = [];
        $canCreateTags = auth()->user()->can('create', Tag::class);

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $tag = Tag::find($id);
                // Create the tag if the user has permission to do so
                if (empty($tag) && $canCreateTags) {
                    $tag = new Tag([
                        'name' => $id
                    ]);
                    $tag->saveImageObserver = false;
                    $tag->save();
                }

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
     * @param Entity $entity
     */
    public function savePermissions(Entity $entity)
    {
        if (!auth()->user()->can('permission', $entity->child)) {
            return;
        } elseif (request()->has('copy_source_permissions') && request()->filled('copy_source_permissions')) {
            return;
        }

        $data = request()->only('role', 'user', 'is_attributes_private', 'permissions_too_many');

        // If the user granted/assigned themselves read/write permissions on the entity, we need to make sure they
        // still have them even if not checked in the UI.
        if (EntityPermission::granted() && !empty($data['user'])) {
            $user = auth()->user()->id;
            if (!in_array('edit', $data['user'][$user])) {
                $data['user'][$user]['edit'] = 'allow';
            }
            if (!in_array('read', $data['user'][$user])) {
                $data['user'][$user]['read'] = 'allow';
            }
        }

        $this->permissionService->saveEntity($data, $entity);
    }

    /**
     * @param Entity $entity
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
            'attr_is_star',
            'attr_type',
            'template_id',
            'is_attributes_private'
        );
        $this->attributeService->saveEntity($data, $entity);

        return $this;
    }

    /**
     * @param Entity $entity
     */
    public function created(Entity $entity)
    {
        // If the user has created a new entity but doesn't have the permission to read or edit it,
        // automatically creates said permission.
        if (!auth()->user()->can('view', $entity->child)) {
            $permission = new CampaignPermission();
            $permission->entity_id = $entity->id;
            $permission->user_id = auth()->user()->id;
            $permission->key = $entity->type() . '_read_' . $entity->entity_id;
            $permission->table_name = $entity->pluralType();
            $permission->access = true;
            $permission->save();
            EntityPermission::grant($entity);
            $this->permissionGrantSelf = true;
        }
        if (!auth()->user()->can('update', $entity->child)) {
            $permission = new CampaignPermission();
            $permission->entity_id = $entity->id;
            $permission->user_id = auth()->user()->id;
            $permission->key = $entity->type() . '_edit_' . $entity->entity_id;
            $permission->table_name = $entity->pluralType();
            $permission->access = true;
            $permission->save();
            EntityPermission::grant($entity, 'edit');
            $this->permissionGrantSelf = true;
        }

        // Refresh the model because adding permissions to the child means we have a new relation
        if ($this->permissionGrantSelf) {
            $entity->unsetRelation('child');
            $entity->reloadChild();
        }

        if (!request()->has('attr_name')) {
            $this->attributeService->applyEntityTemplates($entity);
        }
    }

    /**
     * @param Entity $entity
     */
    public function updated(Entity $entity)
    {
        //EntityCache::clearEntity($entity->id);

        // Queue job when an entity was updated
        EntityUpdatedJob::dispatch($entity);
    }

    /**
     * @param Entity $entity
     */
    public function saveBoosted(Entity $entity): void
    {
        // No changed for non-boosted campaigns
        $campaign = CampaignLocalization::getCampaign();
        if (!$campaign->boosted()) {
            return;
        }

        if (request()->has('entity_tooltip')) {
            $entity->tooltip = $this->purify(request()->get('entity_tooltip'));
        }


        // Handle map. Let's use a service for this.
        ImageService::entity($entity, 'campaign/' . $entity->campaign_id, false, 'header_image');

        // Superboosted image gallery selection
        if ($campaign->boosted(true)) {
            if (request()->has('entity_image_uuid')) {
                $entity->image_uuid = request()->get('entity_image_uuid');
            } else {
                $entity->image_uuid = null;
            }
            if (request()->has('entity_header_uuid')) {
                $entity->header_uuid = request()->get('entity_header_uuid');
            } else {
                $entity->header_uuid = null;
            }
        }

        $entity->save();
    }

    /**
     * @param Entity $entity
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
