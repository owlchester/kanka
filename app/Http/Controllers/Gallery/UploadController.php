<?php

namespace App\Http\Controllers\Gallery;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\UploadFile;
use App\Http\Requests\Gallery\UploadFiles;
use App\Http\Requests\Gallery\UploadUrl;
use App\Models\Campaign;
use App\Services\Gallery\StorageService;
use App\Services\Gallery\UploadService;

class UploadController extends Controller
{
    protected UploadService $service;

    protected StorageService $storage;

    public function __construct(UploadService $uploadService, StorageService $storageService)
    {
        $this->service = $uploadService;
        $this->storage = $storageService;
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

    public function files(UploadFiles $request, Campaign $campaign)
    {
        $this->authorize('galleryUpload', $campaign);

        try {
            $files = $this->service
                ->campaign($campaign)
                ->user($request->user())
                ->folder($request->get('folder_id', ''))
                ->files((array) $request->file('files'));
            $this->storage->campaign($campaign)->clearCache();

            return response()->json([
                'files' => $files,
                'used' => $this->storage->uncachedUsedSpace(),
            ]);
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
                    ->request($request)
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
