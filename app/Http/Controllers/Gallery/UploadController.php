<?php

namespace App\Http\Controllers\Gallery;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\UploadFile;
use App\Http\Requests\Gallery\UploadUrl;
use App\Models\Campaign;
use App\Services\Gallery\UploadService;

class UploadController extends Controller
{
    protected UploadService $service;

    public function __construct(UploadService $uploadService)
    {
        $this->service = $uploadService;
    }

    public function file(UploadFile $request, Campaign $campaign)
    {
        $this->authorize('galleryUpload', $campaign);

        try {
            return response()->json(
                $this->service
                    ->campaign($campaign)
                    ->user($request->user())
                    ->file($request->file('file'))
            );
        } catch (TranslatableException $e) {
            return response()->json(
                ['error' => $e->getTranslatedMessage()],
                421
            );
        }
    }

    public function url(UploadUrl $request, Campaign $campaign)
    {
        $this->authorize('galleryUpload', $campaign);

        try {
            return response()->json(
                $this->service
                    ->campaign($campaign)
                    ->user($request->user())
                    ->url($request->get('url'))
            );
        } catch (TranslatableException $e) {
            return response()->json(
                ['error' => $e->getTranslatedMessage()],
                421
            );
        }
    }
}
