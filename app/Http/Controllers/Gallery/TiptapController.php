<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreImage;
use App\Http\Resources\Gallery\Tiptap\ImageResource;
use App\Models\Campaign;
use App\Services\Gallery\TiptapService;
use Illuminate\Http\Request;

class TiptapController extends Controller
{
    public function __construct(protected TiptapService $service)
    {

    }
    public function index(Request $request, Campaign $campaign)
    {
        $this->authorize('galleryBrowse', $campaign);

        return ImageResource::collection(
            $this->service
                ->campaign($campaign)
                ->user($request->user())
                ->request($request)
                ->images()
        );
    }
}
