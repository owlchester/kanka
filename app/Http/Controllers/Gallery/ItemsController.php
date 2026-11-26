<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Gallery\SetupService;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function __construct(
        protected SetupService $service
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request, Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $folderId = $request->query('folder');
        $folder = null;
        if (! empty($folderId) && is_string($folderId)) {
            $folder = Image::where('campaign_id', $campaign->id)
                ->where('is_folder', true)
                ->where('id', $folderId)
                ->first();
        }

        $service = $this->service
            ->user($request->user())
            ->campaign($campaign)
            ->term(mb_trim((string) ($request->query('q') ?? $request->query('term') ?? '')))
            ->filters($request->only([
                'scope',
                'usage',
                'unused',
                'type',
                'visibility_id',
                'created_by',
                'orientation',
                'per_page',
                'image',
            ]))
            ->sort($request->only(['sort']));

        if ($folder) {
            $service->image($folder);
        }

        return response()->json($service->items());
    }
}
