<?php


namespace App\Http\Controllers\Entity;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageFocus;
use App\Http\Requests\UpdateEntityImage;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function focus(Entity $entity)
    {
        if (!Auth::check()) {
            return abort(400);
        } else {
            $this->authorize('update', $entity->child);
        }

        return view('entities.pages.image.focus')
            ->with('entity', $entity)
            ->with('model', $entity->child);
    }

    /**
     * @param StoreImageFocus $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function saveFocus(StoreImageFocus $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $entity->focus_x = $request->post('focus_x');
        $entity->focus_y = $request->post('focus_y');
        $entity->save();


        return redirect()
            ->to($entity->url())
            ->with('success', __('entities/image.focus.success'));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function replace(Entity $entity)
    {
        if (!Auth::check()) {
            return abort(400);
        } else {
            $this->authorize('update', $entity->child);
        }

        return view('entities.pages.image.replace')
            ->with('entity', $entity)
            ->with('model', $entity->child);
    }

    /**
     * @param UpdateEntityImage $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateEntityImage $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $oldImage = $entity->child->image;
        $oldBoostedImage = $entity->image_uuid;

        $entity->child->update(
            []
        );

        if ($entity->campaign->boosted(true)) {
            if (request()->has('entity_image_uuid')) {
                $entity->image_uuid = request()->get('entity_image_uuid');
            } else {
                $entity->image_uuid = null;
            }
            $entity->save();
        }

        $resetFocus = false;
        if ($oldImage != $entity->child->image || $oldBoostedImage != $request->get('entity_image_uuid')) {
            $resetFocus = true;
        }

        // Changed the image, reset the focus
        if ($resetFocus) {
            $entity->focus_x = null;
            $entity->focus_y = null;
            $entity->save();
        }

        return redirect()
            ->to($entity->url())
            ->with('success', __('entities/image.replace.success'));
    }
}
