<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageFocus;
use App\Http\Requests\UpdateEntityImage;
use App\Models\Campaign;
use App\Models\Entity;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function focus(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        return view('entities.pages.image.focus')
            ->with('campaign', $campaign)
            ->with('entity', $entity);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function saveFocus(StoreImageFocus $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        // Gallery image?
        $source = empty($entity->image_path) && $entity->image ? $entity->image : $entity;

        $source->focus_x = (int) $request->post('focus_x');
        $source->focus_y = (int) $request->post('focus_y');
        $source->save();

        return redirect()
            ->to($entity->url())
            ->with('success', __('entities/image.focus.success'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function replace(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        return view('entities.pages.image.replace')
            ->with('campaign', $campaign)
            ->with('entity', $entity);
    }

    public function update(UpdateEntityImage $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $entity->image_uuid = request()->get('entity_image_uuid');
        // New image requires a focus reset
        if ($entity->isDirty(['image_uuid'])) {
            $entity->focus_x = null;
            $entity->focus_y = null;
        }
        $entity->save();

        return redirect()
            ->to($entity->url())
            ->with('success', __('entities/image.replace.success'));
    }
}
