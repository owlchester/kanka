<?php

namespace App\Observers;

use App\Facades\EntityPermission;
use App\Facades\Identity;
use App\Jobs\EntityUpdatedJob;
use App\Models\AttributeTemplate;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\EntityLog;
use App\Models\Tag;
use App\Services\AttributeService;
use App\Services\PermissionService;

class EntityObserver
{
    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * @var AttributeService
     */
    protected $attributeService;

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
        foreach ($entity->tags()->with('entity')->get() as $tag) {
            if (EntityPermission::canView($tag->entity)) {
                $existing[$tag->id] = $tag->name;
            }
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $section = Tag::find($id);
                if (empty($section)) {
                    // Create it, the id contains the name
                    $section = Tag::create([
                        'name' => $id
                    ]);
                }
                $new[] = $section->id;
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
        $this->permissionService->saveEntity(request()->only('role', 'user'), $entity);
    }

    /**
     * @param Entity $entity
     * @throws \Exception
     */
    protected function saveAttributes(Entity $entity)
    {
        // If we're not in an interface that has attributes, don't go any further
        if (!request()->has('attr_name')) {
            return false;
        }
        $data = request()->only(
            'attr_name',
            'attr_value',
            'attr_is_private',
            'attr_is_star',
            'attr_type',
            'template_id'
        );
        $this->attributeService->saveEntity($data, $entity);
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
            $permission->key = $entity->type . '_read_' . $entity->entity_id;
            $permission->table_name = $entity->pluralType();
            $permission->save();
        }
        if (!auth()->user()->can('update', $entity->child)) {
            $permission = new CampaignPermission();
            $permission->entity_id = $entity->id;
            $permission->user_id = auth()->user()->id;
            $permission->key = $entity->type . '_edit_' . $entity->entity_id;
            $permission->table_name = $entity->pluralType();
            $permission->save();
        }

        // Creation log
        $log = new EntityLog();
        $log->entity_id = $entity->id;
        $log->created_by = auth()->user()->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = EntityLog::ACTION_CREATE;
        $log->save();

        if (!request()->has('attr_name')) {
            $this->attributeService->applyEntityTemplates($entity);
        }
    }

    /**
     * @param Entity $entity
     */
    public function updated(Entity $entity)
    {
        // Creation log
        $log = new EntityLog();
        $log->entity_id = $entity->id;
        $log->created_by = auth()->user()->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = EntityLog::ACTION_UPDATE;
        $log->save();

        // Queue job when an entity was updated
        EntityUpdatedJob::dispatch($entity);
    }

    /**
     * @param Entity $entity
     */
    public function deleting(Entity $entity)
    {
        // Delete permissions related to this entity
        $entity->permissions()->delete();
    }

    /**
     * @param Entity $entity
     */
    public function deleted(Entity $entity)
    {
        $entity->widgets()->delete();
    }
}
