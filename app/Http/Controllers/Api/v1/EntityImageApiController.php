<?php

namespace App\Http\Controllers\Api\v1;

use App\Facades\Avatar;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\UploadEntityImage;
use App\Models\Campaign;
use App\Models\Entity;
use App\Facades\Images;

class EntityImageApiController extends Controller
{
    public function put(UploadEntityImage $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);

        // Let the service handle everything
        throw new \Exception('API hasnt been migrated');
        //        $entity->update();
        //
        //        return response()->json([
        //            'entity_id' => $entity->id,
        //            'child_id' => $entity->child->id,
        //            'image_full' => Avatar::entity($entity)->original(),
        //            'image_thumb' => Avatar::entity($entity)->size(40)->thumbnail(),
        //        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);

        // Let the service handle everything
        Images::cleanup($entity);

        $entity->update(['image_path' => '']);

        return response()->json([
            'entity_id' => $entity->id,
            'child_id' => $entity->child->id,
            'image_full' => Avatar::entity($entity)->original(),
            'image_thumb' => Avatar::entity($entity)->size(40)->thumbnail(),
        ], 200);
    }
}
