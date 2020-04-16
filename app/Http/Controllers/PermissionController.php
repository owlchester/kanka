<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermission;
use App\Models\Entity;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
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
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Entity $entity)
    {
        $this->authorize('permission', $entity->child);
        $ajax = request()->ajax();

        return view('cruds.permissions', compact('entity', 'ajax'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermission $request, Entity $entity)
    {
        $this->authorize('permission', $entity->child);

        $this->permissionService->saveEntity($request->only('role', 'user'), $entity);

        return redirect()->back()
            ->with('success_raw', trans('crud.permissions.success'));
    }
}
