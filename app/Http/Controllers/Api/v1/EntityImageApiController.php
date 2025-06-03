<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\UploadFile;
use App\Http\Resources\Api\EntityImagesResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Gallery\UploadService;
use Illuminate\Http\Request;

class EntityImageApiController extends Controller
{
    public function __construct(public UploadService $uploadService) {}

    public function show(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new EntityImagesResource($entity);
    }

    public function put(UploadFile $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $this->authorize('galleryUpload', $campaign);
        try {
            $this->uploadService
                ->campaign($campaign)
                ->user($request->user())
                ->file($request->file('file'));
            $image = $this->uploadService->image();
            $field = $request->filled('is_header') ? 'header_uuid' : 'image_uuid';
            $entity->update([$field => $image->id]);

            return new EntityImagesResource($entity);
        } catch (TranslatableException $e) {
            return response()->json(
                ['error' => $e->getTranslatedMessage()],
                421
            );
        }
    }

    public function destroy(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);

        $field = $request->filled('is_header') ? 'header_uuid' : 'image_uuid';
        $entity->update([$field => null]);

        return new EntityImagesResource($entity);
    }
}
