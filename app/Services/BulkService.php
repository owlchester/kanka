<?php

namespace App\Services;

use App\Exceptions\TranslatableException;
use Illuminate\Support\Facades\Auth;
use App\Models\MiscModel;
use Exception;

class BulkService
{
    /**
     * @var EntityService
     */
    protected $entityService;

    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var array
     */
    protected $ids;

    /**
     * BulkService constructor.
     * @param EntityService $entityService
     * @param PermissionService $permissionService
     */
    public function __construct(EntityService $entityService, PermissionService $permissionService)
    {
        $this->entityService = $entityService;
        $this->permissionService = $permissionService;
    }

    /**
     * @param string $entityName
     * @return $this
     */
    public function entity(string $entityName)
    {
        $this->entityName = $entityName;
        return $this;
    }

    /**
     * @param array $ids
     * @return $this
     */
    public function entities(array $ids = [])
    {
        $this->ids = $ids;
        return $this;
    }

    /**
     * Delete several entities
     * @param string $entityName
     * @param array $ids
     * @return int
     * @throws Exception
     */
    public function delete()
    {
        $model = $this->getEntity();

        $count = 0;
        foreach ($this->ids as $id) {
            $entity = $model->find($id);
            if (Auth::user()->can('delete', $entity)) {
                //dd($entity->descendants);
                $entity->delete();
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param $entityName
     * @param array $ids
     * @return array
     * @throws Exception
     */
    public function export()
    {
        $model = $this->getEntity();
        $entities = [];
        foreach ($this->ids as $id) {
            $entities[] = $model->findOrFail($id);
        }
        return $entities;
    }

    /**
     * @param string $entityName
     * @param array $ids
     * @return int
     */
    public function makePrivate()
    {
        return $this->switchPrivate(true);
    }

    /**
     * @param string $entityName
     * @param array $ids
     * @return int
     */
    public function makePublic()
    {
        return $this->switchPrivate(false);
    }

    /**
     * Set permissions for several entities
     * @param array $users
     * @param array $roles
     * @return int number of updated entities
     */
    public function permissions(array $permissions = [], bool $override = true): int
    {
        $count = 0;
        $model = $this->getEntity();

        foreach ($this->ids as $id) {
            $entity = $model->findOrFail($id);
            if (Auth::user()->can('update', $entity)) {
                $this->permissionService->change($permissions, $entity->entity, $override);
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param bool $private
     * @return int
     * @throws TranslatableException
     */
    protected function switchPrivate(bool $private = true)
    {
        if (!Auth::user()->isAdmin()) {
            throw new TranslatableException("crud.bulk.errors.admin");
        }

        // Don't want other stuff happening while saving
        define('MISCELLANY_SKIP_ENTITY_CREATION', true);

        $model = $this->getEntity();
        $count = 0;
        foreach ($this->ids as $id) {
            /** @var MiscModel $entity */
            $entity = $model->findOrFail($id);
            if (Auth::user()->can('update', $entity) && $entity->is_private != $private) {
                // Todo: still needed?
                //$entity->savingObserver = false;
                $entity->is_private = $private;
                $entity->save();
                $count++;
            }
        }

        return $count;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getEntity()
    {
        $entity = $this->entityService->getClass($this->entityName);
        if (empty($entity)) {
            throw new Exception("Unknown entity name {$this->entityName}.");
        }

        $model = new $entity();
        if (empty($model)) {
            throw new Exception("Couldn't create a class from {$this->entity}.");
        }

        return $model;
    }
}
