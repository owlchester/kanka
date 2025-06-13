<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermission;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\PermissionService;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function view(Campaign $campaign, Entity $entity)
    {
        $this->authorize('permissions', $entity);

        return view('cruds.permissions', compact('entity', 'campaign'));
    }

    public function store(StorePermission $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('permissions', $entity);

        $this->permissionService
            ->user($request->user())
            ->entity($entity)
            ->save($request->only('role', 'user'));

        return redirect()->back()
            ->with('success_raw', __('crud.permissions.success'));
    }
}
