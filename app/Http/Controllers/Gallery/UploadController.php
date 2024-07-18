<?php

namespace App\Http\Controllers\Gallery;

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

        return response()->json(
            $this->service
                ->campaign($campaign)
                ->request($request)
                ->file()
        );
    }

    public function url(UploadUrl $request, Campaign $campaign)
    {
        $this->authorize('galleryUpload', $campaign);

        return response()->json(
            $this->service
                ->campaign($campaign)
                ->request($request)
                ->url()
        );
    }
}
