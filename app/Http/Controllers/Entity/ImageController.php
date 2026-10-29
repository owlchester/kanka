<?php

namespace App\Http\Controllers\Entity;

use App\Facades\Avatar;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageFocus;
use App\Http\Requests\UpdateEntityImage;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Image;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @throws AuthorizationException
     */
    public function focus(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        return view('entities.pages.image.focus')
            ->with('campaign', $campaign)
            ->with('entity', $entity);
    }

    /**
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function saveFocus(StoreImageFocus $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        abort_unless($campaign->boosted(), 403);

        // Gallery image?
        $imageUuid = $request->validated('image_uuid');
        $source = $imageUuid
            ? Image::where('campaign_id', $campaign->id)->findOrFail($imageUuid)
            : (empty($entity->image_path) && $entity->image ? $entity->image : $entity);

        if ($source instanceof Image && $entity->image_uuid !== $source->id) {
            $this->authorize('view', [$source, $campaign]);
        }

        $source->focus_x = $request->validated('focus_x');
        $source->focus_y = $request->validated('focus_y');
        $source->save();

        if ($request->expectsJson()) {
            return response()->json([
                'toast' => __('entities/image.focus.success'),
                'thumbnail' => $source instanceof Image
                    ? $source->getUrl(160, 160)
                    : Avatar::entity($entity)->size(160, 160)->thumbnail(),
            ]);
        }

        return redirect()
            ->to($entity->url())
            ->with('success', __('entities/image.focus.success'));
    }

    public function focusImage(Campaign $campaign, Entity $entity, Image $image)
    {
        $this->authorize('update', $entity);
        abort_unless($campaign->boosted(), 403);
        abort_unless($image->campaign_id === $campaign->id, 404);
        if ($entity->image_uuid !== $image->id) {
            $this->authorize('view', [$image, $campaign]);
        }

        return response()->json([
            'url' => $image->url(),
            'focus_x' => $image->focus_x,
            'focus_y' => $image->focus_y,
        ]);
    }

    /**
     * @throws AuthorizationException
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
