<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermission;
use App\Models\Entity;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PermissionController extends CrudController
{
    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * PermissionController constructor.
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;

        return parent::__construct();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function permissions(StorePermission $request, Entity $entity)
    {
        $this->authorize('permission', $entity->child);

        $this->permissionService->saveEntity($request->only('role', 'user'), $entity);

        return redirect()->route($entity->pluralType() . '.show', [$entity->child->id, 'tab' => 'permissions'])
            ->with('success_raw', trans('crud.permissions.success'));

    }
}
