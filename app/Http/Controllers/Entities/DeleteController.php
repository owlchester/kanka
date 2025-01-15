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

        return redirect()->route('entities.index', [$campaign, $entity->entityType])
            ->with('success_raw', __('general.success.deleted-cancel', [
                'name' => $entity->name,
                'cancel' => '<a href="' . route('recovery', $campaign) . '">' . __('crud.cancel') . '</a>'
            ]));
    }
}
