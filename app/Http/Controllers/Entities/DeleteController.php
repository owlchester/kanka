<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;

class DeleteController extends Controller
{
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('delete', $entity);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $entity->delete();

        $routeName = $entity->entityType->isSpecial() ? 'entities' : $entity->entityType->pluralCode();
        $params = $entity->entityType->isSpecial() ? [$campaign, $entity->entityType] : [$campaign];

        return redirect()->route($routeName . '.index', $params)
            ->with('success_raw', __('general.success.deleted-cancel', [
                'name' => $entity->name,
                'cancel' => '<a href="' . route('recovery', $campaign) . '">' . __('crud.cancel') . '</a>'
            ]));
    }
}
