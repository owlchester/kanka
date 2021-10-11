<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Http\Requests\API\UploadEntityImage;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\ImageService;
use Illuminate\Http\Request;

class EntityImageApiController extends Controller
{
    public function put(UploadEntityImage $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);

        /** @var MiscModel $child */
        $child = $entity->child;

        // Let the service handle everything
        ImageService::handle($child);
        $child->update(['image']);

        return response()->json([
            'entity_id' => $entity->id,
            'child_id' => $child->id,
            'image_full' => !empty($child->image) ? $child->getImageUrl(0) : ($entity->image ? $entity->image->getImagePath(0) : null),
            'image_thumb' => $child->getImageUrl(40),
        ],200);
    }

    public function destroy(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);

        /** @var MiscModel $child */
        $child = $entity->child;

        // Let the service handle everything
        ImageService::cleanup($child);

        $child->update(['image']);

        return response()->json([
            'entity_id' => $entity->id,
            'child_id' => $child->id,
            'image_full' => !empty($child->image) ? $child->getImageUrl(0) : ($entity->image ? $entity->image->getImagePath(0) : null),
            'image_thumb' => $child->getImageUrl(40),
        ],200);
    }
}
